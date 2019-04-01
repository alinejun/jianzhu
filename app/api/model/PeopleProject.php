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

    //根据people_ids找到所有的project_url
    public static function getProjectUrlByPeopleIds($people_ids)
    {
        $project_url_list = $jiao_arr = [] ;
        $count = ceil(count($people_ids)/100);
        for($i = 0 ; $i<$count ;$i++){

            $people_ids_splice = [];
            $people_ids_splice = array_slice($people_ids,$i*100,100);
            $project_url_list[$i] = self::where('people_id','in',$people_ids_splice)->field('distinct project_url')->select()->toArray();
            dump($project_url_list[$i]);
        }exit;
        foreach ($project_url_list as $k=>$value){
            !empty($value) and $jiao_arr[] = array_column($value,'project_url');
        }
        if(count($jiao_arr)>0){
            $bin_project_arr_data = call_user_func_array ('array_merge', $jiao_arr);
        }else{
            return [];
        }
        return array_unique($bin_project_arr_data);
    }

}