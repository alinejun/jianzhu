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
					$where_and_str 
				ORDER BY x.company_url ";
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
	#根据company_url获取jz_company表相关数据
    public static function getJzCompany($company_url){
	    $sql = "SELECT
                  company_name,
                  company_legalreprst,
                  company_regadd
                FROM jz_company
                WHERE company_url = $company_url ";
	    $res = Db::query($sql);
	    return $res;
    }
    #根据company_url获取jz_qualification表相关数据
    public static function getJzQualification($company_url){
        $sql = "SELECT
                  ion_type_name,
                  ion_name,
                  ion_validity
                FROM jz_qualification
                WHERE company_url = $company_url ";
        $res = Db::query($sql);
        return $res;
    }
    #根据company_url获取jz_cpny_change表相关数据
    public static function getJzCpnyChange($company_url){
        $sql = "SELECT
                  change_content
                FROM jz_cpny_change
                WHERE company_url = $company_url ";
        $res = Db::query($sql);
        return $res;
    }
    #根据company_url查询表jz_cpny_miscdct
    public static function getJzCpnyMiscdct($company_url){
        $sql = "SELECT
                  miscdct_content
                FROM jz_cpny_miscdct
                WHERE company_url = $company_url ";
        $res = Db::query($sql);
        return $res;
    }

    #获取企业导出数据
    public static function getCompanyDataNotFormat($company_ids_str){
    	$sql = "
			SELECT
				c.company_name,
				c.company_legalreprst,
				c.company_regadd,
				q.ion_type_name,
				q.ion_name,
				q.ion_validity,
				cc.change_content,
				cm.miscdct_content
			FROM
				jz_company c
			LEFT JOIN jz_qualification q ON q.company_url = c.company_url
			LEFT JOIN jz_cpny_change cc ON cc.company_url = c.company_url
			LEFT JOIN jz_cpny_miscdct cm ON cm.company_url = c.company_url
			WHERE
				c.company_url IN (".$company_ids_str.")
		";
		$res = Db::query($sql);
		return $res;
    }

    /**
     * 获取公司详情
     * @param int $where
     * @param string $filed
     * @param int $pageSize
     * @param int $pageNum
     */
    public static function getComanyInfo($where=1,$filed="*",$pageSize=10,$pageNum=0)
    {
        return self::where($where)->field($filed)->limit($pageSize*$pageNum,$pageSize)->select()->toArray();
    }

    /**
     * @param string $keywords
     */
    public static function getNameByKeywords($keywords='',$filed="*",$pageSize=10,$pageNum=0)
    {
        if($keywords){
            $where['company_name'] = ['like',"%$keywords%"];
        }else{
            $where=1;
        }
        return self::where($where)->field($filed)->limit($pageSize*$pageNum,$pageSize)->select()->toArray();
    }

    /*
    * 根据company_url，查询企业对应的资质类别和名称
    *
    * @params
    *  $company_url 企业URL
    *
    * @return mixed 企业对应信息(资质类别和名称)
    * */
    public static function getCompanyInfoByUrl($company_url){
        $result = array();

        $sql_basic = "
                SELECT
                  company_name,
                  company_legalreprst,
                  company_regadd
                FROM jz_company
                WHERE company_url = {$company_url} 
                ";
        $res_basic = Db::query($sql_basic);

        if ($res_basic){
            list($res_basic) = $res_basic;
        }

        $sql_ion = "
                SELECT
                  ion_type_name,
                  ion_name,
                  ion_validity
                  ion_institution
                FROM jz_qualification
                WHERE company_url = {$company_url} 
                ";
        $res_ion = Db::query($sql_ion);

        if ($res_basic && $res_ion){
            $result['basic'] = $res_basic;
            $result['qualification'] = $res_ion;
        }else{
            $result['basic'] = $result['qualification'] = null;
        }

        return $result;
    }
}
?>