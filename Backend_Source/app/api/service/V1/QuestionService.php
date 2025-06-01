<?php 
/*
 module:		QA问题
 create_time:	2021-08-05 10:14:53
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\Question;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class QuestionService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$orderby,$limit,$page){
		try{
			$res = Question::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}


	/*
 	* @Description  修改
 	*/
	public static function update($where,$data){
		try{
			validate(\app\api\validate\V1\Question::class)->scene('update')->check($data);
			!is_null($data['create_time']) && $data['create_time'] = strtotime($data['create_time']);
			$res = Question::where($where)->update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  列表数据
 	*/
	public static function myListList($where,$field,$orderby,$limit,$page){
		try{
			$res = Question::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}


	/*start*/
	/*
 	* @Description  添加
 	*/
	public static function add($data){
	    \db()->startTrans();
		try{
			validate(\app\api\validate\V1\Question::class)->scene('add')->check($data);

			//判断用户积分是否超过
            $member = \app\api\model\V1\Member::find($data['member_id']);

            if ($member['integral'] < $data['integer_sum']){
                throw new ValidateException('积分不足['.$data['integer_sum'].']');
            }
            //填充默认数据

            $cate = \app\api\model\V1\QuestionCate::find($data['question_cate_id']);

            $authStatus = \db('config')->where(['name' => 'qa_auth_status'])->value('data');

            if (!$cate) throw new ValidateException('分类不存在');
            if ($cate['is_under'] == 1)  throw new ValidateException('该分类无法选择');
            $question = [
                'title' => $data['title'],
                'question_cate_id' => $data['question_cate_id'],
                'content' => $data['content'],
                'pics' => $data['pics'],
                'integer_sum' => $data['integer_sum'],
                'member_id' => $data['member_id'],
                'cate_name' => $cate['cate_name'],
                'like_sum' => 0,
                'answer_sum' => 0,
                'see_sum' => 0,
                'auth_status' => $authStatus == 1 ? 2 : 1,
                'auth_msg' => '',
                'status' => 1,
                'create_time' => time(),
                'resolved_status' => 1,
            ];
            $res = Question::create($question);

            //扣除积分
            \app\api\model\V1\Member::where(['member_id'=>$question['member_id']])->update([
                'integral' => $member['integral'] - $data['integer_sum'],
            ]);
            //记录积分变动记录
            \app\api\model\V1\MemberIntegral::insert([
                'member_id' => $question['member_id'],
                'type' =>  0,
                'inte_desc' => 'question points',
                'integral' => $data['integer_sum'],
                'create_time' => time(),
            ]);
            \db('integer_log')->insert([
                'member_id'=>$question['member_id'],'integer'=>$data['integer_sum'],'type'=>1,'create_time'=>time()
            ]);
            \db()->commit();
		}catch(ValidateException $e){
		    \db()->rollback();
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
            \db()->rollback();
            abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res->question_id;
	}
    /*end*/



}

