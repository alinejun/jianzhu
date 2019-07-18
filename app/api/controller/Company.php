<?php
namespace app\api\controller;

use think\Controller;
use app\api\model\Company as CompanyModel;

/** 
 * 企业-数据controller
 */
class Company extends ApiBase
{
	#获取企业数据
	public function getCompanyData($params){
		$get = $params['code'];
		#分页相关
        $page = isset($params['page'])?$params['page']:1;
        $page_size = isset($params['page_size'])?$params['page_size']:10;
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
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
        }
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['key'] = 'company';
		$res['data']['data_list'] = $company_data_list;
		$res['data']['page'] = intval($page);
		$res['data']['page_size'] = intval($page_size);
		$res['data']['total_page'] = intval($total_page);
		$res['data']['total_num'] = intval($total_num);
		$res = json_encode($res);
		return $res;
	}

	/*
	*	上面的是企业详情调用（有格式化处理，比如同一个公司有多个资质，那么相关的资质放在一个数组里面）
	*	下面的是企业详情导出调用 （无格式处理，直接SQL查询出来一对多，多条就多条）
	*/

	#获取企业导出数据
	public function getCompanyDataForExport($params){
		$get = $params['code'];
        #process data
		$ids_arr = explode(',', $get);
		$ids_arr = $this->transformGet($ids_arr);
		#得到符合资质查询条件的公司id
		$company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
		$company_ids_str = implode(array_column($company_ids_arr, 'company_url'), ',');
		$res = CompanyModel::getCompanyDataNotFormat($company_ids_str);
		return $res;
	}

	#获取企业数据条数
	public function getCompanyDataNumber($params){
		if (!isset($params['code']) or empty($params)) {
			return 'require code!';
		}
		$get = $params['code'];
		$ids_arr = explode(',', $get);
		$ids_arr = $this->transformGet($ids_arr);
		#得到符合资质查询条件的公司id
		$company_ids_arr = CompanyModel::getCompanyIds($ids_arr);
		$nums = count($company_ids_arr);
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['count'] = $nums;
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

	#查询企业详情 
	public function getCompanyDataDetail($params){
		$res = $this->getCompanyData($params);
		return $res;
	}

	#导出企业详情
	public function exportCompany($params){
		$list = $this->getCompanyDataForExport($params);
	 	$titles = "企业名称,企业法定代表人,企业注册属地,资质类别,资质名称,证书有效期,变更记录,诚信数据";
        $keys   = "company_name,company_legalreprst,company_regadd,ion_type_name,ion_name,ion_validity,change_content,miscdct_content";
        $path = export_excel($titles, $keys, $list, '企业');
        return $this->apiReturn(['path'=>$path]);
	}

	/**********************************************************************************
	 * 以下三个方法分别是 企业+项目、人员+项目、人员+企业+项目 查询出企业详情
	 * 由于起初设计问题，以及若将三个合并会有过多判断逻辑，目前只好分开成三个 function，有冗余
	 * 要注意，如果要更改需确认是否要三个一起改。
	 **********************************************************************************/
	/*
	 * 企业+项目 = 联查出企业详情
	 * 作用1 验证数据
	 * 作用2 方便看相关项目的企业数据
	 *
	 * @params 企业+项目联查的筛选条件
	 *
	 * @return mixed
	 * */
	public function getCompanyDetailByCompanyUnionProject(){
        $requsetData = input('post.');
        if (empty($requsetData)){
            $res['code'] = 0;
            $res['msg'] = 'failure, use method post, and please use the correct params.';
            $res['key'] = 'companyByCompanyUnionProject';
            $res['data'] = '';
            $res = json_encode($res);
            return $res;
        }
        $arr = $this->getArr($requsetData['request']);
        # 先查企业的符合的公司company_url
        $params_company = explode(',', $arr['company_condition_detail']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        # 再查项目符合的company_url
        $params_project = $arr['project_condition_detail'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        # 取交集
        $company_url = array_intersect($company_ids_arr,$project_ids_arr);
        $count = count($company_url);
        $page = isset($arr['company_condition_detail']['page']) ? ($arr['company_condition_detail']['page']) : 1;
        $page_size = isset($arr['company_condition_detail']['page_size']) ? ($arr['company_condition_detail']['page_size']) : 10;
        $total_num = $count;
        $total_page = ceil($total_num/$page_size);
        $company_url_arr = array_slice(array_unique($company_url),($page-1)*$page_size,$page_size);
        #对查询到公司ID进行处理
        $company_data_list = [];
        foreach ($company_url_arr as $key=>$value){
            $company_url = $value;
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
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
        }
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['key'] = 'companyByCompanyUnionProject';
        $res['data']['data_list'] = $company_data_list;
        $res['data']['page'] = intval($page);
        $res['data']['page_size'] = intval($page_size);
        $res['data']['total_page'] = intval($total_page);
        $res['data']['total_num'] = intval($total_num);
        $res = json_encode($res);
        return $res;
	}

    /*
     * 人员+项目 = 联查出企业详情
     *
     * @params 人员+项目联查的筛选条件
     *
     * @return mixed
     * */
    public function getCompanyDetailByPeoPleUnionProject(){
        $requsetData = input('post.');
        if (empty($requsetData)){
            $res['code'] = 0;
            $res['msg'] = 'failure, use method post, and please use the correct params.';
            $res['key'] = 'companyByPeopleUnionProject';
            $res['data'] = '';
            $res = json_encode($res);
            return $res;
        }
        $arr = $this->getArr($requsetData['request']);
        #init
        $request['people_condition_detail'] = $arr['people_condition_detail'];
        # 项目符合的company_url
        $params_project = $arr['project_condition_detail'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        //获取满足人员条件的企业url
        $request['people_condition_detail']['company_url'] = $project_ids_arr;
        $people_id = (new PeopleCondition())->newQueryLogic($request['people_condition_detail']);
        //获取交company_url
        $company_url = \app\api\model\People::getCompanyByPeopleIds($people_id,0);
        $count = count($company_url);
        $page = isset($arr['project_condition_detail']['page']) ? ($arr['project_condition_detail']['page']) : 1;
        $page_size = isset($arr['project_condition_detail']['page_size']) ? ($arr['project_condition_detail']['page_size']) : 10;
        $total_num = $count;
        $total_page = ceil($total_num/$page_size);
        $company_url_arr = array_slice(array_unique($company_url),($page-1)*$page_size,$page_size);
        #对查询到公司ID进行处理
        $company_data_list = [];
        foreach ($company_url_arr as $key=>$value){
            $company_url = $value;
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
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
        }
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['key'] = 'companyByPeopleUnionProject';
        $res['data']['data_list'] = $company_data_list;
        $res['data']['page'] = intval($page);
        $res['data']['page_size'] = intval($page_size);
        $res['data']['total_page'] = intval($total_page);
        $res['data']['total_num'] = intval($total_num);
        $res = json_encode($res);
        return $res;
    }

    /*
    * 人员+企业+项目 = 联查出企业详情
    *
    * @params 人员+企业+项目联查的筛选条件
    *
    * @return mixed
    * */
    public function getCompanyDetailByAllUnion(){
        $requsetData = input('post.');
        if (empty($requsetData)){
            $res['code'] = 0;
            $res['msg'] = 'failure, use method post, and please use the correct params.';
            $res['key'] = 'companyByAllUnion';
            $res['data'] = '';
            $res = json_encode($res);
            return $res;
        }
        $arr = $this->getArr($requsetData['request']);

        # 先查企业的符合的公司company_url
        $params_company = explode(',', $arr['company_condition_detail']['code']);
        $params_company = (new Company)->transformGet($params_company);
        $company_ids_arr = CompanyModel::getCompanyIds($params_company);
        $company_ids_arr = array_column($company_ids_arr,'company_url');
        # 再查项目符合的company_url
        $params_project = $arr['project_condition_detail'];
        $project_ids_arr = (new Project())->getProjectData($params_project);
        # 企业和项目的 company_url 取交集
        $company_url_arr = array_intersect($company_ids_arr,$project_ids_arr);
        //获取满足人员条件的企业url
        $people_id = (new PeopleCondition())->newQueryLogic($arr['people_condition_detail']);
        $people_company_url = \app\api\model\People::getCompanyByPeopleIds($people_id,0);

        //对符合条件的公司取交集
        if($people_company_url && $company_url_arr){
            $company_url = array_intersect($people_company_url,$company_url_arr);
        }else{
            $company_url = [];
        }

        $count = count($company_url);
        $page = isset($arr['project_condition_detail']['page']) ? ($arr['project_condition_detail']['page']) : 1;
        $page_size = isset($arr['project_condition_detail']['page_size']) ? ($arr['project_condition_detail']['page_size']) : 10;
        $total_num = $count;
        $total_page = ceil($total_num/$page_size);
        $company_url_arr = array_slice(array_unique($company_url),($page-1)*$page_size,$page_size);
        #对查询到公司ID进行处理
        $company_data_list = [];
        foreach ($company_url_arr as $key=>$value){
            $company_url = $value;
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
            $company_data_list[$key]['cpny_miscdct'] = CompanyModel::getJzCpnyMiscdct($company_url);
        }
        $res['code'] = 1;
        $res['msg'] = 'success';
        $res['key'] = 'companyByAllUnion';
        $res['data']['data_list'] = $company_data_list;
        $res['data']['page'] = intval($page);
        $res['data']['page_size'] = intval($page_size);
        $res['data']['total_page'] = intval($total_page);
        $res['data']['total_num'] = intval($total_num);
        $res = json_encode($res);
        return $res;
    }

    public function getArr($arr)
    {
        foreach ($arr as $k => $v) {
            if (empty($v)) {
                unset($arr[$k]);
            }
        }
        return $arr;
    }
}
?>