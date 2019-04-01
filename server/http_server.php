<?php

$server = new Swoole\Http\Server("0.0.0.0",9503);

$server->set([
    'enable_static_handel' => true,
    'document_root' => "/Users/qvbilam/Sites/liveTelecast/public/static",
    'worker_num' => 5
]);

$server->on('WorkerStart',function(swoole_server $server, int $worker_id){
    // 定义应用目录 index.php
    define('APP_PATH', __DIR__ . '/../application/');
    // 再去加载php的引导文件  不直接复制index.php的文件中的引入start.php.是因为在start.php中还有执行应用我们不需要。所以直接引入base.php就行
    // x加载基础文件
    require __DIR__ . '/../thinkphp/base.php';

});

$server->on('request', function($request,$response) use($server) {
//    print_r($request->server);
    if(isset($request->server)){
        foreach($request->server as $key => $val){
            $_SERVER[strtoupper($key)] = $val;
        }
    }
    if(isset($request->header)){
        foreach($request->header as $key => $val){
            $_SERVER[strtoupper($key)] = $val;
        }
    }
    $_GET = [];
    if(isset($request->get)){
        foreach($request->get as $key => $val){
            $_GET[$key] = $val;
        }
    }
    $_POST = [];
    if(isset($request->post)){
        foreach($request->post as $key => $val){
            $_POST[$key] = $val;
        }
    }

    // 执行应用
    ob_start();
    try{
        think\App::run()->send();
    }catch(\Exception $e){
//        可以输出一些错误。打错误日志什么的。根据自己业务吧
    }
    $rst = ob_get_contents();
    ob_end_clean();
//    echo request()->action();
    $response->end($rst);
});

$server->start();
