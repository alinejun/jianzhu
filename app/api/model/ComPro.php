<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/3/7
 * Time: 10:46
 */
namespace app\api\model;
use think\Db;

class ComPro extends ApiBase{
    public function getProByCom($where,$field='project_url')
    {
        $res =  $this->where('company_url','in',$where)->where('status',1)->field($field)->select()->toArray();
        return $res;
   }
}
