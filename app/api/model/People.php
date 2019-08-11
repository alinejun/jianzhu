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

    public static function getPeopleNameByIds($people_ids)
    {
        $people_list = self::where('id','in',$people_ids)->cache(true)->field('id,people_name')->select()->toArray();
        return $people_list;
    }

    /*
     * 根据company_url，查询企业对应的人员相关信息
     *
     * @params
     *  $company_url 企业URL
     *
     * @return mixed 企业对应人员信息
     * */
    public static function getPeopleInfoByUrl($company_url, $page, $page_size){
        $result = [];
        $people = new People();
        $list = [] ;
        //通过company_url 获取 people_id
        $sql = "select id from jz_people where company_url = {$company_url}";
        $people_ids = Db::query($sql);
        $people_ids = array_column($people_ids,'id');
        $people_id = array_slice(array_unique($people_ids),($page-1)*$page_size,$page_size);
        if ($people_id) {
            $people_id = array_values($people_id);
            foreach ($people_id as $k=>&$value) {
                $list[$k]['id'] = $value;
                $map['id'] = $value;
                $people_info = $people->getInfoByPeopleid($map,'people_name,people_url,people_sex,people_cardtype,people_cardnum');
                if($people_info){
                    $list[$k]= array_merge($list[$k],$people_info);
                }
                $people_reigster_info  = PeopleRegister::getRegisterInfoByPeopleId($value);
                $list[$k]['register_type'] = array_column($people_reigster_info,'register_type');
                $list[$k]['register_major'] = array_column($people_reigster_info,'register_major');
                $list[$k]['register_unit']  = array_column($people_reigster_info,'register_unit');
                $list[$k]['register_date']  = array_column($people_reigster_info,'register_date');
                $list[$k]['people_project'] = PeopleProject::getDataByPeopleId( $value,'project_name,project_url',0);
                $list[$k]['people_change']  = PeopleChange::getDataByPeopleId( $value,'change_record');
                $list[$k]['people_miscdct']  = PeopleMiscdct::getDataByPeopleId($people_info['people_url'],'miscdct_content');
            }
        }
        $result['list'] = $list;
        $result['page'] = $page;
        $result['page_size'] = $page_size;
        $result['total_page'] = ceil(count($people_ids)/$page_size);
        $result['total_num'] = count($people_ids);
        return $result;
    }
}