<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/2/23
 * Time: 13:42
 */
namespace app\api\apiRoute;
class ApiRoute {
    CONST
        //企业-人员-项目  单查、多查
        COMPANY_CONDITION                                   = 'company_condition',  //企业查询
        PEOPLE_CONDITION                                    = 'people_condition',   //人员查询
        PROJECT_CONDITION                                   = 'project_condition',  //项目查询
        COMPANY_PROJECT_CONDITION                           = 'company_condition,project_condition',  //企业项目联查
        COMPANY_PEOPLE_CONDITION                            = 'company_condition,people_condition', //企业人员联查
        PEOPLE_PROJECT_CONDITION                            = 'people_condition,project_condition', //人员项目联查
        COMPANY_PEOPLE_PROJECT_CONDITION                    = 'company_condition,people_condition,project_condition', //企业人员项目联查

        //根据专业类型获取专业接口
        GET_MAJOR                                           = 'get_major',

        //详情查询
        PEOPLE_CONDITION_DETAIL                             = 'people_condition_detail',    //人员详情
        PROJECT_CONDITION_DETAIL                            = 'project_condition_detail',    //企业详情查询
        COMPANY_PROJECT_CONDITION_DETAIL                    = 'company_condition_detail,project_condition_detail',  //企业项目联查详情

        //下载导出excel
        PROJECT_CONDITION_DOWN                              = 'project_condition_down'  //项目下载
    ;
}