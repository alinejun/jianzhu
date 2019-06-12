<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/4/20
 * Time: 18:11
 */

namespace app\api\controller;
use app\api\model\Company;
use app\Code;

class ProjectSecond extends ApiBase{

    private $project_model;

    public function __construct()
    {
        $this->project_model = new \app\api\model\Project();
        parent::__construct();
    }

    /**
     * 搜索--关键字提示
     * @return mixed
     */
    public function getCompanyByKeywords()
    {
        $keywords = input('get.keywords');
        $pageSize = input('get.size')?:10;
        $company_list = Company::getNameByKeywords($keywords,"company_url,company_name",$pageSize);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $company_list;
        return $this->apiReturn($refer);
    }

    /**
     * 根据company_url获取项目
     *
     * 获取项目基础数据以及相关详细数据
     */
    public function getProjectByCompanyurl()
    {
        $where['company_url'] = input('param.company_url')?:1;
        $pageSize = input('param.size')?:10;
        $pageNum = input('param.page')?:1;
        //基础+详情
        $field = "p.project_url,p.project_name,p.project_area,p.project_unit,p.project_type,p.project_nature,p.project_use,p.project_allmoney,p.project_acreage,p.project_level";
        $project_list = $this->project_model->getProjectV2($where,$field,$pageSize,$pageNum);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $project_list['projectInfo'];
        $refer['page'] = $pageNum;
        $refer['page_total'] = $project_list['totalpage'];
        $refer['num_total'] = $project_list['totalNum'];
        return $this->apiReturn($refer);
    }


    /*
     * 根据project_url 和 company_url 查项目的详情
     * */
    public function getProjectDetail(){
        $company_url = input('param.company_url')?:1;
        $project_url = input('param.project_url')?:1;
        // 招投标-1, 施工图审查-2, 合同备案-3, 施工许可-4, 竣工验收备案-5
        $detail_type = input('param.detail_type')?:'error';
        $project_detail = $this->project_model->getProjectDetailV2($project_url,$company_url,$detail_type);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $project_detail;
        return $this->apiReturn($refer);
    }

    /*
    * 导出特定企业的项目 以及 详情
    */
    public function exportProjectV2(){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);
        config(  'datetime_format' , false);
        $company_url = input('param.company_url')?:1;
        $list = $this->getDataForExport($company_url);
        $titles =
            "项目标记,项目名称,所在区划,建设单位,项目分类,建设性质,工程用途,总投资,总面积,立项级别,招标类型,招标方式,中标单位名称,中标日期,中标金额(万元),面积（平方米）,招标代理单位名称,项目经理/总监理工程师姓名,项目经理/总监理工程师身份证号码,合同金额（万元）,面积（平方米）,发证日期,勘察单位,设计单位,监理单位,施工单位,项目经理,项目经理身份证,项目总监,项目总监身份证,合同类别,合同金额（万元）,合同签订日期,建设规模,发包单位,承包单位,实际造价（万元）,实际面积（平方米）,实际开工日期,实际竣工验收日期,设计单位,监理单位,施工单位";
        $keys   =
            "project_url,project_name,project_area,project_unit,project_type,project_nature,project_use,project_allmoney,project_acreage,project_level,bid_type,bid_way,bid_unitname,bid_date,bid_money,bid_area,bid_unitagency,bid_pname,bid_pnum,permit_money,permit_area,permit_certdate,permit_unitrcs,permit_unitdsn,permit_unitspv,permit_unitcst,permit_manager,permit_managerid,permit_monitor,permit_monitorid,contract_type,contract_money,contract_signtime,contract_scale,company_out_name,contract_unitname,finish_money,finish_area,finish_realbegin,finish_realfinish,finish_unitdsn,finish_unitspv,finish_unitcst";
         $path = export_excel_v1($titles, $keys, $list, '企业所做项目');
        return $this->apiReturn(['path'=>$path]);
    }

    public function getDataForExport($company_url){
        $list_arr = $this->project_model->getDataForExportV2($company_url);
        return $this->formatData($list_arr);
    }

    private function formatData($list){
        /*
         * 清洗(格式化)数据的算法
         * 每个项目下有5个子类，4个子类被导出
         * 单个子类中不能有重复的数据(根据每个子类中的特定字段做区分)，重复的数据将这条子类全部置为null，
         * 如果子类全部都为null 那么把这条数据 unset
         *
         * @params array
         *
         * @return array 清洗后
         * */
        if (empty($list)){
            return [];
        }
        foreach ($list as $key=>$value){
            if ($key == 0){
                # init
                $tempProjectUrl = $value['project_url'];
                $tempArr[] = $value;
            }
            if ($key > 0){
                if ($value['project_url'] == $tempProjectUrl){
                    // 与上一条是同一个项目
                    # 分别对比 招投标 施工 合同 竣工
                    # 招投标 对比中标金额
                    foreach ($tempArr as $ke=>$va){
                        if ($value['bid_money'] == $va['bid_money']){
                            $list[$key] = $this->fixPrefixToNull($list[$key],'bid');
                        }
                    }
                    # 施工 对比合同金额
                    foreach ($tempArr as $ke=>$va){
                        if ($value['permit_money'] == $va['permit_money']){
                            $list[$key] = $this->fixPrefixToNull($list[$key],'permit');
                        }
                    }
                    # 合同 对比合同金额
                    foreach ($tempArr as $ke=>$va){
                        if ($value['contract_money'] == $va['contract_money']){
                            $list[$key] = $this->fixPrefixToNull($list[$key],'contract');
                        }
                    }
                    # 竣工 对比实际造价
                    foreach ($tempArr as $ke=>$va){
                        if ($value['finish_money'] == $va['finish_money']){
                            $list[$key] = $this->fixPrefixToNull($list[$key],'finish');
                        }
                    }
                    // 对比完成之后 如果有子类全空的 则 删除
                    if ($list[$key]['bid_money'] == null && $list[$key]['permit_money'] == null && $list[$key]['contract_money'] == null && $list[$key]['finish_money'] == null){
                        unset($list[$key]);
                    }else{
                        // 如果没有被删除,则留入给下一次比较
                        $tempArr[] = $list[$key];
                    }
                }else{
                    // 与上一条不是一个项目、
                    // 更新
                    $tempProjectUrl = $value['project_url'];
                    unset($tempArr);
                    $tempArr[] = $value;
                }
            }
        }
        $list = array_values($list);
        return $list;
    }

    /*
     * 根据字段的前缀，给特定的字段赋空值
     *
     * @params
     *  $value array 一条数据
     *  $prefix string 指定前缀
     *  $null null 空值定义
     *
     * @return
     *  $value array 被置空了指定字段的一条数据
     * */
    private function fixPrefixToNull($value,$prefix,$null=null){
        foreach ($value as $k=>$v){
            list($pre) = explode('_',$k);
            if ($pre == $prefix){
                $value[$k] = $null;
            }
        }
        return $value;
    }

    /*
     * 根据company_url，查询企业对应的资质类别和名称
     *
     * @params
     *  $company_url 企业URL
     *
     * @return mixed 企业对应资质类别和名称
     * */
    public function getCompanyInfoByUrl(){
        $company_url = input('param.company_url')?:1;
        $companyInfo = Company::getCompanyInfoByUrl($company_url);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $companyInfo;
        return $this->apiReturn($refer);
    }

}