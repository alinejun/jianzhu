<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/2/25
 * Time: 1:38
 */
namespace app\api\model;
use app\common\model\ModelBase;
use think\Db;

class PeopleProject extends ModelBase
{
    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return Db::name('people_project')->where($where)->field($field)->limit($num*$page,$page)->select();
    }

    public static function getDataByPeopleId($people_id,$field,$count=1)
    {
        if(!$people_id){
            return false;
        }
       if($count){
           $res = Db::name('people_project')->where(['people_id'=>$people_id])->field($field)->count();
       }else{
           $res = Db::name('people_project')->cache(true)->where(['people_id'=>$people_id])->field($field)->select();
       }
       if($res){
           return $res;
       }else{
           $res=  $count == 0 ? [] :0;
           return $res;
       }

    }
    

}