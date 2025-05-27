<?php 
/*
 module:		反馈列表验证器
 create_time:	2021-11-13 23:22:44
 author:		
 contact:		
*/

namespace app\admin\validate\Feedback;
use think\validate;

class Index extends validate {


	protected $rule = [
		'member_id'=>['require'],
		'points'=>['require','regex'=>'/^[0-1]*$/'],
		'body'=>['require'],
	];

	protected $message = [
		'member_id.require'=>'用户ID不能为空',
		'points.require'=>'是否加积分不能为空',
		'points.regex'=>'是否加积分格式错误',
		'body.require'=>'反馈内容不能为空',
	];

	protected $scene  = [
	];



}

