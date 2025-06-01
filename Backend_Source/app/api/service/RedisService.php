<?php


namespace app\api\service;


use Predis\Client;

class RedisService
{
    public function __construct() {}

    /**
     * 静态调用redis
     */
    public static function connect($db = 0){
        $con = [
            'scheme' => config('redis.scheme'),
            'host' => config('redis.host'),
            'port' => config('redis.port'),
            'database' => $db,//config('redis.database'),
            'password' => config('redis.password')
        ];
        return new Client($con);
    }
}