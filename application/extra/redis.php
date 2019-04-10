<?php
//redis 相关配置文件
/*
 * 主机名,端口号,key失效时间
 * */

return [
    'host' => '127.0.0.1',
    'port' => 6379,
    'over_time' => 120,
    'link_time_out' => 5, //链接超时时间5s
    'live_game_key' => 'live_game_key',
];