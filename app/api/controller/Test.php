<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
use app\api\model\Test as testmodel;
/**
 * 
 */
class Test extends Controller
{
	//TEST
	public function test(){
		return 'this is my test controller';
	}
	//test mysql
	public function testsql(){
		$test_res = testmodel::testmodel();
		var_dump($test_res);
		$sql = 'SELECT region_id,region_name FROM jz_dis';
		$res = Db::query($sql);
		$res = json_encode($res);
		return $res;
	}
}



?>