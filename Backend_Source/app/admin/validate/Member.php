<?php 
/*
 module:		会员管理验证器
 create_time:	2021-01-12 14:44:38
 author:		
 contact:		
*/

namespace app\admin\validate;
use think\validate;

class Member extends validate {


	protected $rule = [
		'username'=>['require','unique:member'],
		'sex'=>['require'],
		'mobile'=>['unique:member','regex'=>'/^1[3456789]\d{9}$/'],
		'email'=>['regex'=>'/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/'],
		'headimg'=>['require'],
		'province'=>['require'],'city'=>['require'],
		'create_time'=>['require'],
		'password'=>['require'],
	];

	protected $message = [
		'username.require'=>'用户名不能为空',
		'username.unique'=>'用户名已经存在',
		'sex.require'=>'性别不能为空',
		'mobile.unique'=>'手机号已经存在',
		'mobile.regex'=>'手机号格式错误',
		'email.regex'=>'邮箱格式错误',
		'headimg.require'=>'头像不能为空',
		'province.require'=>'所属省不能为空',
		'city.require'=>'所属市不能为空',
		'create_time.require'=>'创建时间不能为空',
		'password.require'=>'密码不能为空',
	];

	protected $scene  = [
		'add'=>['username','sex','mobile','email','headimg','province','city','district','create_time','password'],
		'update'=>['username','sex','mobile','email','headimg','province','city','district','create_time'],
		'uppass'=>['password'],
	];



}

