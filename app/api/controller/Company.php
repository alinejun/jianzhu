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
		$ids_arr = explode(',', $get);
		$ids_arr = $this->transformGet($ids_arr);
		#得到符合资质查询条件的公司id
		$company_ids_arr = CompanyModel::getCompanyIds($ids_arr);

		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['data'] = $company_ids_arr;
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