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
        $return = $this->apiReturn(CodeBase::$requestNotData);
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
                return $this->apiReturn(CodeBase::$requestNotAPI);
            }
            if ($key == ApiRoute::PROJECT_CONDITION && !empty($value)) {
                return $this->apiReturn(CodeBase::$requestNotAPI);
            }
            if ($key == ApiRoute::GET_MAJOR && !empty($value)) {
                return (new PeopleCondition())->getMajor($value);
            }
        }
    }

    public function multipleApi($arr)
    {
        if (implode(',', array_keys($arr)) == ApiRoute::COMPANY_PEOPLE_CONDITION) {
           return  (new UnionQuery())->getCompanyUnionPeople($arr);  //企业-人员联查
        }
        if (implode(',', array_keys($arr)) == ApiRoute::COMPANY_PEOPLE_CONDITION) {
            echo '企业-项目联查';
            exit;
        }
        if (implode(',', array_keys($arr)) == ApiRoute::PEOPLE_PROJECT_CONDITION) {
            echo '人员-项目联查';
            exit;
        }
        if (implode(',', array_keys($arr)) == ApiRoute::COMPANY_PEOPLE_PROJECT_CONDITION) {
            echo '企业-人员-项目联查';
            exit;
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
