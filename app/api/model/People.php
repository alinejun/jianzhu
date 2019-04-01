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

    #根据人员id获取 company_url

    /**
     * @param $people_ids
     * @param int $count  0:获取company_url值，1：获取company_url的数量
     * @param string $field
     * @return array|int
     */
    public static function getCompanyByPeopleIds($people_ids,$count=0,$field="*")
    {
        $company_url = self::splicePeopleIds(array_unique($people_ids));
        if($count){
            return count($company_url);
        }else{
            return $company_url;
        }
    }

    #把people_id 分片
    public static function splicePeopleIds($people_ids)
    {
        $company_url_list = $jiao_arr = [] ;
        $count = ceil(count($people_ids)/1000);
        for($i = 0 ; $i<$count ;$i++){
            $people_ids_splice = [];
            $people_ids_splice = array_slice($people_ids,$i*1000,1000);
            $company_url_list[$i] = self::where('id','in',$people_ids_splice)->cache(true)->field('company_url')->group('company_url')->select()->toArray();
        }
        foreach ($company_url_list as $k=>$value){
            !empty($value) and $jiao_arr[] = array_column($value,'company_url');
        }
        if(count($jiao_arr)>0){
            $bin_people_arr_data = call_user_func_array ('array_merge', $jiao_arr);
        }else{
            return [];
        }
        return array_unique($bin_people_arr_data);
    }
}