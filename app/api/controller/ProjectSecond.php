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
            "项目名称,项目分类,建设性质,工程用途,总投资,总面积,
            招标类型,招标方式,中标单位名称,中标日期,中标金额(万元),面积（平方米）,招标代理单位名称,网站招投标详情页面,
            合同类别,合同金额（万元）,合同签订日期,建设规模,承包单位,网站合同备案详情页面,
            实际造价（万元）,实际面积（平方米）,实际开工日期,实际竣工验收日期,设计单位,监理单位,施工单位,网站竣工验收备案详情页面";
        $keys   =
            "project_name,project_type,project_nature,project_use,project_allmoney,project_acreage,
            bid_type,bid_way,bid_unitname,bid_date,bid_money,bid_area,bid_unitagency,bid_url,
            contract_type,contract_money,contract_signtime,contract_scale,contract_unitname,contract_add_url,
            finish_money,finish_area,finish_realbegin,finish_realfinish,finish_unitdsn,finish_unitspv,finish_unitcst,finish_add_url";
        // $path = export_excel_v1($titles, $keys, $list, '企业所做项目');
        return $this->apiReturn(['path'=>$path]);
    }

    public function getDataForExport($company_url){
        return $this->project_model->getDataForExportV2($company_url);
    }


}