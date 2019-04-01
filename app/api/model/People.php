<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/1/30
 * Time: 23:16
 */
namespace app\api\model;
use think\Db;

class People extends ApiBase{

    /**
     * 根据peopleid获取人员信息
     */
    public function getInfoByPeopleid($where=1,$filed="*")
    {
        $list = Db::name('people')->where($where)->field($filed)->find();
        return $list;
    }
}