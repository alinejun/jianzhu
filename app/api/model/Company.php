<?php
namespace app\api\model;

use think\Model;
use think\Db;

/**
 * 企业-筛选条件model
 */
class Company extends Model
{
	#获取资质类别
	public static function getData($code){
		// $sql = "SELECT 
		// 		    id, apt_code AS code, apt_scope AS name, is_end, zhizi_level as level
		// 		FROM
		// 		    jz_qualification_type
		// 		WHERE
		// 		    apt_code2 = '$code'
		// 		ORDER BY id ASC ";
		// $res = Db::query($sql);
		// if (!empty($res)) {
		// 	return $res;
		// }else{
		// 	return null;
		// }
	}
}
?>