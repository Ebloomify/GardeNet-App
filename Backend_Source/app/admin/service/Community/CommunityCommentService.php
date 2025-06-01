<?php 
/*
 module:		评论管理
 create_time:	2022-01-16 23:30:19
 author:		
 contact:		
*/

namespace app\admin\service\Community;
use app\admin\model\Community\CommunityComment;
use think\exception\ValidateException;
use xhadmin\CommonService;

class CommunityCommentService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = CommunityComment::where($where)->alias('c')->field($field)->order($order)
                ->join('member m','m.member_id=c.member_id')
                ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}




}

