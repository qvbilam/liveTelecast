<?php
namespace app\index\controller;
use app\sms\UcpaasConf;
use think\Log;
use think\controller;

class Index extends controller
{
    public function index()
    {
        return $this->fetch('/public/static/live/login.html');
    }

    public function qvbilam()
    {
        return 'qvbilam';
    }

    public function yzm()
    {
        $json_rst = new UcpaasConf();
        $rst = json_decode($json_rst);
        if($rst['code'] === '000000'){
            Log::info('发送短信成功');
        }else{
            Log::error('发送短信失败:' . $json_rst);
    }
        echo 123;
    }
}
