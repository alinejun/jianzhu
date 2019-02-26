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
}