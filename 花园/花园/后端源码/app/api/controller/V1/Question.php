<?php 
/*
 module:		QA问题
 create_time:	2021-08-05 10:14:53
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\QuestionService;
use app\api\model\V1\Question as QuestionModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Question extends Common {


	/**
	* @api {post} /V1.Question/update 03、修改
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  修改
	
	* @apiParam (输入参数：) {string}     		question_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				member_id member_id 
	* @apiParam (输入参数：) {string}			title 标题 (必填) 
	* @apiParam (输入参数：) {string}			content 问题内容 (必填) 
	* @apiParam (输入参数：) {string}			pic  
	* @apiParam (输入参数：) {int}				integer_sum 积分设置 
	* @apiParam (输入参数：) {string}			create_time 创建时间 
	* @apiParam (输入参数：) {int}				like_sum 点赞数量 
	* @apiParam (输入参数：) {int}				answer_sum 回答数量 
	* @apiParam (输入参数：) {int}				see_sum 浏览量 
	* @apiParam (输入参数：) {int}				question_cate_id 所属分类 (必填) 
	* @apiParam (输入参数：) {int}				auth_status 审核状态 通过|1|success,未通过|0|danger,未审核|2|warning
	* @apiParam (输入参数：) {int}				status 状态 开启|1,关闭|0
	* @apiParam (输入参数：) {string}			auth_msg 审核消息 
	* @apiParam (输入参数：) {string}			cate_name 分类名称 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function update(){
		$postField = 'question_id,member_id,title,content,integer_sum,create_time,like_sum,answer_sum,see_sum,question_cate_id,auth_status,status,auth_msg,cate_name,pics';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['question_id'])){
			throw new ValidateException('参数错误');
		}
		$where['question_id'] = $data['question_id'];
        $data['update_date'] = date('Y-m-d H:i:s');
		$res = QuestionService::update($where,$data);
		return $this->ajaxReturn($this->successCode,'操作成功',['id'=>$data['question_id']]);
	}

	/**
	* @api {post} /V1.Question/delete 04、删除
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  删除

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}     		question_ids 主键id 注意后面跟了s 多数据删除

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"操作失败"}
	*/
	function delete(){
		$idx =  $this->request->post('question_ids', '', 'serach_in');
		if(empty($idx)){
			throw new ValidateException('参数错误');
		}
		$data['question_id'] = explode(',',$idx);
		try{
			QuestionModel::destroy($data,true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $this->ajaxReturn($this->successCode,'操作成功');
	}

	/**
	* @api {get} /V1.Question/view 05、QA问题详情
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  查看详情
	
	* @apiParam (输入参数：) {string}     		question_id 主键ID

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据详情
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"没有数据"}
	*/
	function view(){
		$data['question_id'] = $this->request->get('question_id','','serach_in');
		$field='question_id,question_id,member_id,title,question_cate_id,cate_name,content,pics,integer_sum,like_sum,answer_sum,see_sum,create_time,resolved_status';
		$res  = checkData(QuestionModel::field($field)->where($data)->find());

        \app\api\model\V1\Question::where($data)->update(['see_sum'=>$res['see_sum']  + 1]);
        //用户相关信息
        $member = \app\api\model\V1\Member::find($res['member_id']);

        $res['pics'] = json_decode(json(html_out($res['pics']))->getData(),true);
        $res['avatar'] = $member['avatar'];
        $res['nickname'] = $member['nickname'];
        $res['member_level'] = $member['member_level'];


        //是否关注 收藏 点赞
        if ($this->request->uid){
            $follow  = \app\api\model\V1\MemberFollow::where([
                'member_id' => $res['member_id'],
                'follow_member_id' => $this->request->uid,
            ])->find();
            $like = \app\api\model\V1\MemberLike::where([
                'member_id' => $this->request->uid,
                'type'      =>  3,
                'object_id' => $data['question_id'],
            ])->find();
            $collect = \app\api\model\V1\MemberCollect::where([
                'type' => 3,
                'member_id' => $this->request->uid,
                'object_id' => $data['question_id'],
            ])->find();

            $follow ? $res['is_follow'] = true : $res['is_follow'] = false;
            $like ? $res['is_like'] = true : $res['is_like'] = false;
            $collect ? $res['is_collect'] = true : $res['is_collect'] = false;
        }else{
            $res['is_follow'] = false;
            $res['is_like'] = false;
            $res['is_collect'] = false;
        }
        $res['id'] = $res['question_id'];
        $res['cate_id'] = $res['question_cate_id'];
        $res['comment_status'] = db('config')->where('name','qa_comment_status')->value('data');
        $res['cate_name'] = db('question_cate')->where('question_cate_id',$res['cate_id'])->value('cate_name');
        return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}

	/*start*/
	/**
	* @api {get} /V1.Question/myList 06、QA问题_我的问题
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  我的_QA问题列表

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function myList(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = [
		    'member_id' => $this->request->uid,
            'status' => 1,
//            'auth_status' => 1,
        ];

		$field = '*';
		$orderby = 'question_id desc';

		$res = QuestionService::myListList(formatWhere($where),$field,$orderby,$limit,$page);


        $list = $res['list'];
        foreach ($list as $k => $v){
            $list[$k]['id'] = $v['question_id'];
            $list[$k]['cate_id'] = $v['question_cate_id'];
            $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(),true);
            $list[$k]['create_time'] = date('d/m/Y H:i:s',$v['create_time']);
        }
        $res['list'] = $list;


		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
    /*end*/

    /*start*/
	/**
	* @api {post} /V1.Question/add 02、发布QA问题
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {string}			title 标题 (必填) 
	* @apiParam (输入参数：) {int}				question_cate_id 所属分类 (必填) 
	* @apiParam (输入参数：) {string}			content 问题内容 (必填) 
	* @apiParam (输入参数：) {string}			pics 图片 
	* @apiParam (输入参数：) {int}				integer_sum 积分设置

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function add(){
		$postField = 'title,question_cate_id,content,pics,integer_sum';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$data['member_id'] = $this->request->uid;
		$res = QuestionService::add($data);
		return $this->ajaxReturn($this->successCode,'操作成功',['id'=>$res]);
	}
    /*end*/

    /*start*/
	/**
	* @api {get} /V1.Question/index 01、QA问题列表
	* @apiGroup Question
	* @apiVersion 1.0.0
	* @apiDescription  QA问题列表

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
     * @apiParam (输入参数：) {int}			[question_cate_id] 所属分类
     * @apiParam (输入参数：) {int}			[sort] 0|默认,1|最新,2|高分,3|已解决
     * @apiParam (输入参数：) {string}		[content] 搜索内容
     * @apiParam (输入参数：) {string}		[is_re] 1 显示推荐分类 0显示普通 传1时 question_cate_id无效

     * @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function index(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');
        $search = $this->request->get('content','');
        $sort = $this->request->get('sort','0');
        $is_re =  $this->request->get('is_re', '');

        $where = [
            'c.status' => 1,
            'c.auth_status' => 1,
        ];
        if($is_re){
            $where['is_re'] = 1;
        }else {
            $where['c.question_cate_id'] = $this->request->get('question_cate_id', '', 'serach_in');
        }
        $search && $where['c.title'] = ['like',"%".$search."%"];

        if ($this->request->uid){
            $memberId = $this->request->uid;
        }else{
            $memberId = 0;
        }

        if ($sort == 0 || $sort == 1){
            //最新
            $orderby = 'c.create_time desc';
        }elseif ($sort == 2){
            //高分
            $orderby = 'c.integer_sum desc';
        }else{
            $where['c.resolved_status'] = 2;
            //已解决
            $orderby = 'c.create_time desc';
        }


        $field = 'c.member_id,c.resolved_status,c.question_id,c.title,c.question_cate_id,c.cate_name,c.content,c.pics,c.integer_sum,c.like_sum,c.answer_sum,c.see_sum,c.create_time';

        $data = QuestionModel::alias('c')->join('member m','c.member_id = m.member_id')
            ->leftJoin('member_like l','l.type = 3 and l.object_id = c.question_id and l.member_id = '.$memberId)
            ->leftJoin('member_follow f','f.member_id = '.$memberId.' and f.follow_member_id = c.member_id')
            ->field($field)
            ->field('m.avatar,m.nickname,m.member_level')
            ->field('l.member_like_id is_like')
            ->field('f.member_follow_id is_follow')
            ->where(formatWhere($where))
            ->order($orderby)
            ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();


        $return = [];

        $list = $data['data'];
        foreach ($list as $k => $v){
            $list[$k]['id'] = $v['question_id'];
            $list[$k]['content'] = html_out($v['content']);
            $list[$k]['cate_id'] = $v['question_cate_id'];
            $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(),true);
            $list[$k]['is_like'] ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false ;
            $list[$k]['is_follow'] ? $list[$k]['is_follow'] = true : $list[$k]['is_follow'] = false ;
//            $list[$k]['create_time'] = date('d/m/Y H:i:s',$v['create_time']);
        }
        $return['list'] = $list;
        $return['count'] = $data['total'];

        return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($return));

	}
    /*end*/



}

