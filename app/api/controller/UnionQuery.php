<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/2/26
 * Time: 23:22
 */
namespace app\api\controller;
use app\api\model\Company as CompanyModel;
use app\api\controller\Company;
use app\api\controller\PeopleCondition;
use app\api\controller\Project;
use app\api\model\ComPro;
use app\Code;
use think\Db;

class UnionQuery extends ApiBase{
    private  $com_pro ;
    public function __construct()
    {
        $this->com_pro = new ComPro();
    }

    //企业人员联合查询
    public function getCompanyUnionPeople($request)
    {
        $ids_arr = explode(',', $request['company_condition']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = array_column($company_ids_arr,'company_url');
        //获取满足人员条件的企业url
        $people_id = (new PeopleCondition())->newQueryLogic($request['people_condition']);

        $company_url = array_column(\app\api\model\People::getCompanyByPeopleIds($people_id,0),'company_url');

        $count = 0 ;
        //对符合人员，和符合公司的取交集
        if($company_url && $company_url_list){
            $count = count(array_intersect($company_url,$company_url_list));
        }elseif(empty($company_url) && !empty($company_url_list)){
             $count = 0;
        }elseif(!empty($company_url) && empty($company_url_list)){
            $count = 0;
        }
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['count']= $count;
        return $this->apiReturn($refer);
    }

    #企业人员联查详情
    public function getCompanyUnionPeopleDetail($request)
    {

        $ids_arr = explode(',', $request['company_condition_detail']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = array_column($company_ids_arr,'company_url');
        //获取满足人员条件的企业url
        $people_id = (new PeopleCondition())->newQueryLogic($request['people_condition_detail']);

        $company_url =\app\api\model\People::getCompanyByPeopleIds($people_id,0,'*,group_concat(id) as people_ids,group_concat(people_name) as people_names');
        $company_url_key = $last_company_url =  $company_data_list =[];
        foreach ($company_url as $k=>&$v){
            $company_url_key[$v['company_url']] = $v;
        }
        foreach ($company_url_key as $value){
            if( !empty($company_url_key[$value['company_url']])){
                $last_company_url[] = $company_url_key[$value['company_url']];
            }
        }

        $page = !empty($request['company_condition_detail']['page'])?:1;
        $page_size = !empty($request['company_condition_detail']['page_size'])?:10;

        $company_url_page = array_splice($last_company_url,($page-1)*$page,$page_size);

        //获取企业数据
        foreach ($company_url_page as $key=>$value){
            $company_url = $value['company_url'];
            #处理企业名称、法定代表人、注册属地 (jz_company表)
            $company = (CompanyModel::getJzCompany($company_url));
            $company = $company[0];
            $company_data_list[$key]['company_name'] = $company['company_name'];
            $company_data_list[$key]['company_legalreprst'] = $company['company_legalreprst'];
            $company_data_list[$key]['company_regadd'] = $company['company_regadd'];
            #处理企业资质类别、资质名称、证书有效期（jz_qualification表）
            $company_data_list[$key]['qualification'] = CompanyModel::getJzQualification($company_url);
            #处理变更日期、变更内容（jz_cpny_change表）
            $company_data_list[$key]['cpny_change'] = CompanyModel::getJzCpnyChange($company_url);
            #处理诚信记录主体、决定内容、实施部门、发布有效期（jz_cpny_miscdct表）
            #由于此表现在无数据，且是company_id还是company_url链表 不明 暂附空值----<<<----
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
            $company_data_list[$key]['people_ids'] = explode(',',$value['people_ids']);
            $company_data_list[$key]['people_names'] = explode(',',$value['people_names']);
        }
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['data']['data_list'] = $company_data_list;
        $refer['data']['total_num'] = count($last_company_url);
        $refer['data']['total_page'] = ceil(count($last_company_url)/$page_size)-1;
        $refer['key'] = 'company_people_detail';
        return $this->apiReturn($refer);


    }

    # 企业项目联合查询
    public function getCompanyUnionProject($request){
        # 先查企业的符合的公司company_url
        $params_company = explode(',', $request['company_condition']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        # 再查项目符合的company_url
        $params_project = $request['project_condition'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        # 取交集
        $company_url = array_intersect($company_ids_arr,$project_ids_arr);
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count'] = count($company_url);
        $res = json_encode($res);
        return $res;
    }

    # 人员项目联合查询
    public function getPeopleUnionProject($request){
        # 项目符合的company_url
        $params_project = $request['project_condition'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        $project_ids_str = implode(',',$project_ids_arr);
        //获取满足人员条件的企业url
        $people_id = (new PeopleCondition())->newQueryLogic($request['people_condition']);

        $company_url = array_column(\app\api\model\People::getCompanyByPeopleIds($people_id,0),'company_url');

        $count = 0 ;
        //对符合人员，和符合公司的取交集
        if($company_url && $project_ids_str){
            $count = count(array_intersect($company_url,$project_ids_str));
        }elseif(empty($company_url) && !empty($project_ids_str)){
            $count = 0;
        }elseif(!empty($company_url) && empty($project_ids_str)){
            $count = 0;
        }
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count']= $count;
        $res = json_encode($res);
        return $res;
    }

    # 项目人员企业三个一起联合查询
    public function getAllUnion($request){
        # 先查企业的符合的公司company_url
        $params_company = explode(',', $request['company_condition']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        # 再查项目符合的company_url
        $params_project = $request['project_condition'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        # 企业和项目的 company_url 取交集
        $company_url = array_intersect($company_ids_arr,$project_ids_arr);
        $company_url = implode(',',$company_url);
        //获取满足人员条件的企业url
        $people_id = (new PeopleCondition())->newQueryLogic($request['people_condition']);

        $people_company_url = array_column(\app\api\model\People::getCompanyByPeopleIds($people_id,0),'company_url');

        $count = 0 ;
        //对符合人员，和符合公司的取交集
        if($people_company_url && $company_url){
            $count = count(array_intersect($people_company_url,$company_url));
        }elseif(empty($people_company_url) && !empty($company_url)){
            $count = 0;
        }elseif(!empty($people_company_url) && empty($company_url)){
            $count = 0;
        }
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count']= $count;
        $res = json_encode($res);
        return $res;
    }


    #企业人员获取project_url
    public function getProjectUrlByCP()
    {
        $request = input('post.')['request'];
        $ids_arr = explode(',', $request['company_condition_detail']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = implode(',', array_column($company_ids_arr, 'company_url'));
        empty($company_url_list) or $request['people_condition_detail']['company_url_list'] = $company_url_list;
        #将获取到的符合资质的company_url传入人员中做为条件
        $company_url = (new PeopleCondition())->getPeopleConditionCompanyUrl($request['people_condition_detail']);
        $company_list = array_column($company_url['company_list'],'company_url');
        $project_url = $this->com_pro->getProByCom($company_list);
        return array_column($project_url,'project_url');
    }
    public function getProjectUrlByCPforDown()
    {
        $request = input('post.')['request'];
        $ids_arr = explode(',', $request['company_condition_down']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = implode(',', array_column($company_ids_arr, 'company_url'));
        empty($company_url_list) or $request['people_condition_down']['company_url_list'] = $company_url_list;
        #将获取到的符合资质的company_url传入人员中做为条件
        $company_url = (new PeopleCondition())->getPeopleConditionCompanyUrl($request['people_condition_down']);
        $company_list = array_column($company_url['company_list'],'company_url');
        $project_url = $this->com_pro->getProByCom($company_list);
        return array_column($project_url,'project_url');
    }
    /*
     * =================================================================================================================
     * 上面是联合查询中符合条件的 公司数量
     * 下面是联合查询中符合条件的 数据详情
     * =================================================================================================================
     * */

    # 企业项目联合查询
    public function getCompanyUnionProjectDetail($request){
        # 先查企业的符合的公司company_url
        $params_company = explode(',', $request['company_condition_detail']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        $company_ids_str = implode(',',$company_ids_arr);
        # 查com_pro表通过公司URL查询到project_url, 为了效率 limit 5000
        $sql = "SELECT distinct(project_url) FROM jz_com_pro where company_url in (".$company_ids_str.") limit 5000";
        $res = Db::query($sql);
        $project_url_str = implode(',',array_column($res,'project_url'));
        $request['project_condition_detail']['project_url_str'] = $project_url_str;
        $params = $request['project_condition_detail'];
        $result = (new Project())->getProjectDataDetail($params);
        return $result;

    }

    # 企业人员项目三个联查详情
    public function getAllUnionDetail($request){
        $project_url = $this->getProjectUrlByCP();
        $project_url_str = implode(',', $project_url);
        $request['project_condition_detail']['project_url_str'] = $project_url_str;
        $params = $request['project_condition_detail'];
        $result = (new Project())->getProjectDataDetail($params);
        return $result;
    }

    /*
     * =================================================================================================================
     * 上面是联合查询中符合条件的 数据详情
     * 下面是联合查询中符合条件的 excel导出
     * =================================================================================================================
     * */

    # 企业项目联合导出
    public function exportCompanyUnionProject($request){
        # 先查企业的符合的公司company_url
        $params_company = explode(',', $request['company_condition_down']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        $company_ids_str = implode(',',$company_ids_arr);
        # 查com_pro表通过公司URL查询到project_url, 为了效率 limit 5000
        $sql = "SELECT distinct(project_url) FROM jz_com_pro where company_url in (".$company_ids_str.") limit 5000";
        $res = Db::query($sql);
        $project_url_str = implode(',',array_column($res,'project_url'));
        $request['project_condition_down']['project_url_str'] = $project_url_str;
        $params = $request['project_condition_down'];
        $result = (new Project())->exportPeoject($params);
        return $result;
    }

    #企业人员项目联合导出
    public function exportAllUnion($request){
        $project_url = $this->getProjectUrlByCPforDown();
        $project_url_str = implode(',', $project_url);
        $request['project_condition_down']['project_url_str'] = $project_url_str;
        $params = $request['project_condition_down'];
        $result = (new Project())->exportPeoject($params);
        return $result;
    }

}