<?php
/**
 * Created by PhpStorm.
 * User: Dishiao
 * Date: 2019/2/17
 * Time: 22:05
 */
namespace app\api\model;

use think\db\Query;
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
            $join[] = ' join jz_project_bid pb on pb.project_url = p.project_url ';
            $field[] = 'pb.company_url as pb_company_url';
            $count_filter_tables++;
        }
        if ($params_arr['contract'] == 1){
            $join[] = ' join jz_project_contract pc on pc.project_url = p.project_url ';
            $field[] = 'pc.company_inpurl as pc_company_url';
            $count_filter_tables++;
        }
        if ($params_arr['finish'] == 1){
            $join[] = ' join jz_project_finish pf on pf.project_url = p.project_url ';
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
        $sql = "select ".$field_str." from jz_project p ".$join_str." where ".$where_str." limit 2000";
        #do-sql
        $res = Db::query($sql);
        #process
        $result = Project::processRes($res,$params_arr,$count_filter_tables);
        return $result;
    }
    #转换where条件
    public static function transformWhere($where){
        $where_finish=[];
        # 针对联查得出的project_url_str做一个in
        if (isset($where['project_url_str']) && !empty($where['project_url_str'])){$where_finish[] = "p.project_url in ( ".$where['project_url_str']." )";}
        if (isset($where['bid_money'])){$where_finish[] = "pb.bid_money>=".$where['bid_money'];}
        if (isset($where['contract_money'])){$where_finish[] = "pc.contract_money>=".$where['contract_money'];}
        if (isset($where['finish_money'])){$where_finish[] = "pf.finish_money>=".$where['finish_money'];}
        if (isset($where['contract_scale'])){$where_finish[] = "pc.contract_scale>=".$where['contract_scale'];}
        if (isset($where['finish_area'])){$where_finish[] = "pf.finish_area>=".$where['finish_area'];}
        if (!empty($where)){
            # 遍历-加上引号
            $toQuotation = function($param) {
                return "'".$param."'";
            };
            $where = array_map($toQuotation,$where);
        }
        if (isset($where['project_type'])){$where_finish[] = "p.project_type=".$where['project_type'];}
        if (isset($where['project_nature'])){$where_finish[] = "p.project_nature=".$where['project_nature'];}
        if (isset($where['project_use'])){$where_finish[] = "p.project_use=".$where['project_use'];}
        if (isset($where['bid_way'])){$where_finish[] = "pb.bid_way=".$where['bid_way'];}
        if (isset($where['bid_date_start'])){$where_finish[] = "pb.bid_date>=".$where['bid_date_start'];}
        if (isset($where['bid_date_end'])){$where_finish[] = "pb.bid_date<=".$where['bid_date_end'];}
        if (isset($where['contract_type'])){$where_finish[] = "pc.contract_type=".$where['contract_type'];}
        if (isset($where['contract_date_start'])){$where_finish[] = "pc.contract_signtime>=".$where['contract_date_start'];}
        if (isset($where['contract_date_end'])){$where_finish[] = "pc.contract_signtime<=".$where['contract_date_end'];}
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
//                    $result[$i]['project_url'] = $res[$i]['project_url'];
                    $result[] = $res[$i]['project_url'];
                }
                # 去连表里面查对应的 公司
                $result_str = implode(',',$result);
                $sql_com_pro = "select distinct(company_url) from jz_com_pro where project_url in (".$result_str.")";
                $res_com = Db::query($sql_com_pro);
                foreach ($res_com as $key=>$value){
                    $result[] = $value['company_url'];
                }
            }
        }elseif ($count_filter_tables == 1){
            #如果只选了招投标一个
            if ($params_arr['bid'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pb_company_url'];
//                    $result[$i]['project_url'] = $res[$i]['project_url'];
                }
            }
            #如果只选了合同备案一个
            if ($params_arr['contract'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pc_company_url'];
//                    $result[$i]['project_url'] = $res[$i]['project_url'];
                }
            }
            #如果只选了竣工验收一个
            if ($params_arr['finish'] == 1){
                for ($i = 0;$i < $count_res;$i++){
                    $result[] = $res[$i]['pf_company_url0'];
                    $result[] = $res[$i]['pf_company_url1'];
                    $result[] = $res[$i]['pf_company_url2'];
//                    $result[$i]['project_url'] = $res[$i]['project_url'];
                }
            }
        }elseif ($count_filter_tables == 2){
            #选中了招投标和合同备案
            if ($params_arr['bid'] == 1 && $params_arr['contract'] == 1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url']) {
                        $result[] = $res[$i]['pb_company_url'];
//                        $result[$i]['project_url'] = $res[$i]['project_url'];
                    }
                }
            }
            #选中了招投标和竣工验收
            if ($params_arr['bid'] == 1 && $params_arr['finish'] == 1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pb_company_url'] == $res[$i]['pf_company_url0'] || $res[$i]['pb_company_url'] == $res[$i]['pf_company_url1'] || $res[$i]['pb_company_url'] == $res[$i]['pf_company_url2']) {
                        $result[] = $res[$i]['pb_company_url'];
//                        $result[$i]['project_url'] = $res[$i]['project_url'];
                    }
                }
            }
            #选中了合同备案和竣工验收
            if ($params_arr['contract'] == 1 && $params_arr['finish'] ==1) {
                for ($i = 0; $i < $count_res; $i++) { 
                    if ($res[$i]['pc_company_url'] == $res[$i]['pf_company_url0'] || $res[$i]['pc_company_url'] == $res[$i]['pf_company_url1'] || $res[$i]['pc_company_url'] == $res[$i]['pf_company_url2']) {
                        $result[] = $res[$i]['pc_company_url'];
//                        $result[$i]['project_url'] = $res[$i]['project_url'];
                    }
                }
            }
        }elseif ($count_filter_tables == 3){
            #同时选中了招投标、合同备案、竣工验收
            for ($i = 0; $i < $count_res; $i++) { 
                if (($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url0']) || ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url1']) || ($res[$i]['pb_company_url'] == $res[$i]['pc_company_url'] && $res[$i]['pc_company_url'] == $res[$i]['pf_company_url2'])) {
                    $result[] = $res[$i]['pb_company_url'];
//                    $result[$i]['project_url'] = $res[$i]['project_url'];
                }
            }
        }
        #去重
        $result = array_unique($result);
        #重新排序
        $result = array_values($result);
        return $result;
    }


    /**
     * @return mixed|void
     */
    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return $this->where($where)->field($field)->limit($num * $page, $page)->select();
    }
    #查询项目详情数据
    public static function getProjectDataDetail($params_arr){
        # init
        $page = 1;
        $page_size = 10;
        $field = [
        'p.project_name','p.project_type','p.project_nature','p.project_use','p.project_allmoney','p.project_acreage',
        'pb.bid_type','pb.bid_way','pb.bid_unitname','pb.bid_date','pb.bid_money','pb.bid_area','pb.bid_unitagency','pb.bid_url',
        'pc.contract_type','pc.contract_money','pc.contract_signtime','pc.contract_scale','pc.contract_unitname','pc.contract_add_url',
        'pf.finish_money','pf.finish_area','pf.finish_realbegin','pf.finish_realfinish','pf.finish_unitdsn','pf.finish_unitspv','pf.finish_unitcst','pf.finish_add_url'
        ];
        $where = [];
        $join = [];
        # 转换page page_size 等
        if (isset($params_arr['page']) && is_numeric($params_arr['page'])){
            $page = $params_arr['page'];
        }
        if (isset($params_arr['page_size']) && is_numeric($params_arr['page_size'])){
            $page_size = $params_arr['page_size'];
        }
        # 判断连表
        # 有筛选项则用 join 没有选的就用left join 这样可以保证没有选的 不会被连表条件所影响
        if ($params_arr['bid'] == 1 && $params_arr['contract'] == 0 && $params_arr['finish'] == 0){
            #只选择了招投标
            $join[] = " join jz_project_bid pb on p.project_url = pb.project_url ";
            $join[] = " left join jz_project_contract pc on (p.project_url = pc.project_url and pb.company_url = pc.company_inpurl) ";
            $join[] = " left join jz_project_finish pf on (p.project_url = pf.project_url and (pb.company_url = pf.company_dsnurl or pb.company_url = pf.company_spvurl or pb.company_url = pf.company_csturl)) ";
        }elseif ($params_arr['bid'] == 0 && $params_arr['contract'] == 1 && $params_arr['finish'] == 0){
            #只选择了合同备案
            $join[] = " join jz_project_contract pc on p.project_url = pc.project_url ";
            $join[] = " left join jz_project_bid pb on p.project_url = pb.project_url and pb.company_url = pc.company_inpurl ";
            $join[] = " left join jz_project_finish pf on (p.project_url = pf.project_url and (pc.company_url = pf.company_dsnurl or pc.company_url = pf.company_spvurl or pc.company_url = pf.company_csturl)) ";
        }elseif ($params_arr['bid'] == 0 && $params_arr['contract'] == 0 && $params_arr['finish'] == 1){
            # 子表只选了竣工验收
            $join[] = " join jz_project_finish pf on p.project_url = pf.project_url ";
            $join[] = " left join jz_project_bid pb on (p.project_url = pb.project_url and (pb.company_url = pf.company_dsnurl or pb.company_url = pf.company_spvurl or pb.company_url = pf.company_csturl)) ";
            $join[] = " left join jz_project_contract pc on (p.project_url = pc.project_url and pb.company_url = pc.company_inpurl) ";
        }elseif ($params_arr['bid'] == 1 && $params_arr['contract'] == 1 && $params_arr['finish'] == 0 ){
            #选了招投标 和 合同备案
            $join[] = " join jz_project_bid pb on p.project_url = pb.project_url";
            $join[] = " join jz_project_contract pc on p.project_url = pc.project_url and pb.company_url = pc.company_inpurl ";
            $join[] = " left join jz_project_finish pf on (p.project_url = pf.project_url and (pb.company_url = pf.company_dsnurl or pb.company_url = pf.company_spvurl or pb.company_url = pf.company_csturl)) ";
        }elseif ($params_arr['bid'] == 1 && $params_arr['contract'] == 0 && $params_arr['finish'] == 1){
            #选了招投标 和 竣工验收
            $join[] = " join jz_project_bid pb on p.project_url = pb.project_url";
            $join[] = " join jz_project_finish pf on (p.project_url = pf.project_url and (pb.company_url = pf.company_dsnurl or pb.company_url = pf.company_spvurl or pb.company_url = pf.company_csturl)) ";
            $join[] = " left join jz_project_contract pc on p.project_url = pc.project_url and pb.company_url = pc.company_inpurl ";
        }elseif ($params_arr['bid'] == 0 && $params_arr['contract'] == 1 && $params_arr['finish'] == 1){
            #选了合同备案 和 竣工验收
            $join[] = " join jz_project_contract pc on p.project_url = pc.project_url ";
            $join[] = " join jz_project_finish pf on (p.project_url = pf.project_url and (pc.company_inpurl = pf.company_dsnurl or pc.company_inpurl = pf.company_spvurl or pc.company_inpurl = pf.company_csturl)) ";
            $join[] = " left join jz_project_bid pb on p.project_url = pb.project_url and pb.company_url = pc.company_inpurl ";
        }elseif (
                    ($params_arr['bid'] == 1 && $params_arr['contract'] == 1 && $params_arr['finish'] == 1) || //子表三个全选
                    ($params_arr['bid'] == 0 && $params_arr['contract'] == 0 && $params_arr['finish'] == 0)    //子表三个全不选
                ){
            $join[] = " join jz_project_bid pb on p.project_url = pb.project_url ";
            $join[] = " join jz_project_contract pc on (p.project_url = pc.project_url and pb.company_url = pc.company_inpurl) ";
            $join[] = " join jz_project_finish pf on (p.project_url = pf.project_url and (pb.company_url = pf.company_dsnurl or pb.company_url = pf.company_spvurl or pb.company_url = pf.company_csturl)) ";
        }
        # 处理转换where条件的参数
        $where = Project::transformWhere($params_arr);
        # change
        $field_str = implode(',',$field);
        $join_str = implode(' ',$join);
        $where_str = implode(' and ',$where);

        # sql
        if (isset($params_arr['is_limit']) && $params_arr['is_limit'] == false){
            # 因为导出所以重写sql
            $sql = "select ".$field_str." from jz_project p ".$join_str." where ".$where_str;
            $res = Db::query($sql);
        }else{
            $sql = "select ".$field_str." from jz_project p ".$join_str." where ".$where_str." limit ".($page-1)*$page_size.",".$page_size;
            $res_data = Db::query($sql);
            $res['data_list'] = $res_data;
            # sql count 针对详情的时候给出一个 总页数和总数量
            $res['total_num'] = 0;
            $res['total_page'] = 1;
            $sql_count = "select count(*) as total_num  from jz_project p ".$join_str." where ".$where_str;
            $res_count = Db::query($sql_count);
            $res['total_num'] = $res_count[0]['total_num'];
            $res['total_page'] = ceil($res['total_num']/$page_size);
        }
        return $res;
    }
}
