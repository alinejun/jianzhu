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

    public static function getProjectUrlByCompanyUrl($company_url){
      if (!$company_url || empty($company_url)){
        return false;
      }
      $company_url = array_values(array_unique($company_url));
      $company_url = implode(',', $company_url);
      $sql = "select project_url from jz_com_pro where company_url in (".$company_url.") limit 15000";
      $res = Db::query($sql);
      $project_url = array_values(array_unique(array_column($res, 'project_url')));
      return $project_url;
    }
    

}