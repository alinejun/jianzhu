<?php
namespace app\api\controller;

use think\Controller;
// use app\api\model\ProjectCondition as ProjectConditionModel;

/**
 * 项目-相关controller
 */
class Project extends Controller
{
	/*
	*由于项目相关的筛选项都是在数据量极大的表里面,所以在此不单独列筛选项的controller，且把相应的筛选项直接写死在程序里面
	*/
	public function projectCondition(){
		$data_list = [];
		#筛选项-项目分类
		$data_list['project_type'][] = '房屋建筑工程';
		$data_list['project_type'][] = '市政工程';
		$data_list['project_type'][] = '其他';
		#筛选项-建设性质
		$data_list['project_nature'][] = '新建';
		$data_list['project_nature'][] = '改建';
		$data_list['project_nature'][] = '其他';
		$data_list['project_nature'][] = '迁建';
		$data_list['project_nature'][] = '扩建';
		$data_list['project_nature'][] = '恢复';
		#筛选项-工程用途
		$data_list['project_use'][] = '道路';
		$data_list['project_use'][] = '其他';
		$data_list['project_use'][] = '工业建筑';
		$data_list['project_use'][] = '居住建筑';
		$data_list['project_use'][] = '商住楼';
		$data_list['project_use'][] = '公共建筑';
		$data_list['project_use'][] = '科教文卫建筑';
		$data_list['project_use'][] = '桥隧';
		$data_list['project_use'][] = '交通运输类';
		$data_list['project_use'][] = '办公建筑';
		$data_list['project_use'][] = '公共交通';
		$data_list['project_use'][] = '农业建筑';
		$data_list['project_use'][] = '商业建筑';
		$data_list['project_use'][] = '排水';
		$data_list['project_use'][] = '风景园林';
		$data_list['project_use'][] = '给水';
		$data_list['project_use'][] = '居住建筑配套工程';
		$data_list['project_use'][] = '工业建筑配套工程';
		$data_list['project_use'][] = '公共建筑配套工程';
		$data_list['project_use'][] = '燃气';
		$data_list['project_use'][] = '旅游建筑';
		$data_list['project_use'][] = '热力';
		$data_list['project_use'][] = '环境园林';
		$data_list['project_use'][] = '农业建筑配套工程';
		$data_list['project_use'][] = '通信建筑';
		#筛选项-招标类型
		$data_list['bid_way'][]= '公开招标';
		$data_list['bid_way'][]= '邀请招标';
		$data_list['bid_way'][]= '直接委托';
		$data_list['bid_way'][]= '其他';
		#筛选项-合同类别
		$data_list['contract_type'][]= '施工总包';
		$data_list['contract_type'][]= '监理';
		$data_list['contract_type'][]= '设计';
		$data_list['contract_type'][]= '勘察';
		$data_list['contract_type'][]= '施工分包';
		$data_list['contract_type'][]= '工程总承包';
		$data_list['contract_type'][]= '专业承包';
		$data_list['contract_type'][]= '施工劳务';
		$data_list['contract_type'][]= '项目管理';
		$data_list['contract_type'][]= '设计施工一体化';
		$res['code'] = 1;
		$res['msg'] = 'success';
		$res['data'] = $data_list;
		$res = json_encode($res);
		return $res;
	}
}
?>