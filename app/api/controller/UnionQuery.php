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
        # 将获取到的符合项目的company_url传入人员中做为条件
        $request['people_condition']['company_url_list'] = $project_ids_str;
        # is_limit 为1 则不分页
        $request['people_condition']['is_limit'] = 1;
        $company_url = (new PeopleCondition())->getCompany($request['people_condition']);
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count']= $company_url['count'];
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
        # 将获取到的符合项目的company_url传入人员中做为条件
        $request['people_condition']['company_url_list'] = $company_url;
        # is_limit 为1 则不分页
        $request['people_condition']['is_limit'] = 1;
        $result = (new PeopleCondition())->getCompany($request['people_condition']);
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['count']= $result['count'];
        $res = json_encode($res);
        return $res;
    }


    #企业人员获取project_url
    public function getProjectUrlByCP()
    {
        $request = input('post.')['request'];
        $ids_arr = explode(',', $request['company_condition']['code']);
        $ids_arr = (new Company)->transformGet($ids_arr);
        #得到符合资质查询条件的公司id
        $company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
        $company_url_list = implode(',', array_column($company_ids_arr, 'company_url'));
        empty($company_url_list) or $request['people_condition']['company_url_list'] = $company_url_list;
        #将获取到的符合资质的company_url传入人员中做为条件
        $company_url = (new PeopleCondition())->getCompany($request['people_condition']);
        $company_list = array_column($company_url['company_list'],'company_url');
        $project_url = $this->com_pro->getProByCom($company_list);
        return $project_url;
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
}