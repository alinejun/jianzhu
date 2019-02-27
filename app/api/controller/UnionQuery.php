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
use app\Code;

class UnionQuery extends ApiBase{

    //企业人员联合查询
    public function getCompanyUnionPeople($request)
    {
        $ids_arr = explode(',', $request['company_condition']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = implode(',',array_column($company_ids_arr,'company_url'));
        empty($company_url_list) or $request['people_condition']['company_url_list'] = $company_url_list;
        //将获取到的符合资质的company_url传入人员中做为条件
        $company_url = (new PeopleCondition())->getCompany($request['people_condition']);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['count']= $company_url['count'];
        return $this->apiReturn($refer);
    }

    # 企业项目联合查询
    public function getCompanyUnionProject($request){
        #先查企业的符合的公司company_url
        $params_company = explode(',', $request['company_condition']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        #再查项目符合的company_url
        $params_project = $request['project_condition'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        #取交集
        $company_url = array_intersect($company_ids_arr,$project_ids_arr);
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count'] = count($company_url);
        $res = json_encode($res);
        return $res;
    }

    # 人员项目联合查询
    public function getPeopleUnionProject($request){
        #先查人员的符合公司的company_url
        $people_ids_arr = (new PeopleCondition())->getCompany($request['people_condition']);
//        $people_ids_arr = array_column($people_ids_arr,'company_url');
        var_dump($people_ids_arr);die();
    }
}