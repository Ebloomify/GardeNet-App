<?php 
/*
 module:		问题列表
 create_time:	2022-01-16 23:36:37
 author:		
 contact:		
*/

namespace app\admin\service\QA;
use app\admin\model\QA\Question;
use think\exception\ValidateException;
use xhadmin\CommonService;

class QuestionService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = Question::where($where)->alias('c')->field($field)->order($order)
                ->join('member m','m.member_id=c.member_id')
                ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


	/*start*/
	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
		    //同步分类名称
            $cateId = $data['question_cate_id'];

            $data['cate_name'] =  \app\admin\model\QA\QuestionCate::find($cateId);

            //判断积分设置合理情况
            $info = Question::find($data['question_id']);

            $memberInfo = \app\admin\model\Member::find($info['member_id']);

            if ($memberInfo['integral'] < $info['integer_sum']){
                throw new ValidateException('积分设置大于用户可用积分');
            }
			$res = Question::update($data);
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
    /*end*/



}

