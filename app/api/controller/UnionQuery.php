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
}