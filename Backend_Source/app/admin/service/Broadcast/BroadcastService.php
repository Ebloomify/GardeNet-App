<?php 
/*
 module:		公告管理
 create_time:	2021-08-03 09:25:29
 author:		
 contact:		
*/

namespace app\admin\service\Broadcast;
use app\admin\model\Broadcast\Broadcast;
use think\exception\ValidateException;
use think\facade\Db;
use xhadmin\CommonService;

class BroadcastService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
		    $Broadcast = new Broadcast();
		    foreach ($where as $whereKey => $whereVal)
            {
                if($whereVal[0] == 'to_member_id' && $whereVal[1] == '='){
                    $to_member_id = $whereVal[2];
                    unset($where[$whereKey]);
                    $Broadcast = $Broadcast->whereRaw(Db::raw("FIND_IN_SET('{$to_member_id}',to_member_id)"));
                }
            }
		    if(!empty($where)){
                $Broadcast = $Broadcast->where($where);
            }
			$res = $Broadcast->alias('b')->leftJoin('member m','b.to_member_id=m.member_id')
                ->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


	/*
 	* @Description  添加
 	*/
	public static function add($data){
		try{
			$data['create_time'] = time();
			$res = Broadcast::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		if(!$res){
			throw new ValidateException ('操作失败');
		}
		return $res->broadcast_id;
	}


	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			$data['create_time'] = strtotime($data['create_time']);
			$res = Broadcast::update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		if(!$res){
			throw new ValidateException ('操作失败');
		}
		return $res;
	}




}

