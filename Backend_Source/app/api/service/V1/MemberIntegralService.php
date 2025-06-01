<?php 
/*
 module:		会员积分记录
 create_time:	2021-11-16 04:26:51
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\MemberIntegral;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class MemberIntegralService extends CommonService {


 /*start*/
    public static function indexList($where, $field, $orderby, $limit, $page)
    {
        try {
            $res = MemberIntegral::where($where)->field($field)->order($orderby)->paginate(['list_rows' => $limit, 'page' => $page])->toArray();
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return ['list' => $res['data'], 'count' => $res['total']];
    }
    /*end*/



}

