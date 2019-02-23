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
use app\api\controller\PeopleCondition;
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
        echo '11';exit;
    }

    public function getData()
    {
        $requset =file_get_contents('php://input');
        $requsetData = json_decode($requset,true);
        $arr =$this->getArr($requsetData['request']);   //判断是否存在多个不为空的条件
        $return = $this->apiReturn(CodeBase::$requestNotData);
        count($arr) >1   and  $return = $this->multipleApi($arr);
        count($arr) == 1 and  $return = $this->aloneApi($arr);
        return $return ;
    }

    public function aloneApi($data)
    {
        foreach ($data as $key => $value){
            if($key == ApiRoute::PEOPLE_CONDITION && !empty($value)){
                return  ((new PeopleCondition())->getCompanyByPeople($value)); break;
            }
            if($key == ApiRoute::COMPANY_CONDITION && !empty($value)){
                echo '未分配接口';exit;
            }
            if($key == ApiRoute::PROJECT_CONDITION  && !empty($value)){
                echo '未分配接口';exit;
            }
            if($key == ApiRoute::GET_MAJOR && !empty($value)){
                return  (new PeopleCondition())->getMajor($value);
            }
        }
    }

    public function multipleApi($arr)
    {
        if( implode(',',array_keys($arr)) == ApiRoute::COMPANY_PEOPLE_CONDITION){
            echo '企业-人员联查';exit;
        }
        if( implode(',',array_keys($arr)) ==ApiRoute::COMPANY_PEOPLE_CONDITION){
            echo '企业-项目联查';exit;
        }
        if( implode(',',array_keys($arr)) == ApiRoute::PEOPLE_PROJECT_CONDITION){
            echo '人员-项目联查';exit;
        }
        if( implode(',',array_keys($arr)) == ApiRoute::COMPANY_PEOPLE_PROJECT_CONDITION){
            echo '企业-人员-项目联查';exit;
        }
        exit;
    }

    function getArr($arr)
    {
        foreach ($arr as $k=>$v)
        {
            if(empty($v))
            {
                unset($arr[$k]);
            }
        }
        return $arr;
    }
}
