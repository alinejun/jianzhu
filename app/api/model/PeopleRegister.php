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
       $sql =  self::where($where)->field($filed)
             ->limit($pageSize*$pageNum,$pageSize)
             ->group('company_url');
       $list =  !empty($having) ? $sql->having("count('company_url')>$having") ->select() : $sql->select();
       $query = "select count(*) as count from (".self::where($where)->distinct(true)->field('company_url')->buildSql().") as a"; //统计总数
       $count_res = $this->query($query);
       $count = $count_res[0]['count']?$count_res[0]['count']:0;
       return ['list'=>$list,'count'=>$count];
    }

    public function getPeopleMultiple($data,$filed="company_url",$pageSize=10,$pageNum=0)
    {
        $register_type = explode(',',$data['register_type']);
        $register_major = explode(',',$data['register_major']);
        //判断条件是否相等
        if(count($register_type)!=count($register_major)){
            return false;
        }
        $map = [];
        foreach ($register_type as $k=>$value){
            $map[]= " CONCAT_WS('--',register_type,register_major) =  '$value--$register_major[$k]' ";
        }
        $where = array_unique($map);
        $offset = $pageNum*$pageSize;
        $condition =count($where)-1;
        $sql = $countSqlString = "SELECT $filed FROM jz_people_register WHERE ". implode(' OR ',$where) . " GROUP BY company_url HAVING COUNT('company_url')>$condition";
        $sql .= " LIMIT $offset,$pageSize";
        $countSql =  "select count(*) as count from ($countSqlString) as a";
        $list = $this->query($sql);
        $countRes= $this->query($countSql);
        $count = $countRes[0]['count']? $countRes[0]['count']:0;
        return ['list'=>$list,'count'=>$count];
    }
}