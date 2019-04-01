<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/3/27
 * Time: 11:17
 */
namespace app\common\model;
class PeopleRegisterReset extends ModelBase{
    protected $table = 'jz_people_register_new';

    public function getListData($where=[],$company_url=[],$filed="*",$order="id desc",$page=0,$pageSize=0)
    {
        if(empty($where)){
            $where =1 ;
        }
        $sql =  $this->where($where)->field($filed);
        //如果company_url 不为空 则加入条件
        empty($company_url) or $sql = $sql->where('company_url','in',$company_url);
        $sql = $sql->cache(true,180)->order($order);
        if($pageSize){
            $sql->limit($pageSize*$page,$pageSize);
        }
        $list = $sql->select();
        return $list;
    }
    public function getListDataIn($where=[],$company_url=[],$type=0,$filed="* as a",$order="id desc",$page=0,$pageSize=0)
    {
        if(empty($where)){
           return [];
        }
        $sql =  $this->where('register_type','in',$where);
        //如果company_url 不为空 则加入条件
        empty($company_url) or $sql = $sql->where('company_url','in',$company_url);
        $sql = $sql->cache(true,180)->field($filed)->order($order);
        if($pageSize){
            $sql->limit($pageSize*$page,$pageSize);
        }
        $list = $sql->select();
        return $list;
    }
}