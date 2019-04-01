<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/3/27
 * Time: 11:17
 */
namespace app\common\model;
class PeopleRegisterReset extends ModelBase{
    protected $table = 'jz_register_people_reset';

    public function getListData($where=[],$filed="*",$order="id desc",$page=0,$pageSize=0)
    {
        if(empty($where)){
            $where =1 ;
        }
        $sql =  $this->where($where)->field($filed)->cache(true,180)->order($order);
        if($pageSize){
            $sql->limit($pageSize*$page,$pageSize);
        }
        $list = $sql->select();
        return $list;
    }
    public function getListDataIn($where=[],$filed="* as a",$order="id desc",$page=0,$pageSize=0)
    {
        if(empty($where)){
           return [];
        }
        $sql =  $this->group('register_type')->where('register_type','in',$where)->cache(true,180)->field($filed)->order($order);
        if($pageSize){
            $sql->limit($pageSize*$page,$pageSize);
        }
        //dump($sql->buildSql());exit;
        $list = $sql->select();
        return $list;
    }
}