<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/2/25
 * Time: 1:26
 */
namespace app\api\model;
use think\Db;

class PeopleMiscdct extends ApiBase
{
    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return Db::name('people_miscdct')->where($where)->field($field)->limit($num*$page,$page)->select();
    }
}