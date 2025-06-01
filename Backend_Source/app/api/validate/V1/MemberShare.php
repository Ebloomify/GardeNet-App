<?php 
/*
 module:		我的分享验证器
 create_time:	2021-11-16 17:26:57
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class MemberShare extends validate {


	protected $rule = [
		'member_id'=>['require'],
		'member_invited_id'=>['require'],
	];

	protected $message = [
		'member_id.require'=>'用户id不能为空',
		'member_invited_id.require'=>'被邀请人id不能为空',
	];

	protected $scene  = [
	];



}

