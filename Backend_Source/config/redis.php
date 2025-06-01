<?php
return [
    'scheme' => env('redis.scheme', 'tcp'),
    'host'  =>  env('redis.host', '127.0.0.1'),
    'port' => env('redis.port', '6379'),
    'token' => env('redis.token_db', '1'), // token数据库：默认0~15个
    'cache' => env('redis.cache_db', '0'), // 缓存数据库
    'password' => env('redis.password', ''),
];