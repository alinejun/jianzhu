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
use app\common\model\PeopleRegisterReset;

class PeopleCondition extends ApiBase{

    protected $people_register;
    protected $peopleRegisterReset;
    public function __construct()
    {
        $this->peopleRegisterReset = new PeopleRegisterReset();
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
        $refer['count'] = $list['count'];
        return $this->apiReturn($refer);
    }

    public function getCompany($data)
    {

        ini_set('max_execution_time',0);
        $where['register_type']  =  $data['register_type'];
        $where['register_major'] =  $data['register_major'];
        //$list = $this->people_register->getPeopleMultiple($where,'*',$data['pageSize'],$data['pageNum'],$whereIn,$is_limit);
        $people_id = $this->newQueryLogic($where);
        $people_id = [15,16,17];
        if(!$people_id){
            return false;
        }
        $company_list = \app\api\model\Company::getCompanyByPeopleIds($people_id);

        return ['company_list'=>$company_list,'count'=>count($company_list)];
    }


    #处理查询逻辑(新的)
    public function newQueryLogic($data)
    {

        $register_type  = $data['register_type'];

        $register_major = $data['register_major'];

        $where = $map = [];
        foreach ($register_type as $k=>$v){

            if(empty($register_major[$k])){ //收集只查询类型的条件
                $where[] = "$v";
            }else{ //收集查询类型并有专业的条件
                $map1['register_type']  = $v;
                $map1['register_major'] = $register_major[$k];
                $map[] = $map1;
            }
        }
        //开始查询
        if(!empty($where)){
            $binji = $this->peopleRegisterReset->getListDataIn($where,'id,register_type,register_major,group_concat(people_id)')->toArray();

            $bin_people_arr = array_column($binji,'group_concat(people_id)');
            foreach ($bin_people_arr as $k=>$v){
                $bin_people_arr[$k]= explode(',',$v);
                $bin_people_arr[$k] =array_filter($bin_people_arr[$k]);
            }

            $jiao_people_arr_data =  call_user_func_array ('array_intersect',$bin_people_arr);
        }

        //满足类型-专业条件查找
        $jiao = [] ;
        foreach ($map as $k=>$value){
            $jiao[] = $this->peopleRegisterReset->getListData($value,'id,register_type,register_major,people_id')->toArray()[0];
        }
        $jiao_people_str = array_column($jiao,'people_id');
        foreach ($jiao_people_str as $k=>$v){
            $jiao_people_str[$k] = explode(',',$v);
        }

        if(count($jiao_people_str)>1){
            $jiao_arr = call_user_func_array ('array_intersect', $jiao_people_str);
        }else{
            $jiao_arr = $jiao_people_str;
        }

        //对最后的结果取交集
        if(empty($jiao_arr)){
            // $bin_people_arr_data = array_unique($bin_people_arr_data);
            return $jiao_people_arr_data;
        }elseif(empty($bin_people_arr_data)){
            return $jiao_arr;
        }else{
            $bin_people_arr_data = array_unique($bin_people_arr_data);
            return array_intersect($bin_people_arr_data,$jiao_arr);
        }
    }

    public function getPeopleLists($data)
    {
        $people = new People();
        $where['register_type'] =$data['register_type'];
        $where['register_major'] = $data['register_major'];
        $page_num   = isset( $data['page_num']) ?  $data['page_num']  : 1;
        $page_size  = isset($data['page_size']) ?  $data['page_size'] : 10;

        $field = "people_id,GROUP_CONCAT(register_type SEPARATOR ',') as register_type,GROUP_CONCAT(register_major SEPARATOR ',') as register_major,GROUP_CONCAT(register_unit SEPARATOR ',') as register_unit,GROUP_CONCAT(register_date SEPARATOR ',') as register_date";
        $people_data = (new PeopleRegister())->getPeopleID($where,$field,$page_num-1,$page_size);
        $res = $people_data['list'];

        if (!$res) {
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        foreach ($res as $k=>&$value) {
            $map['id'] = $value['people_id'];
            $people_info = $people->getInfoByPeopleid($map,'people_name,people_url,people_sex,people_cardtype,people_cardnum');
            if($people_info){
                $value = array_merge($value,$people_info);
            }
            $value['register_major'] = explode(',',$value['register_major']);
            $value['register_unit']  = explode(',',$value['register_unit']);
            $value['register_date']  = explode(',',$value['register_date']);
            $value['people_project'] = PeopleProject::getDataByPeopleId( $value['people_id'],'project_name');
            $value['people_change']  = PeopleChange::getDataByPeopleId( $value['people_id'],'change_record');
            $value['people_miscdct']  = PeopleMiscdct::getDataByPeopleId($people_info['people_url'],'miscdct_num');
        }
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['data']['data_list'] = $res;
        $refer['data']['total_num'] = $people_data['count'];
        $refer['data']['total_page'] = ceil($people_data['count']/$page_size)-1;
        $refer['key'] = 'people';
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
        $refer['people_info'] = $data;
        return $this->apiReturn($refer);

    }

    public function exportPeople($data)
    {
        ini_set('max_execution_time', 0);
        $people = new People();
        $where['register_type'] =$data['register_type'];
        $where['register_major'] = $data['register_major'];
        $page_num   = isset( $data['page_num']) ?  $data['page_num']  : 0;
        $page_size  = isset($data['page_size']) ?  $data['page_size'] : 10;

        $field = "people_id,GROUP_CONCAT(register_type SEPARATOR ',') as register_type,GROUP_CONCAT(register_major SEPARATOR ',') as register_major,GROUP_CONCAT(register_unit SEPARATOR ',') as register_unit,GROUP_CONCAT(register_date SEPARATOR ',') as register_date";
        $res = (new PeopleRegister())->getPeopleID($where,$field,$page_num,10)['list'];

        if (!$res) {
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        $dataList = [];
        $list = [];
        foreach ($res as $k=>&$value) {
            $map['id'] = $value['people_id'];
            $people_info = $people->getInfoByPeopleid($map,'people_name,people_sex,people_cardtype,people_cardnum');
            if($people_info){
                $value = array_merge($value,$people_info);
            }
            $value['register_type'] = explode(',',$value['register_type']);
            $value['register_major'] = explode(',',$value['register_major']);
            $value['register_unit'] = explode(',',$value['register_unit']);
            $value['register_date'] = explode(',',$value['register_date']);
            foreach (  $value['register_type'] as $k=>$v ){
                $dataList['people_id'] = $value['people_id'];
                $dataList['register_type'] = $v;
                $dataList['register_major'] =  $value['register_major'][$k] ;
                $dataList['register_unit'] =  $value['register_unit'][$k] ;
                $dataList['register_date'] =  $value['register_date'][$k] ;
                $list[count($list)] = array_merge($dataList,$people_info);
            }
        }
        $titles =
            "人员id,人员姓名,'人员性别','证件类型','证件号码',注册类型,注册专业,注册单位,注册日期";
        $keys   =
            "people_id,people_name,people_sex,people_cardtype,people_cardnum,register_type,register_major,register_unit,register_date";
        $path = export_excel($titles, $keys, $list, '人员');
        return $this->apiReturn(['path'=>$path]);
    }
}
