<?php
namespace app\api\model;

use think\Model;
use think\Db;

/**
 * 企业-查询model
 */
class Company extends Model
{
	#获取符合资质的公司ID
	public static function getCompanyIds($ids_arr){
		$where_and[] = '1=1' ;
		if (!empty($ids_arr[0])) {
			#有or
			$where_and = Company::processWhereOr($where_and,$ids_arr[0]);
		}
		if (!empty($ids_arr[1])) {
			#有and
			$where_and = Company::processWhereAnd($where_and,$ids_arr[1]);
		}
		$where_and_str = implode(' AND ', $where_and);
		#do-sql
		$sql = "SELECT
					x.company_url
				FROM
					(
						SELECT
							GROUP_CONCAT(ion_name_id) AS ids,
							company_url
						FROM
							`jz_qualification`
						GROUP BY
							company_url
					) x
				WHERE
					$where_and_str ";
		$res = Db::query($sql);
		return $res;
	}
	#有or条件的(多选了等级的资质名称)
	public static function processWhereOr($where_and,$ids_arr){
		$count = count($ids_arr);
		for($i=0;$i<$count;$i++){
			$count_ = count($ids_arr[$i]);
			$where_or = [];
			for ($j=0;$j<$count_;$j++){ 
				$where_or[] = "FIND_IN_SET(".$ids_arr[$i][$j].", x.ids)";
			}
			$where_or_str = implode(' OR ', $where_or);
			$where_and[] = '('.$where_or_str.')';
		}
		return $where_and;
	}
	#有and条件的(没有多选等级的资质名称)
	public static function processWhereAnd($where_and,$ids_arr){
		$count = count($ids_arr);
		for ($i=0;$i<$count;$i++){
		 	$where_and[] = "FIND_IN_SET(".$ids_arr[$i].", x.ids)";
		}
		return $where_and;
	}
}
?>