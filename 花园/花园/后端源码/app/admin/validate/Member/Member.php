<?php 
/*
 module:		会员列表验证器
 create_time:	2022-03-08 22:38:11
 author:		
 contact:		
*/

namespace app\admin\validate\Member;
use think\validate;

class Member extends validate {


	protected $rule = [
		'avatar'=>['require'],
		'nickname'=>['require'],
		'email'=>['unique:member','regex'=>'/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/'],
		'sex'=>['require'],
		'mobile'=>['regex'=>'/^1[3456789]\d{9}$/'],
		'create_time'=>['require'],
		'password'=>['require'],
		'invitation_code'=>['unique:member'],
        'integral'=>'require|number'
	];

	protected $message = [
		'avatar.require'=>'头像不能为空',
		'nickname.require'=>'用户昵称不能为空',
		'email.unique'=>'邮箱已经存在',
		'email.regex'=>'邮箱格式错误',
		'sex.require'=>'性别不能为空',
		'mobile.regex'=>'手机号格式错误',
		'create_time.require'=>'创建时间不能为空',
		'password.require'=>'密码不能为空',
		'invitation_code.unique'=>'邀请码已经存在',
        'integral.require'=>'请输入积分',
        'integral.number'=>'请输入数字'
	];

	protected $scene  = [
		'add'=>['avatar','nickname','email','sex','mobile','create_time','password','invitation_code'],
		'update'=>['avatar','nickname','email','sex','mobile','create_time','invitation_code'],
		'uppass'=>['password'],
        'integral'=>['integral'],
	];



}

