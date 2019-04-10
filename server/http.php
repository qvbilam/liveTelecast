<?php

/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-04
 * Time: 00:13
 */
class Http
{
    CONST HOST = '0.0.0.0';
    CONST PORT = 9503;
    public $http = null;
    public $document_root = "/Users/qvbilam/Sites/liveTelecast/public/static";

    public function __construct()
    {
        $this->http = new \Swoole\Http\Server(self::HOST, self::PORT);
        $this->http->set([
            'enable_static_handler' => true,
            'document_root' => $this->document_root,
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);

        $this->http->on('workerstart', [$this, 'onWorkerStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->on('close', [$this, 'onclose']);
        $this->http->start();
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
//        这样在别的地方就可以全局时候httpserver的东西了
        $_POST['http_server'] = $this->http;

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

    public function onTask($server,$taskId,$workerId,$data)
    {
        /*分发task任务 让不同任务走不同逻辑*/
        $obj = new app\command\Task();
        $method = $data['method'];
        $flag = $obj->$method($data['data']);
//        try {
//            $obj = new app\sms\UcpaasConf();
//            $json_rst = $obj::send($data['phone'], $data['code']);
//        } catch (\Exception $e) {
//            echo $e->getMessage();
////            return Util::show(Config::get('code.error_sms_error'), '云之信短信异常');
//        }
//        return "on task finish";
        return $flag;
    }

    public function onFinish($server,$taskId,$data)
    {
        echo "finish-data-success:{$data}\n";
    }

    public function onClose()
    {

    }
}

new Http();