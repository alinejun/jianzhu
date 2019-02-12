<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/2/2
 * Time: 21:32
 */
namespace app\api\model;
class PeopleRegister extends ApiBase{

    public function getTypeByCertnum($where,$filed="*")
    {
        $type_name = self::where($where)->field($filed)->select();
        return $type_name;
    }

    public function getMajorByType($where,$filed="*")
    {

        $list = self::where($where)->field($filed)->group('register_major')->select();
        return $list;
    }

    public function getPeople($where=1,$filed="*",$pageSize=10,$pageNum=0,$having='')
    {
       $sql =  self::where($where)
                 ->field($filed)
                 ->limit($pageSize*$pageNum,$pageSize)
                 ->group('company_url');
       $list =  !empty($having) ? $sql->having("count('company_url')>$having") ->select() : $sql->select();
       return $list;
    }
}