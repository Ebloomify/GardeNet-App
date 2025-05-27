<?php 
/*
 module:		意见反馈验证器
 create_time:	2021-11-16 01:09:36
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class Feedback extends validate {


	protected $rule = [
		'member_id'=>['require'],
		'body'=>['require'],
	];

	protected $message = [
		'member_id.require'=>'用户ID不能为空',
		'body.require'=>'反馈内容不能为空',
	];

	protected $scene  = [
		'save'=>['member_id','body'],
	];



}

