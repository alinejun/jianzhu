<?php
namespace app\api\controller;

use think\Controller;
use app\api\model\Company as CompanyModel;

/** 
 * 企业-数据controller
 */
class Company extends Controller
{
	#获取企业数据
	public function getCompanyData(){
		if (!isset($_GET['code']) or empty($_GET)) {
			return 'require code!';
		}
		$get = $_GET['code'];
		#分页相关
        $page = isset($_GET['page'])?$_GET['page']:1;
        $page_size = isset($_GET['page_size'])?$_GET['page_size']:10;
        #process data
		$ids_arr = explode(',', $get);
		$ids_arr = $this->transformGet($ids_arr);
		#得到符合资质查询条件的公司id
		$company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
		#计算页数
        $total_num = count($company_ids_arr);
        $total_page = ceil($total_num/$page_size);

		#分页切片
        $company_ids_arr = array_slice($company_ids_arr,($page-1)*10,$page_size);
        #对查询到公司ID进行处理
        $company_data_list = [];
        foreach ($company_ids_arr as $key=>$value){
            $company_url = $value['company_url'];
            #处理企业名称、法定代表人、注册属地 (jz_company表)
            $company = (CompanyModel::getJzCompany($company_url));
            $company = $company[0];
            $company_data_list[$key]['company_name'] = $company['company_name'];
            $company_data_list[$key]['company_legalreprst'] = $company['company_legalreprst'];
            $company_data_list[$key]['company_regadd'] = $company['company_regadd'];
            #处理企业资质类别、资质名称、证书有效期（jz_qualification表）
            $company_data_list[$key]['qualification'] = CompanyModel::getJzQualification($company_url);
            #处理变更日期、变更内容（jz_cpny_change表）
            $company_data_list[$key]['cpny_change'] = CompanyModel::getJzCpnyChange($company_url);
            #处理诚信记录主体、决定内容、实施部门、发布有效期（jz_cpny_miscdct表）
            #由于此表现在无数据，且是company_id还是company_url链表 不明 暂附空值----<<<----
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
        }
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['page'] = intval($page);
		$res['page_size'] = intval($page_size);
		$res['total_page'] = intval($total_page);
		$res['total_num'] = intval($total_num);
		$res['data'] = $company_data_list;
		$res = json_encode($res);
		return $res;
	}
	#获取企业数据条数
	public function getCompanyDataNumber(){
		if (!isset($_GET['code']) or empty($_GET)) {
			return 'require code!';
		}
		$get = $_GET['code'];
		$ids_arr = explode(',', $get);
		$ids_arr = $this->transformGet($ids_arr);
		#得到符合资质查询条件的公司id
		$company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
		$nums = count($company_ids_arr);
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['data'] = $nums;
		$res = json_encode($res);
		return $res;
	}
	#处理get数据结构
	public function transformGet($ids_arr){
		$count = count($ids_arr);
		if ($count == 0){
			return null;
		}
		$tag_or = [];
		$tag_and = [];
		for($i=0;$i<$count;$i++){
			if (substr($ids_arr[$i], 0,1) == '('){
				#有or条件
				$tag_or[$i] = explode('|', (rtrim(ltrim($ids_arr[$i],'('),')')));
			}else{
				#and条件的
				$tag_and[$i] = $ids_arr[$i];
			}
		}
		$tag_or = array_values($tag_or);
		$tag_and = array_values($tag_and);
		$where_condition_arr[0] = $tag_or;
		$where_condition_arr[1] = $tag_and;
		return $where_condition_arr;
	}
}
?>