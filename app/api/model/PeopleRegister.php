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

        $list = $this->table('jz_people_register')->where($where)->field($filed)->group('register_major')->select();
        return $list;
    }
}