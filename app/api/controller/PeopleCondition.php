<?php
/**
 * Created by PhpStorm.
 * User: alinejun
 * Date: 2019/1/30
 * Time: 23:15
 */
namespace app\api\controller;
use app\api\error\CodeBase;
use app\api\model\People;
use app\api\model\PeopleProject;
use app\api\model\PeopleChange;
use app\api\model\PeopleMiscdct;
use app\api\model\PeopleRegister;
use app\Code;

class PeopleCondition extends ApiBase{

    protected $people_register;
    public function __construct()
    {
        $this->people_register = new PeopleRegister();
        parent::__construct();
    }
    public function getCondition()
    {
        $data['first'] = [
            ['id'=>'1','register_type'=>'注册建筑师'],
            ['id'=>'2','register_type'=>'勘察设计注册工程师'],
            ['id'=>'3','register_type'=>'注册监理工程师'],
            ['id'=>'4','register_type'=>'注册建造师'],
            ['id'=>'5','register_type'=>'注册造价工程师'],
           ];
        $data['second'] = [
            ['register_certnum'=>'121500249',  'register_type'=>'一级注册建筑师','pid'=>1],
            ['register_certnum'=>'2006100762', 'register_type'=>'二级注册建筑师','pid'=>1],
            ['register_certnum'=>'S174101880',  'register_type'=>'一级注册结构工程师','pid'=>2],
            ['register_certnum'=>'S2182100484',  'register_type'=>'二级注册结构工程师','pid'=>2],
            ['register_certnum'=>'AY183600374',  'register_type'=>'注册土木工程师（岩土）','pid'=>2],
            ['register_certnum'=>'CN151500087',  'register_type'=>'注册公用设备工程师（暖通空调）','pid'=>2],
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
        foreach( $data['first'] as &$value){
            foreach ($data['second'] as $v){
                if($v['pid'] == $value['id']){
                    $value['_child'][] = $v;
                }
            }
        }
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $data['first'];
        return $this->apiReturn($refer);
    }

    //根据证书编号获取专业信息
    public function getMajor(){
        $data = input('post.');
        $peopleRegister = new PeopleRegister();
        $register_type =$data['register_type'];
        if(!$register_type){
            return $this->apiReturn(CodeBase::$requestNotData);
        }
        $where['register_type'] = $register_type;
        $typeName = $peopleRegister->getMajorByType($where,'register_major','register_major');
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $major = [];
        foreach ($typeName as $k=>$value){
            if(!empty($value['register_major'])){
                $major[] = $value['register_major'];
            }
        }
        $refer['data'] = $major;
        return $this->apiReturn($refer);
    }

    /**
     * @request $type 1:企业 2：人员
     * @request $register_type 注册类型
     * @request $register_major 专业
     * @request $num  人数
     */
    public function getCompanyByPeople($data=[])
    {
        $list = $this->getCompany($data) ;
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['company_list'] = $list['company_list'];
        $refer['company_count'] = $list['count'];
        return $this->apiReturn($refer);
    }

    public function getCompany($data)
    {
        ini_set('max_execution_time',0);
        $where['register_type']  =  $data['register_type'];
        $where['register_major'] =  $data['register_major'];
        empty($data['pageSize']) and $data['pageSize'] = 10;
        empty($data['pageNum'])  and $data['pageNum'] = 0;
        $whereIn = isset($data['company_url_list']) ?  $data['company_url_list'] : '';
        $list = $this->people_register->getPeopleMultiple($where,'*',$data['pageSize'],$data['pageNum'],$whereIn);
        if(!$list){
            return false;
        }
        $company_list = [];
        foreach ($list['list'] as $k=>&$value){
            $map['company_url'] = $value['company_url'];
            $company_list[] = \app\api\model\Company::getComanyInfo($map,'*');
        }
        return ['company_list'=>$company_list,'count'=>$list['count']];
    }

    public function getPeopleLists()
    {
        $people = new People();
        $where['register_type'] = input('get.register_type');
        $where['register_major'] = input('get.register_major');
        $page_num  = input('get.page_num');
        $page_size  = input('get.page_size');
        empty($page_num) and $page_num =0;
        empty($page_size) and $page_size =10;
        $company_url = input('get.company_url');
        $res = (new PeopleRegister())->getPeopleID($where, $company_url, 'people_id,register_type,register_major,register_unit',$page_num,$page_size);
        //$peopleInfo = [];
        if (!$res) {
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        $list = [];
        foreach ($res as $k=>$value) {
            $map['id'] = $value['people_id'];
            $list[$k] = $people->getInfoByPeopleid($map,'id,people_name,people_sex');
        }
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['people_list'] = $list;
        return $this->apiReturn($refer);
    }

    public function getPeoPleDetail()
    {
        $people_id = input('get.people_id');
        if(!$people_id){
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        $map['people_id'] = $people_id;
        //（受不鸟）人员相关数据暂时限制1000条数据。
        $data['register'] = (new PeopleRegister())->getDataByPeopleId($map, "register_type,register_major,register_date,register_unit");
        $data['project'] = array_column((new PeopleProject())->getData($map, "project_name", 0, 1000),'project_name');
        $data['miscdct'] = (new PeopleMiscdct())->getData($map, "miscdct_name,miscdct_content,miscdct_dept,miscdct_date", 0, 1000);
        $data['change'] = (new PeopleChange())->getData($map, "change_type,change_record", 0, 1000);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['people_list'] = $data;
        return $this->apiReturn($refer);
    }
}