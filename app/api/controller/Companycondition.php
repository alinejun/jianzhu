<?php
namespace app\api\controller;

use think\Controller;
use app\api\model\Companycondition as CompanyconditionModel;

/**
 *@api http://127.0.0.1/jianzhu/public/index.php/companycondition/qualificationType?code=A
 *@params code 所选code类别  
 * 企业-相关筛选条件controller
 */
class Companycondition extends Controller
{
	#资质类别
	public function qualificationType(){
		$get = $_GET;
		$code = isset($get['code'])?$get['code']:'A';
		$data_list = CompanyconditionModel::getQualificationType($code);
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['data'] = $data_list;
		$res = json_encode($res);
		return $res;
	}
}
?>