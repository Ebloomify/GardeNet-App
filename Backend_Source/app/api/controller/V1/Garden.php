<?php 
/*
 module:		花园
 create_time:	2021-12-23 23:46:57
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\Remind;
use app\api\service\RedisService;
use app\api\service\V1\GardenService;
use app\api\model\V1\Garden as GardenModel;
use app\api\controller\Common;
use app\applets\service\GeTui;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Garden extends Common {


	/**
	* @api {get} /V1.Garden/view 08、查看详情
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  查看详情
	
	* @apiParam (输入参数：) {string}     		id 主键ID

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
	* {"status":"412","msg":"没有数据"}
	*/
	function view(){
		$Field['id'] = $this->request->get('id','','serach_in');
		$field='id,common_name,id,member_id,plant_name,plant_introduction,duration,flower_color,fertilization,water,exposure,soil,minimum_tempature,blooming,create_time,update_time,img';
		$res  = checkData(GardenModel::field($field)->where($Field)->find());
        $res['img'] = json_decode(json(html_out($res['img']))->getData(), true);
        $imgs = [];
        foreach($res['img'] as $v){
            $imgs[]=$v['url'];
        }
        $res['img'] = implode(',',$imgs);
        $data['body']=$res;
        //查询花园图标
        $data['icons'] = db('garden_icon')->select()->toArray();
		return $this->ajaxReturn($this->successCode,'返回成功',$data);
	}

 /*start*/
	/**
	* @api {get} /V1.Garden/list 01、列表
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  列表

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
	function list(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = ['member_id'=>$this->request->uid];

		$field = 'id,plant_name,plant_introduction,img';
		$orderby = 'id desc';

		$res = GardenService::listList(formatWhere($where),$field,$orderby,$limit,$page);
		foreach($res['list'] as $k=>$v){
            $v['img'] = json_decode(json(html_out($v['img']))->getData(), true);
            $imgs = [];
            foreach($v['img'] as $vv){
                $imgs[]=$vv['url'];
            }
            $res['list'][$k]['img'] = implode(',',$imgs);
        }


		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
    /*end*/

 /*start*/
	/**
	* @api {post} /V1.Garden/add 02、添加
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  创建数据

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			common_name common_name 
	* @apiParam (输入参数：) {string}			member_id member_id (必填) 
	* @apiParam (输入参数：) {string}			plant_name plant_name (必填) 
	* @apiParam (输入参数：) {string}			plant_introduction plant_introduction 
	* @apiParam (输入参数：) {string}			duration duration 
	* @apiParam (输入参数：) {string}			flower_color flower_color 
	* @apiParam (输入参数：) {string}			fertilization fertilization 
	* @apiParam (输入参数：) {string}			water water 
	* @apiParam (输入参数：) {string}			exposure exposure 
	* @apiParam (输入参数：) {string}			soil soil 
	* @apiParam (输入参数：) {string}			minimum_tempature minimum_tempature 
	* @apiParam (输入参数：) {string}			blooming blooming 
	* @apiParam (输入参数：) {string}			update_time update_time 
	* @apiParam (输入参数：) {string}			img img (必填) 

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
		$postField = 'common_name,member_id,plant_name,plant_introduction,duration,flower_color,fertilization,water,exposure,soil,minimum_tempature,blooming,img';
		$data = $this->request->only(explode(',',$postField),'post',null);
		$res = GardenService::add($data);
		return $this->ajaxReturn($this->successCode,'操作成功',$res);
	}
    /*end*/

 /*start*/
	/**
	* @api {get} /V1.Garden/edit 03、编辑
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  编辑
	
	* @apiParam (输入参数：) {string}     		id 主键ID

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
	function edit(){
		$data['id'] = $this->request->get('id','','serach_in');
		$field='id,common_name,id,member_id,plant_name,plant_introduction,duration,flower_color,fertilization,water,exposure,soil,minimum_tempature,blooming,create_time,update_time,img';
		$res  = checkData(GardenModel::field($field)->where($data)->find());
		return $this->ajaxReturn($this->successCode,'返回成功',$res);
	}
    /*end*/

 /*start*/
	/**
	* @api {post} /V1.Garden/update 04、修改
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  编辑数据
	
	* @apiParam (输入参数：) {string}     		id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			common_name common_name 
	* @apiParam (输入参数：) {string}			id id 
	* @apiParam (输入参数：) {string}			member_id member_id (必填) 
	* @apiParam (输入参数：) {string}			plant_name plant_name (必填) 
	* @apiParam (输入参数：) {string}			plant_introduction plant_introduction 
	* @apiParam (输入参数：) {string}			duration duration 
	* @apiParam (输入参数：) {string}			flower_color flower_color 
	* @apiParam (输入参数：) {string}			fertilization fertilization 
	* @apiParam (输入参数：) {string}			water water 
	* @apiParam (输入参数：) {string}			exposure exposure 
	* @apiParam (输入参数：) {string}			soil soil 
	* @apiParam (输入参数：) {string}			minimum_tempature minimum_tempature 
	* @apiParam (输入参数：) {string}			blooming blooming 
	* @apiParam (输入参数：) {string}			create_time create_time 
	* @apiParam (输入参数：) {string}			update_time update_time 
	* @apiParam (输入参数：) {string}			img img (必填) 

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
		$postField = 'id,common_name,id,member_id,plant_name,plant_introduction,duration,flower_color,fertilization,water,exposure,soil,minimum_tempature,blooming,img';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['id'])){
			throw new ValidateException('参数错误');
		}
		$where['id'] = $data['id'];
		$res = GardenService::update($where,$data);
		return $this->ajaxReturn($this->successCode,'操作成功');
	}
    /*end*/

 /*start*/
	/**
	* @api {delete} /V1.Garden/delete 05、删除
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  删除数据

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}     		ids 主键id 注意后面跟了s 多数据删除

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
		$idx =  $this->request->post('ids', '', 'serach_in');
		if(empty($idx)){
			throw new ValidateException('参数错误');
		}
		$data['id'] = explode(',',$idx);
		try{
			GardenModel::destroy($data,true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $this->ajaxReturn($this->successCode,'操作成功');
	}
    /*end*/

    /*start*/
    /**
     * @api {getName} /V1.Garden/getName 06、查询名称
     * @apiGroup Garden
     * @apiVersion 1.0.0
     * @apiDescription  查询名称

     * @apiHeader {String} Authorization 用户授权token

     * @apiParam (输入参数：) {string}     		name 查询的名称
     * @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}     		[page] 当前页码


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
    function getName(){
        $name =  $this->request->get('name', '', 'serach_in');
        $limit  = $this->request->get('limit', 20, 'intval');
        $page   = $this->request->get('page', 1, 'intval');
        if(empty($name)){
            throw new ValidateException('参数错误');
        }

        try{
           $name = db('plantinfo')->where('CommonName','like','%'.$name.'%')
              
               ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
            return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList(['list'=>$name['data'],'count'=>$name['total']]));
        }catch(\Exception $e){
            return $this->ajaxReturn($this->errorCode,'系统错误');
        }

    }
    /*end*/

 /*start*/
	/**
	* @api {post} /V1.Garden/setRemind 07、设置提醒
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  编辑数据
	
	* @apiParam (输入参数：) {string}     		id 图标ID (必填)
	* @apiParam (输入参数：) {string}     		garden_id 图标ID (必填)
	* @apiParam (输入参数：) {string}     		day 提醒天数 (必填 0 单次)
	* @apiParam (输入参数：) {string}     		start_time 开始时间 (必填 )
	* @apiParam (输入参数：) {string}     		end_time 结束时间 (单次可不填 )
	* @apiParam (输入参数：) {string}     		[client_id] 客户端ID (选填，不填时取登录的id，登录id没有不推送)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

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
	function setRemind(){
		$postField = 'id,day,start_time,end_time,client_id,garden_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['id'])||empty('start_time')||empty('end_time')){
			throw new ValidateException('参数错误');
		}

		$data['member_id'] = $this->request->uid;
		//判断设置参数是否有效
        if(strtotime($data['start_time'])<=time()){
            return $this->ajaxReturn($this->errorCode,'时间设置错误');
        }
        if($data['day']>=1&&!$data['end_time']){
            return $this->ajaxReturn($this->errorCode,'时间设置错误');
        }

		$res = GardenService::setRemind($data);
		return $this->ajaxReturn($this->successCode,'操作成功',$res);
	}
    /*end*/

 /*start*/
	/**
	* @api {get} /V1.Garden/show_Remind 08、查看提醒
	* @apiGroup Garden
	* @apiVersion 1.0.0
	* @apiDescription  查看提醒
	
	* @apiParam (输入参数：) {string}     		type 查询类型 0已设置 1已提醒
	* @apiParam (输入参数：) {string}     		garden_id 植物ID
     * @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}     		[page] 当前页码


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
	function show_Remind(){
		$data['type'] = $this->request->get('type','','serach_in');
		$data['garden_id'] = $this->request->get('garden_id','','serach_in');
        $limit  = $this->request->get('limit', 20, 'intval');
        $page   = $this->request->get('page', 1, 'intval');
        $start_time = $this->request->get('start_time','','serach_in');
        $end_time = $this->request->get('end_time','','serach_in');

        $res = Remind::where('member_id',$this->request->uid)->where('garden_id',$data['garden_id']);
		if($data['type']==1){
		    $res = $res->where('remind_num','>=',1);
        }

        if($start_time){
            $res = $res->where('start_time','>=',$start_time);
        }
        
        if($end_time){
            $res = $res->where('start_time','<=',$end_time);
        }

        $res = $res->order('id','desc')->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		return $this->ajaxReturn($this->successCode,'返回成功',['list'=>$res['data'],'count'=>$res['total']]);
	}
    /*end*/


    /*start*/
    /**
     * @api {get} /V1.Garden/send 09、发送推送
     * @apiGroup Garden
     * @apiVersion 1.0.0
     * @apiDescription  发送推送

     * @apiParam (输入参数：) {string}     		client_id 设备ID

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
    function send(){
        $data_['client_id'] = $this->request->get('client_id','','serach_in');

        $title = 'rrrrr';
        $body =  'qweqweqweqwe';
        $urlStr = '/pages/center/garden/info?id=8';
        $cid = $data_['client_id'];  //anidor
//        $cid = "5aed5e2cd328b699bf71a4eac1c504f0";  //ios

        \utils\uniapp\GeTui::getObject();
        $data = [
            'urlStr'=>$urlStr,
            'title'=>$title,
            'body'=>$body,
            'intent_arr'=> ['title'=>$title,'body'=>$body],  //普通消息和透传需要
        ];
        \utils\uniapp\GeTui::setMessageData($data);
        \utils\uniapp\GeTui::pushOneMessage($cid);

    }
    /*end*/


    /*start*/
    /**
     * @api {get} /V1.Garden/deleteRemind 10、删除花园提醒
     * @apiGroup Garden
     * @apiVersion 1.0.0
     * @apiDescription  删除花园提醒

     * @apiParam (输入参数：) {string}     		id 提醒ID
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
   public function deleteRemind(){
        $data['id'] = $this->request->get('id','','serach_in');
        if(!$remind = Remind::where('member_id',$this->request->uid)->where('id',$data['id'])->find()){
            return $this->ajaxReturn($this->errorCode,'提醒不存在');
        }
        Remind::where('id',$data['id'])->delete();
        return $this->ajaxReturn($this->successCode,'删除成功');
    }
    /*end*/

}

