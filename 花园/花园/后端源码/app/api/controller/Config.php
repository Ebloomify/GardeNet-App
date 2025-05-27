<?php 
/*
 module:		基础信息
 create_time:	2021-11-16 00:49:37
 author:		
 contact:		
*/

namespace app\api\controller;

use app\api\service\ConfigService;
use app\api\model\Config as ConfigModel;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Config extends Common {


	/**
	* @api {get} /Config/list 01、list
	* @apiGroup Config
	* @apiVersion 1.0.0
	* @apiDescription  list

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


        $names =['ag_title','ag_body','about_body','share_body','is_discover','is_community','is_qa'];
		$res = $res = \app\api\model\Config::where('name','in',$names)
            ->select()->toArray();
        $data = [];
		foreach($res as $v){
            if($v['name']=='ag_title'){
                $data['ag']['ag_title']=htmlspecialchars_decode($v['data']);
            }
            if($v['name']=='ag_body'){
                $data['ag']['ag_body']=htmlspecialchars_decode($v['data']);
            }
            if($v['name']=='about_body'){
                $data['about'] = htmlspecialchars_decode($v['data']);
            }
            if($v['name']=='share_body'){
                $data['share_body'] = htmlspecialchars_decode($v['data']);
            }
            if($v['name']=='is_discover'){
                $data['is_discover']=$v['data'];
            }
            if($v['name']=='is_community'){
                $data['is_community']=$v['data'];
            }
            if($v['name']=='is_qa'){
                $data['is_qa']=$v['data'];
            }

        }

		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($data));
	}



}

