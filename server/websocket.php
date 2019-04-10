<?php

/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-04
 * Time: 00:13
 */
class Ws
{
    CONST HOST = '0.0.0.0';
    CONST PORT = 9503;
    CONST CHAT_PORT = 9504;
    CONST LIVE_PORT = 9505;
    public $websocket = null;
    public $document_root = "/Users/qvbilam/Sites/liveTelecast/public/static";
    public $set_redis_key = '';

    public function __construct()
    {
        $this->websocket = new \Swoole\WebSocket\Server(self::HOST, self::PORT);
        $this->websocket->listen(self::HOST, self::CHAT_PORT, SWOOLE_SOCK_TCP);
        $this->websocket->listen(self::HOST, self::LIVE_PORT, SWOOLE_SOCK_TCP);
        $this->websocket->set([
            'enable_static_handler' => true,
            'document_root' => $this->document_root,
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);



        $this->websocket->on('open', [$this, 'onOpen']);
        $this->websocket->on('message', [$this, 'onMessage']);
        $this->websocket->on('workerstart', [$this, 'onWorkerStart']);
        $this->websocket->on('request', [$this, 'onRequest']);
        $this->websocket->on('task', [$this, 'onTask']);
        $this->websocket->on('finish', [$this, 'onFinish']);
        $this->websocket->on('close', [$this, 'onclose']);
        $this->websocket->start();

    }

    /*
     * */
    public function onWorkerStart($server, $worker_id)
    {
        // 定义应用目录 index.php
        define('APP_PATH', __DIR__ . '/../application/');
        // 再去加载php的引导文件  不直接复制index.php的文件中的引入start.php.是因为在start.php中还有执行应用我们不需要。所以直接引入base.php就行
        // x加载基础文件
//        require __DIR__ . '/../thinkphp/base.php';
//        直接引入这个才可以是用tp的功能。要不然回找不到下面app的类。只要让index/index/index人 turn空就行
        require __DIR__ . '/../thinkphp/start.php';

        $this->set_redis_key = \think\Config::get('redis.live_game_key');
        /*判断有没有链接用户。如果有全部清空*/
        $smembers = \app\command\Predis::getIntance()->sMembers($this->set_redis_key);
        $srem = implode(' ', $smembers);
        \app\command\Predis::getIntance()->sRem($this->set_redis_key, $srem);
    }

    /*request 回调*/
    public function onRequest($request, $response)
    {
        if (isset($request->server)) {
            foreach ($request->server as $key => $val) {
                $_SERVER[strtoupper($key)] = $val;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $key => $val) {
                $_SERVER[strtoupper($key)] = $val;
            }
        }
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $key => $val) {
                $_GET[$key] = $val;
            }
        }
        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $key => $val) {
                $_POST[$key] = $val;
            }
        }

        $_FILES = [];
        if (isset($request->files)) {
            foreach ($request->files as $key => $val) {
                $_FILES[$key] = $val;
            }
        }
//        这样在别的地方就可以全局时候httpserver的东西了
        $_POST['http_server'] = $this->websocket;

        // 执行应用
        ob_start();
        try {
            think\App::run()->send();
        } catch (\Exception $e) {
//        可以输出一些错误。打错误日志什么的。根据自己业务吧
        }
        $rst = ob_get_contents();
        ob_end_clean();
        $response->end($rst);
    }

    public function onTask($server, $taskId, $workerId, $data)
    {
        /*分发task任务 让不同任务走不同逻辑*/
        $obj = new app\command\Task();
        $method = $data['method'];
        $flag = $obj->$method($data['data']);
        return $flag;
    }

    public function onFinish($server, $taskId, $data)
    {
        echo "finish-data-success:{$data}\n";
    }

    public function onOpen($ws, $frame)
    {

//        将用户存放到redis
        \app\command\Predis::getIntance()->sadd($this->set_redis_key, $frame->fd);
        echo $frame->fd;

    }

    public function onMessage($ws, $frame)
    {

        $ws->push($frame->fd, 'push内容');
    }

    public function onClose($ws, $fd)
    {
        /*删除断开链接的用户*/
        \app\command\Predis::getIntance()->srem($this->set_redis_key, $fd);
        echo $fd . '/close' . PHP_EOL;

    }
}

new Ws();