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

    #根据人员id获取·
    public static function getCompanyByPeopleIds($people_ids,$count=0)
    {
        if($count){
            return self::where('id','in',$people_ids)->group('company_url')->count();
        }else{
            return self::where('id','in',$people_ids)->group('company_url')->select()->toArray();
        }
    }
}