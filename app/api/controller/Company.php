<?php
namespace app\api\controller;

use think\Controller;
use app\api\model\Company as CompanyModel;

/** 
 * 企业-数据controller
 */
class Company extends Controller
{
	#获取数据
	public function getCompanyData(){
		$get = $_GET;
		$data_list = CompanyModel::getCompanyData($code);
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['data'] = $data_list;
		$res = json_encode($res);
		return $res;
	}
}
?>