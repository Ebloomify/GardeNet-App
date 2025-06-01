<?php 
/*
 module:		会员列表
 create_time:	2022-03-08 22:38:11
 author:		
 contact:		
*/

namespace app\admin\service\Member;
use app\admin\model\Member\Member;
use app\api\model\ConfigMemberInteger;
use app\api\model\V1\MemberIntegral;
use app\api\service\V1\IntegerService;
use think\exception\ValidateException;
use xhadmin\CommonService;

class MemberService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = Member::where($where)->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


	/*
 	* @Description  添加
 	*/
	public static function add($data){
		try{
			validate(\app\admin\validate\Member\Member::class)->scene('add')->check($data);
			$data['password'] = md5($data['password'].config('my.password_secrect'));
			$data['create_time'] = strtotime($data['create_time']);
			$data['integral'] = 0;
			$data['all_integral'] = 0;
			$res = Member::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		if(!$res){
			throw new ValidateException ('操作失败');
		}
		return $res->member_id;
	}


	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			validate(\app\admin\validate\Member\Member::class)->scene('update')->check($data);
			$data['create_time'] = strtotime($data['create_time']);
			$res = Member::update($data);
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


	/*
 	* @Description  修改密码
 	*/
	public static function uppass($data){
		try{
			validate(\app\admin\validate\Member\Member::class)->scene('uppass')->check($data);
			$data['password'] = md5($data['password'].config('my.password_secrect'));
			$res = Member::update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  数值加
 	*/
	public static function Add_integral($where,$data){
	    db()->startTrans();
		try{
            validate(\app\admin\validate\Member\Member::class)->scene('integral')->check($data);


            \app\api\model\V1\Member::where('member_id', $data['member_id'])
                ->inc('all_integral', $data['integral'])->inc('integral', $data['integral'])->update();
            $member_level_exp = db('member')->where('member_id',$data['member_id'])->value('member_level_exp');
            $max_integer = db('config_member_integer')->max('max');
            if($member_level_exp+$data['integral']>$max_integer){
                Member::where('member_id',$data['member_id'])->update(['member_level_exp'=>$max_integer]);
            }else{
                Member::where('member_id',$data['member_id'])->inc('member_level_exp', $data['integral'])->update();
            }

            //计算经验值，满足升级要求升级并减少相应经验

            $member = Member::where('member_id', $data['member_id'])->field('member_level,member_level_exp')->find();


            $config_member_integer = ConfigMemberInteger::where('min','<=',$member['member_level_exp'])
                ->order('min','desc')->limit(1)->value('level');

            $member->member_level=$config_member_integer;
            $member->save();
            db()->commit();
		}catch(ValidateException $e){
		    db()->rollback();
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
		    db()->rollback();
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return true;
	}


	/*
 	* @Description  数值减
 	*/
	public static function Reduction_integral($where,$data){
	    db()->startTrans();
		try{
            validate(\app\admin\validate\Member\Member::class)->scene('integral')->check($data);
            $up = \app\api\model\V1\Member::where('member_id', $data['member_id'])
                ->where('integral','>=',$data['integral'])->where('all_integral','>=',$data['integral'])
                ->dec('all_integral', $data['integral'])->dec('integral', $data['integral'])->update();
            if($up){
                $member_level_exp = db('member')->where('member_id',$data['member_id'])->value('member_level_exp');
                $max_integer = db('config_member_integer')->min('min');
                if($member_level_exp-$data['integral']<$max_integer){
                    Member::where('member_id',$data['member_id'])->update(['member_level_exp'=>$max_integer]);
                }else{
                    if(Member::where('member_id',$data['member_id'])->value('member_level_exp')>=$data['integral']){
                        Member::where('member_id',$data['member_id'])->dec('member_level_exp', $data['integral'])->update();
                    }else{
                        Member::where('member_id',$data['member_id'])->update(['member_level_exp'=>0]);
                    }
                }

                $member = Member::where('member_id', $data['member_id'])->field('member_level,member_level_exp')->find();


                $config_member_integer = ConfigMemberInteger::where('min','<=',$member['member_level_exp'])
                    ->order('max','desc')->limit(1)->value('level');

                $member->member_level=$config_member_integer;
                $member->save();
            }
            db()->commit();
		}catch(ValidateException $e){
		    db()->rollback();
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
		    db()->rollback();
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return true;
	}




}

