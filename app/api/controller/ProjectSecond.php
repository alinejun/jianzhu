<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/4/20
 * Time: 18:11
 */

namespace app\api\controller;
use app\api\model\Company;
use app\Code;

class ProjectSecond extends ApiBase{


    /**
     * 搜索--关键字提示
     * @return mixed
     */
    public function getCompanyByKeywords()
    {
        $keywords = input('get.keywords');
        $pageSize = input('get.page')?:10;
        $company_list = Company::getNameByKeywords($keywords,"company_url,company_name",$pageSize);
        $refer['code'] = Code::SUCCESS;
        $refer['msg'] =  Code::$MSG[$refer['code']];
        $refer['data'] = $company_list;
        return $this->apiReturn($refer);
    }

}