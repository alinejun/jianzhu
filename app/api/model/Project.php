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
/*    public function getData($where=1,$field="*",$page=10,$num=0)
    {
        return $this->where($where)->field($field)->limit($num * $page, $page)->select();
    }*/
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
            $join[] = " left join jz_project_finish pf on (p.project_url = pf.project_url and (pc.company_inpurl = pf.company_dsnurl or pc.company_inpurl = pf.company_spvurl or pc.company_inpurl = pf.company_csturl)) ";
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

    //获取项目数据V2.0
    public function getProjectV2($where=1,$field="*",$page=10,$num=1)
    {
        // 基础数据
        $sql = "select ".$field." from jz_com_pro cp join jz_project p on cp.project_url=p.project_url where cp.company_url = ".$where['company_url']." limit ".($num-1) * $page.",".$page;
        $projectInfo = Db::query($sql);
        // 页数
        $sql_count = "select count(*) as totalNum  from jz_com_pro cp join jz_project p on cp.project_url=p.project_url where cp.company_url = ".$where['company_url'];
        $pageTotal = Db::query($sql_count);
        if (!empty($pageTotal)){
            $pageTotal = $pageTotal[0]['totalNum'];
        }else{
            $pageTotal = 0;
        }
        $data['projectInfo'] = isset($projectInfo)?$projectInfo:'';
        $data['totalNum'] = isset($pageTotal)?$pageTotal:'';
        if (is_numeric($data['totalNum'])){
            $data['totalpage'] = ceil($data['totalNum']/$page);
        }else{
            $data['totalpage'] = 1;
        }
        return $data;
    }

    // 获取项目详细数据V2.0
    public function getProjectDetailV2($project_url,$company_url,$detail_type){
        // init
        $detail = [];

        // 获取招投标
        if ($detail_type == 1){
            $detail['bid'] = [];
            $sql_bid = "select bid_type,bid_way,bid_unitname,bid_date,bid_money,bid_area,bid_unitagency,bid_pname,bid_pnum
                        from jz_project_bid
                        where project_url = ".$project_url." and company_url = ".$company_url." 
        ";
            $res_bid = Db::query($sql_bid);
            $detail['bid'] = $res_bid;
        }

        // 获取施工图审查
        elseif ($detail_type == 2){
            $detail['censor'] = [];
            $sql_censor = "select censor_unitrcs,censor_unitdsn
                          from jz_project_censor
                          where project_url = ".$project_url." and ( company_dsnurl = ".$company_url." or company_rcsurl = ".$company_url." ) 
        ";
            $res_censor = Db::query($sql_censor);
            $detail['censor'] = $res_censor;
        }

        // 获取合同备案
        elseif ($detail_type == 3){
            $detail['contract'] = [];
            $sql_contract = "select contract_type,contract_money,contract_signtime,contract_scale,company_out_name,contract_unitname,contract_type
                            from jz_project_contract
                            where project_url = ".$project_url." and company_inpurl = ".$company_url." 
        ";
            $res_contract = Db::query($sql_contract);
            $detail['contract'] = $res_contract;
        }

        // 获取施工许可
        // 由于数据问题，project_permit 表 切换到 project_permit_new
        elseif ($detail_type == 4){
            $detail['permit'] = [];
            $sql_permit = "select permit_money,permit_area,permit_certdate,permit_unitrcs,permit_unitdsn,permit_unitspv,permit_unitcst,permit_manager,permit_managerid,permit_monitor,permit_monitorid
                            from jz_project_permit_new
                            where project_url = ".$project_url." and ( company_csturl = ".$company_url." or company_rcsurl = ".$company_url." or company_dsnurl = ".$company_url." or company_spvurl = ".$company_url." ) 
        ";
            $res_permit = Db::query($sql_permit);
            $detail['permit'] = $res_permit;
        }

        // 获取竣工验收备案
        elseif ($detail_type == 5){
            $detail['finish'] = [];
            $sql_finish = "select finish_money,finish_area,finish_realbegin,finish_realfinish,finish_unitdsn,finish_unitspv,finish_unitcst
                            from jz_project_finish
                            where project_url = ".$project_url." and ( company_csturl = ".$company_url." or company_dsnurl = ".$company_url." or company_spvurl = ".$company_url." ) 
        ";
            $res_finish = Db::query($sql_finish);
            $detail['finish'] = $res_finish;
        }

        // default
        else{
            $detail['error'] = "this is error type, pls try again !";
        }

        return $detail;
    }

    // 查询数据给单查项目名称时候的导出
    public function getDataForExportV2($company_url){
        $sql = "SELECT
            p.project_url,p.project_name,p.project_area,p.project_unit,p.project_type,p.project_nature,p.project_use,
            p.project_allmoney,p.project_acreage,p.project_level,
            pb.bid_type,pb.bid_way,pb.bid_unitname,pb.bid_date,pb.bid_money,pb.bid_area,pb.bid_unitagency,
            pb.bid_pname,pb.bid_pnum,
            ppn.permit_money,ppn.permit_area,ppn.permit_certdate,ppn.permit_unitrcs,ppn.permit_unitdsn,ppn.permit_unitspv,ppn.permit_unitcst,
            ppn.permit_manager,ppn.permit_managerid,ppn.permit_monitor,ppn.permit_monitorid,
            pc.contract_type,pc.contract_money,pc.contract_signtime,pc.contract_scale,pc.company_out_name,pc.contract_unitname,
            pf.finish_money,pf.finish_area,pf.finish_realbegin,pf.finish_realfinish,pf.finish_unitdsn,pf.finish_unitspv,pf.finish_unitcst
            
        FROM
            jz_com_pro cp
        JOIN jz_project p ON cp.project_url = p.project_url
        LEFT JOIN jz_project_bid pb ON pb.project_url = p.project_url and pb.company_url = {$company_url}
        LEFT JOIN jz_project_permit_new ppn ON p.project_url = ppn.project_url and ( ppn.company_csturl = ".$company_url." or ppn.company_rcsurl = ".$company_url." or ppn.company_dsnurl = ".$company_url." or ppn.company_spvurl = ".$company_url." ) 
        LEFT JOIN jz_project_contract pc ON p.project_url = pc.project_url and pc.company_inpurl = ".$company_url." 
        LEFT JOIN jz_project_finish pf ON p.project_url = pf.project_url and ( pf.company_csturl = ".$company_url." or pf.company_dsnurl = ".$company_url." or pf.company_spvurl = ".$company_url." )
        WHERE
            cp.company_url = {$company_url};
        ";
        $res = Db::query($sql);
        return $res;
    }
}
