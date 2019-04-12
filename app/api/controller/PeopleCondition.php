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
use think\Db;

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

    #获取people_id 用于查询company_url
    public function getCompany($data)
    {

        ini_set('max_execution_time',0);
        $where['register_type']  =  $data['register_type'];
        $where['register_major'] =  $data['register_major'];
        $people_id = $this->newQueryLogic($where);

        if(!$people_id){
            return false;
        }
        //根据人员id获取对应的公司集合总数

        $count = \app\api\model\People::getCompanyByPeopleIds($people_id,1);
        return ['company_list'=>[],'count'=>$count];
    }

    #获取满足人员条件的company_url集合
    public function getPeopleConditionCompanyUrl($data)
    {
        ini_set('max_execution_time',0);
        $where['register_type']  =  $data['register_type'];
        $where['register_major'] =  $data['register_major'];
        if(isset($data['company_url'])){
  	  $where['company_url'] = $data['company_url'];
          }
        $people_id = $this->newQueryLogic($where,1);
        $list = \app\api\model\People::getCompanyByPeopleIds($people_id,0);
        if(!$list){
            return false;
        }
        //根据人员id获取对应的公司集合
        return ['company_list'=>$list];
    }

    #处理查询逻辑(新的)

    /**
     * @param $data 查询条件
     * @param int $type 1：查询company_url，0:查询people_id
     * @return array|mixed
     */
    public function newQueryLogic($data,$type=0)
    {

        $register_type  = explode(',',$data['register_type']);

        $register_major = explode(',',$data['register_major']);

        $where = $map = [];
        foreach ($register_type as $k=>$v){
            if(empty($register_major[$k])){ //收集只查询类型的条件
                $where[] = $v;
            }else{ //收集查询类型并有专业的条件
                $map1['register_type']  = $v;
                $map1['register_major'] = $register_major[$k];
                $map[] = $map1;
            }
        }

        //开始查询
        if(!empty($where)){
            foreach ($where as $value){
                if(!isset($data['company_url'])){
                    $data['company_url'] = [];
                }
                $binji[] = $this->peopleRegisterReset->getListDataIn($value,$data['company_url'],$type,'company_url,people_id')->toArray();
            }

            foreach ($binji as $k=>$v){
               $jiao_people_str[$k] =array_column($v,'people_id');
            }
            if(count($jiao_people_str)>1){
                $bin_people_arr_data = call_user_func_array ('array_intersect', $jiao_people_str);
            }elseif(count($jiao_people_str)==1){
                $bin_people_arr_data = $jiao_people_str[0];
            }else{
                $bin_people_arr_data = [];
            }
        }

        //满足类型-专业条件查找
        if(!empty($map)){
            $jiao = [] ;
            foreach ($map as $k=>$value){
                if(!isset($data['company_url'])){
                    $data['company_url'] = [];
                }
                $jiao[] = $this->peopleRegisterReset->getListData($value,$data['company_url'],'id,register_type,register_major,people_id,company_url')->toArray();
            }
            $jiao_arr = [];
            foreach ($jiao as $k=>$v){
                $jiao_arr[$k] = array_column($v,'people_id');
            }
            if(count($jiao)>1){
                $jiao_arr = call_user_func_array ('array_intersect', $jiao_arr);
            }elseif(count($jiao)==1){
                $jiao_arr = $jiao_arr[0];
            }else{
                $jiao_arr = [];
            }
        }
        //对最后的结果取交集
        if(empty($jiao_arr) && !empty($bin_people_arr_data)){
            $bin_people_arr_data = array_unique($bin_people_arr_data);
            return $bin_people_arr_data;
        }elseif(empty($bin_people_arr_data) && !empty($jiao_arr)){
            return $jiao_arr;
        }elseif(!empty($bin_people_arr_data) && !empty($jiao_arr)){
            $bin_people_arr_data = array_unique($bin_people_arr_data);
            return array_intersect($bin_people_arr_data,$jiao_arr);
        }else{
            return [0];
        }
    }

    public function getPeopleLists($data)
    {
        $people = new People();
        $where['register_type'] =$data['register_type'];
        $where['register_major'] = $data['register_major'];
        $page_num   = isset( $data['page']) ?  $data['page']  : 1;
        $page_size  = isset($data['page_size']) ?  $data['page_size'] : 10;
        $people_ids = $this->newQueryLogic($where,1);
        $people_id = array_slice(array_unique($people_ids),($page_num-1)*$page_size,$page_size);

        if (!$people_id) {
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        $list = [] ;
        foreach ($people_id as $k=>&$value) {
            $list[$k]['id'] = $value;
            $map['id'] = $value;
            $people_info = $people->getInfoByPeopleid($map,'people_name,people_url,people_sex,people_cardtype,people_cardnum');
            if($people_info){
                $list[$k]= array_merge($list[$k],$people_info);
            }
            $people_reigster_info  = PeopleRegister::getRegisterInfoByPeopleId($value);
            $list[$k]['register_type'] = array_column($people_reigster_info,'register_type');
            $list[$k]['register_major'] = array_column($people_reigster_info,'register_major');
            $list[$k]['register_unit']  = array_column($people_reigster_info,'register_unit');
            $list[$k]['register_date']  = array_column($people_reigster_info,'register_date');
            $list[$k]['people_project'] = PeopleProject::getDataByPeopleId( $value,'project_name,project_url',0);
            $list[$k]['people_change']  = PeopleChange::getDataByPeopleId( $value,'change_record');
            $list[$k]['people_miscdct']  = PeopleMiscdct::getDataByPeopleId($people_info['people_url'],'miscdct_content');
        }

        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['data']['data_list'] = $list;
        $refer['data']['total_num'] = count($people_ids);
        $refer['data']['total_page'] = ceil(count($people_ids)/$page_size);
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
        $people_url = (new People())->find($people_id)['people_url'];
        $map['people_id'] = $people_id;
        //（受不鸟）人员相关数据暂时限制1000条数据。
        $data['register'] = (new PeopleRegister())->getDataByPeopleId($map, "register_type,register_major,register_date,register_unit");
        $data['project'] = array_column((new PeopleProject())->getData($map, "project_name", 0, 1000),'project_name');
        $data['miscdct'] = (new PeopleMiscdct())->getData(['people_url'=>$people_url], "miscdct_name,miscdct_content,miscdct_dept,miscdct_date", 0, 1000);
        $data['change'] = (new PeopleChange())->getData($map, "change_type,change_record", 0, 1000);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] = Code::$MSG[$refer['code']];
        $refer['people_info'] = $data;
        return $this->apiReturn($refer);

    }

    public function exportPeople($data)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 0);
        $people = new People();
        $where['register_type'] =/*'二级注册建筑师';//*/$data['register_type'];
        $where['register_major'] = /*'';//*/$data['register_major'];

        $people_ids = $this->newQueryLogic($where);
        //dump(count($people_ids));exit;
        if (!$people_ids) {
            $refer['code'] = Code::ERROR;
            $refer['msg'] = Code::$MSG[$refer['code']];
            return $this->apiReturn($refer);
        }
        $dataList = [];
        $list = [];
        $temp =$lastData= [];
       // $people_ids1 = array_splice($people_ids,0,300);
        foreach ($people_ids as $k=>$value) {
            $list[$k]['id'] = $map['id'] = $value;
            $people_info = $people->getInfoByPeopleid($map,'people_name,people_sex,people_cardtype,people_cardnum,people_url');
            if($people_info){
                $list[$k] = array_merge($list[$k],$people_info);
            }
            $people_reigster_info  = PeopleRegister::getRegisterInfoByPeopleId($value);
            $temp['register_type'] = array_column($people_reigster_info,'register_type');
            $temp['register_major'] = array_column($people_reigster_info,'register_major');
            $temp['register_unit']  = array_column($people_reigster_info,'register_unit');
            $temp['register_date']  = array_column($people_reigster_info,'register_date');
            $people_project_info = PeopleProject::getDataByPeopleId( $value,'project_name,project_url',0);
            $people_info['people_project_num'] = count($people_project_info);
            $people_info['people_project'] = implode(';',array_column($people_project_info,'project_name'));
            $people_info['project_url'] = implode(';',array_column($people_project_info,'project_url'));
            $people_info['people_change']  =  implode(';',array_column(PeopleChange::getDataByPeopleId( $value,'change_record'),'people_change'));
            if($people_info['people_url']){
                $people_info['people_miscdct']  =  implode(';',PeopleMiscdct::getDataByPeopleId($people_info['people_url'],'miscdct_content'));
            }else{
                $people_info['people_miscdct']  =  '';
            }

            foreach (   $temp['register_type'] as $j=>$v ){
                $lastData['people_id'] = $value;
                $lastData['register_type']  = $v;
                $lastData['register_major'] = $temp['register_major'][$j] ;
                $lastData['register_unit']  = $temp['register_unit'][$j] ;
                $lastData['register_date']  =  $temp['register_date'][$j] ;
                $lastData = array_merge($lastData,$people_info);
                $dataList[] = $lastData;
            }
        }
        $titles =
            "人员id,人员姓名,人员性别,证件类型,证件号码,注册类型,注册专业,注册单位,注册日期,业绩数量,业绩名称,'project_url',变更记录,失信记录";
        $keys   =
            "people_id,people_name,people_sex,people_cardtype,people_cardnum,register_type,register_major,register_unit,register_date,people_project_num,people_project,project_url,people_change,people_miscdct";
        $path = export_excel($titles, $keys, $dataList, 'people');
        return $this->apiReturn(['path'=>$path]);
    }
}
