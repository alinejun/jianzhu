<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\api\controller;

use app\api\apiRoute\ApiRoute;
use app\api\error\CodeBase;
use app\common\controller\ControllerBase;
use app\api\controller\UnionQuery;
/**
 * 首页控制器
 */
class Index extends ApiBase
{
    
    private $union_query ;
 
    public function __construct()
    {
        $this->union_query = new UnionQuery();
        parent::__construct();
    }
    
    /**
     * 首页方法
     */
    public function index()
    {
        echo '建筑信息查询平台';exit;
    }

    public function getData()
    {
        $requsetData = input('post.');
        $arr = $this->getArr($requsetData['request']);   //判断是否存在多个不为空的条件
//        $return = $this->apiReturn(CodeBase::$requestNotData);
        count($arr) >  1 and $return = $this->multipleApi($arr);
        count($arr) == 1 and $return = $this->aloneApi($arr);
        return $return;
    }

    public function aloneApi($data)
    {
        foreach ($data as $key => $value) {
            if ($key == ApiRoute::PEOPLE_CONDITION && !empty($value)) {
                return ((new PeopleCondition())->getCompanyByPeople($value));
            }
            if ($key == ApiRoute::COMPANY_CONDITION && !empty($value)) {
                return ((new Company())->getCompanyDataNumber($value));
            }
            if ($key == ApiRoute::PROJECT_CONDITION && !empty($value)) {
                return ((new Project())->getProjectDataNum($value));
            }
            if ($key == ApiRoute::PEOPLE_CONDITION_DETAIL && !empty($value)) {
                return ((new PeopleCondition())->getPeopleLists($value));  //人员详情入口
            }
            if ($key == ApiRoute::PROJECT_CONDITION_DETAIL && !empty($value)){
                return (new Project())->getProjectDataDetail($value);   //项目详情
            }
            if ($key == ApiRoute::COMPANY_CONDITION_DETAIL && !empty($value)) {
                return (new Company())->getCompanyDataDetail($value);   //企业详情
            }
            if ($key == ApiRoute::COMPANY_CONDITION_DOWN && !empty($value)) {
                return (new Company())->exportCompany($value);  //企业导出
            }
            if ($key == ApiRoute::PROJECT_CONDITION_DOWN && !empty($value)){
                return (new Project())->exportPeoject($value); //项目导出
            }
            if ($key == ApiRoute::PEOPLE_CONDITION_DOWN && !empty($value)){
                return (new PeopleCondition())->exportPeople($value); //人员导出
            }
        }
    }

    public function multipleApi($arr)
    {
        $keys = array_keys($arr);
        # 符合条件的公司数量
        if (!array_diff($keys,explode(',',ApiRoute::COMPANY_PEOPLE_CONDITION))) {
            return  $this->union_query->getCompanyUnionPeople($arr);  //企业-人员联查
        }
        if (!array_diff($keys, explode(',',ApiRoute::COMPANY_PROJECT_CONDITION))) {
            return  $this->union_query->getCompanyUnionProject($arr); //企业-项目联查
        }
        if (!array_diff($keys,  explode(',',ApiRoute::PEOPLE_PROJECT_CONDITION))) {
            return  $this->union_query->getPeopleUnionProject($arr);  //人员-项目联查
        }
        if (!array_diff($keys,  explode(',',ApiRoute::COMPANY_PEOPLE_PROJECT_CONDITION))){
            return  $this->union_query->getAllUnion($arr);  //人员-企业-项目 联查
        }

        # 详情
        if (!array_diff($keys, explode(',', ApiRoute::COMPANY_PEOPLE_CONDITION_DETAIL))) {
            return $this->union_query->getCompanyUnionPeopleDetail($arr); //企业-人员 联查详情
        }
        if (!array_diff($keys, explode(',', ApiRoute::PEOPLE_PROJECT_CONDITION_DETAIL))) {
            return $this->union_query->getPeopleUnionProjectDetail($arr); //项目-人员 联查详情
        }
        if (!array_diff($keys,  explode(',',ApiRoute::COMPANY_PROJECT_CONDITION_DETAIL))){
            return $this->union_query->getCompanyUnionProjectDetail($arr);  //企业-项目联查 详情
        }
        if (!array_diff($keys, explode(',', ApiRoute::COMPANY_PEOPLE_PROJECT_CONDITION_DETAIL))) {
            return $this->union_query->getAllUnionDetail($arr); //企业-人员-项目 三个联查详情
        }

        # 导出
        if (!array_diff($keys,  explode(',',ApiRoute::COMPANY_PROJECT_CONDITION_DOWN))){
            return $this->union_query->exportCompanyUnionProject($arr);  //企业项目联查 导出
        }
        if (!array_diff($keys,  explode(',',ApiRoute::COMPANY_PEOPLE_PROJECT_CONDITION_DOWN))){
            return $this->union_query->exportAllUnion($arr);    //企业人员项目联查 导出
        }
        exit;
    }

    function getArr($arr)
    {
        foreach ($arr as $k => $v) {
            if (empty($v)) {
                unset($arr[$k]);
            }
        }
        return $arr;
    }
}
