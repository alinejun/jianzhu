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
     */
    public function getProjectByCompanyurl()
    {

        $where['company_url'] = input('param.company_url')?:1;
        $pageSize = input('param.size')?:10;
        $pageNum = input('param.page')?:0;

        $project_list = $this->project_model->getProject($where,'*',$pageSize,$pageNum);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $project_list;
        return $this->apiReturn($refer);
    }
}