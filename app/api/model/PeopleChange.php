<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/2/25
 * Time: 1:25
 */

namespace app\api\model;
class PeopleChange extends ApiBase
{
    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return $this->where($where)->field($field)->limit($num*$page,$page)->select();
    }
}