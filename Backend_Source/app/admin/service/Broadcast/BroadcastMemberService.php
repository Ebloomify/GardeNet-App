<?php 
/*
 module:		广播用户历史记录
 create_time:	2021-12-19 20:18:55
 author:		
 contact:		
*/

namespace app\admin\service\Broadcast;
use app\admin\model\Broadcast\BroadcastMember;
use think\exception\ValidateException;
use xhadmin\CommonService;

class BroadcastMemberService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = db('broadcast_member')->field($field)->alias('a')
                ->join('member b','a.member_id=b.member_id','left')
                ->join('broadcast c','a.broadcast_id=c.broadcast_id')
                ->where($where)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}




}

