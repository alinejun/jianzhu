<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/1/30
 * Time: 23:15
 */
namespace app\api\controller;
class PeopleCondition extends ApiBase{


    public function getCondition()
    {
        $data['first'] = [
            ['id'=>'1','register_type'=>'注册建筑师'],
            ['id'=>'2','register_type'=>'勘察设计注册工程师'],
            ['id'=>'3','register_type'=>'注册监理工程师'],
            ['id'=>'4','register_type'=>'注册建造师'],
            ['id'=>'5','register_type'=>'注册造价工程师'],
           ];
        $data['first']['second'] = [
            ['register_certnum'=>'121500249',  'register_type'=>'一级注册建筑师','pid'=>1],
            ['register_certnum'=>'2006100762', 'register_type'=>'二级注册建筑师','pid'=>1],
            ['register_certnum'=>'S174101880',  'register_type'=>'一级注册结构工程师','pid'=>2],
            ['register_certnum'=>'S2182100484',  'register_type'=>'二级注册结构工程师','pid'=>2],
            ['register_certnum'=>'AY183600374',  'register_type'=>'注册土木工程师（岩土）','pid'=>2],
            ['register_certnum'=>'CS103700019',  'register_type'=>'注册公用设备工程师（给水排水）','pid'=>2],
            ['register_certnum'=>'CD103700002',  'register_type'=>'注册公用设备工程师（动力）','pid'=>2],
            ['register_certnum'=>'DF173600132',  'register_type'=>'注册电气工程师（发输变电）','pid'=>2],
            ['register_certnum'=>'DG102100226',  'register_type'=>'注册电气工程师（供配电）','pid'=>2],
            ['register_certnum'=>'F103700037',  'register_type'=>'注册化工工程师','pid'=>2],
            ['register_certnum'=>'00234634',  'register_type'=>'一级注册建造师','pid'=>4],
            ['register_certnum'=>'2155683',  'register_type'=>'二级注册建造师','pid'=>4],
            ['register_certnum'=>'00018382',  'register_type'=>'一级临时注册建造师','pid'=>4],
            ['register_certnum'=>'00110147',  'register_type'=>'二级临时注册建造师','pid'=>4],
        ];
        return $this->apiReturn($data);
    }
}