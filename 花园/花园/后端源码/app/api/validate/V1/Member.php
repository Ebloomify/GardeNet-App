<?php 
/*
 module:		会员列表验证器
 create_time:	2021-12-19 19:57:51
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class Member extends validate {


	protected $rule = [
		'avatar'=>['require'],
		'nickname'=>['require'],
		'email'=>['unique:member','regex'=>'/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/'],
		'sex'=>['require'],
		'mobile'=>['unique:member','regex'=>'/^1[3456789]\d{9}$/'],
		'create_time'=>['require'],
		'password'=>['require'],
	];

	protected $message = [
		'avatar.require'=>'头像不能为空',
		'nickname.require'=>'用户昵称不能为空',
		'email.unique'=>'邮箱已经存在',
		'email.regex'=>'邮箱格式错误',
		'sex.require'=>'性别不能为空',
		'mobile.unique'=>'手机号已经存在',
		'mobile.regex'=>'手机号格式错误',
		'create_time.require'=>'创建时间不能为空',
		'password.require'=>'密码不能为空',
	];

	protected $scene  = [
		'register'=>['email','password'],
		'update'=>['avatar','nickname','sex','mobile'],
		'resetPassword'=>['email','password'],
	];



}

