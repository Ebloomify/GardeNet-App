<?php
/*
 module:		积分商城
 create_time:	2021-11-16 17:38:54
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\Config;
use app\api\service\V1\IntegerShopService;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class IntegerShop extends Common
{

    /*start*/
    /**
     * @api {get} /V1.IntegerShop/info 01、积分商城内容
     * @apiGroup IntegerShop
     * @apiVersion 1.0.0
     * @apiDescription  积分商城内容
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function info()
    {
        $res['config'] = Config::where('name', 'integer_shop_body')->value('data');
        $res['config'] = htmlspecialchars_decode($res['config']);
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/


}

