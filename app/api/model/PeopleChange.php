<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/2/25
 * Time: 1:25
 */

namespace app\api\model;
use think\Db;

class PeopleChange extends ApiBase
{
    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return  Db::name('people_change')->where($where)->field($field)->limit($num*$page,$page)->select();
    }

    public static function getDataByPeopleId($people_id,$field)
    {
        if(!$people_id){
            return false;
        }
        $res = Db::name('people_change')->where(['people_id'=>$people_id])->field($field)->select();
        return array_column($res,'change_record');
    }

}