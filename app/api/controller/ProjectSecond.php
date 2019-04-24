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
        $field = "project_url,project_name,project_area,project_unit,project_type,project_nature,project_use,project_allmoney,project_acreage,project_level";
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
        $project_detail = $this->project_model->getProjectDetailV2($project_url,$company_url);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $project_detail;
        return $this->apiReturn($refer);
    }

}