<?php 
/*
 module:		反馈列表
 create_time:	2021-11-13 23:22:44
 author:		
 contact:		
*/

namespace app\admin\controller\Feedback;

use app\admin\model\Integer\ConfigInteger;
use app\admin\model\Member\Member;
use app\admin\service\Feedback\IndexService;
use app\admin\model\Feedback\Index as IndexModel;
use app\admin\controller\Admin;
use app\api\service\V1\IntegerService;
use think\facade\Db;

class Index extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['member_id'] = $this->request->param('member_id', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'feedback_id,member_id,points,body';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'feedback_id desc';

			$res = IndexService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('feedback_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			IndexModel::destroy(['feedback_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看详情*/
	function view(){
		$feedback_id = $this->request->get('feedback_id','','serach_in');
		if(!$feedback_id) $this->error('参数错误');
		$this->view->assign('info',IndexModel::find($feedback_id));
		return view('view');
	}

    /*加积分*/
    function points()
    {
        $idx = $this->request->post('feedback_id', '', 'serach_in');
        if (!$idx) $this->error('参数错误');
        \db()->startTrans();
        try {
            if (!$feedback = IndexModel::where(['feedback_id' => explode(',', $idx)])->find())
                $this->error('反馈信息不存在');

            IndexModel::where(['feedback_id' => explode(',', $idx)])->update(['points' => 1]);
            //查询用户是否存在
            if (!$user = Member::where('member_id', $feedback['member_id'])->find())
                $this->error('反馈用户不存在');
            //给用户添加积分
            if (!$config_integer = ConfigInteger::where('config_integer_id', 9)->find())
                $this->error('反馈积分不存在');
//            Member::where('member_id', $feedback['member_id'])->inc('all_integral', $config_integer['add_integer'])
//                ->inc('integral', $config_integer['add_integer'])->update();
            IntegerService::plus(9,$feedback['member_id']);
            \db()->commit();
        } catch (\Exception $e) {
            \db()->rollback();
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return json(['status' => '00', 'msg' => '操作成功']);
    }



}

