<?php
/**
 * Created by PhpStorm.
 * User: Dishiao
 * Date: 2019/2/17
 * Time: 22:05
 */
namespace app\api\model;

use think\model;
use think\Db;

class Project extends model{
    #根据参数查询项目（单查项目）
    public static function getProjectData($params_arr){
        #init
        $field = [];
        $join = [];
        $where = [];
        #init data
        $field[] = 'p.project_url';
        $where[] = " 1=1 ";
        $count_filter_tables = 0;
        if ($params_arr['bid'] == 1){
            $join[] = ' left join jz_project_bid pb on pb.project_url = p.project_url ';
            $field[] = 'pb.company_url as pb_company_url';
            $count_filter_tables++;
        }
        if ($params_arr['contract'] == 1){
            $join[] = ' left join jz_project_contract pc on pc.project_url = p.project_url ';
            $field[] = 'pc.company_inpurl as pc_company_url';
            $count_filter_tables++;
        }
        if ($params_arr['finish'] == 1){
            $join[] = ' left join jz_project_finish pf on pf.project_url = p.project_url ';
            $field[] = 'pf.company_dsnurl as pf_company_url0';
            $field[] = 'pf.company_spvurl as pf_company_url1';
            $field[] = 'pf.company_csturl as pf_company_url2';
            $count_filter_tables++;
        }
        #transform where
        $where = Project::transformWhere($params_arr);
        #transform
        $join_str = implode(' ',$join);
        $field_str = implode(',',$field);
        $where_str = implode(' and ',$where);
        #sql
        $sql = "select ".$field_str." from jz_project p ".$join_str." where ".$where_str." limit 1000";
        #do-sql
        $res = Db::query($sql);
        #process
        $result = Project::processRes($res,$params_arr,$count_filter_tables);
        return $result;
    }
    #转换where条件
    public static function transformWhere($where){
        $where_finish=[];
        if (isset($where['project_type'])){$where_finish[] = "p.project_type=".$where['project_type'];}
        if (isset($where['project_nature'])){$where_finish[] = "p.project_nature=".$where['project_nature'];}
        if (isset($where['project_use'])){$where_finish[] = "p.project_use=".$where['project_use'];}
        if (isset($where['bid_way'])){$where_finish[] = "pb.bid_way=".$where['bid_way'];}
        if (isset($where['bid_money'])){$where_finish[] = "pb.bid_money>=".$where['bid_money'];}
        if (isset($where['bid_date_start'])){$where_finish[] = "pb.bid_date>=".$where['bid_date_start'];}
        if (isset($where['bid_date_end'])){$where_finish[] = "pb.bid_date<=".$where['bid_date_end'];}
        if (isset($where['contract_type'])){$where_finish[] = "pc.contract_type=".$where['contract_type'];}
        if (isset($where['contract_money'])){$where_finish[] = "pc.contract_money>=".$where['contract_money'];}
        if (isset($where['contract_scale'])){$where_finish[] = "pc.contract_scale>=".$where['contract_scale'];}
        if (isset($where['contract_date_start'])){$where_finish[] = "pc.contract_date>=".$where['contract_date_start'];}
        if (isset($where['contract_date_end'])){$where_finish[] = "pc.contract_date<=".$where['contract_date_end'];}
        if (isset($where['finish_money'])){$where_finish[] = "pf.finish_money>=".$where['finish_money'];}
        if (isset($where['finish_area'])){$where_finish[] = "pf.finish_area>=".$where['finish_area'];}
        if (isset($where['finish_realbegin_start'])){$where_finish[] = "pf.finish_realbegin>=".$where['finish_realbegin_start'];}
        if (isset($where['finish_realbegin_end'])){$where_finish[] = "pf.finish_realbegin<=".$where['finish_realbegin_end'];}
        if (isset($where['finish_realfinish_start'])){$where_finish[] = "pf.finish_realfinish>=".$where['finish_realfinish_start'];}
        if (isset($where['finish_realfinish_end'])){$where_finish[] = "pf.finish_realfinish<=".$where['finish_realfinish_end'];}
        return $where_finish;
    }
    #处理查询出来的数据
    protected static function processRes($res,$params_arr,$count_filter_tables){
        $result = [];
        $count_res = count($res);
        if ($count_filter_tables == 0){
            #没有选择项目子表的筛选项，只选择了基础筛选字段
            if ($count_res > 0){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['project_url'];
                }
            }
        }elseif ($count_filter_tables == 1){
            #如果只选了招投标一个
            if ($params_arr['bid'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pb_company_url'];
                }
            }
            #如果只选了合同备案一个
            if ($params_arr['contract'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pc_company_url'];
                }
            }
            #如果只选了竣工验收一个
            if ($params_arr['finish'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pf_company_url0'];
                    $result[] = $res[$i]['pf_company_url1'];
                    $result[] = $res[$i]['pf_company_url2'];
                }
            }
        }elseif ($count_filter_tables == 2){
            #选中了招投标和合同备案
            if ($params_arr['bid'] == 1 && $params_arr['contract'] == 1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url']) {
                        $result[] = $res[$i]['pb_company_url'];
                    }
                }
            }
            #选中了招投标和竣工验收
            if ($params_arr['bid'] == 1 && $params_arr['finish'] == 1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pb_company_url'] == $res[$i]['pf_company_url0'] || $res[$i]['pb_company_url'] == $res[$i]['pf_company_url1'] || $res[$i]['pb_company_url'] == $res[$i]['pf_company_url2']) {
                        $result[] = $res[$i]['pb_company_url'];
                    }
                }
            }
            #选中了合同备案和竣工验收
            if ($params_arr['contract'] == 1 && $params_arr['finish'] ==1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pc_company_url'] == $res[$i]['pf_company_url0'] || $res[$i]['pc_company_url'] == $res[$i]['pf_company_url1'] || $res[$i]['pc_company_url'] == $res[$i]['pf_company_url2']) {
                        $result[] = $res[$i]['pc_company_url'];
                    }
                }
            }
        }elseif ($count_filter_tables == 3){
            #同时选中了招投标、合同备案、竣工验收
            for ($i = 0; $i < $count_res; $i++) { 
                if (($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url0']) || ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url1']) || ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url2'])) {
                    $result[] = $res[$i]['pb_company_url'];
                }
            }
        }
        #company_url去重
        $result = array_unique($result);
        return $result;
    }
}