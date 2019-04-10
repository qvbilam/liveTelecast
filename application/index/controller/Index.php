<?php
namespace app\index\controller;
use app\sms\UcpaasConf;
use think\Config;
use think\Log;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return '';
    }

    public function qvbilam()
    {
        echo 123;
        print_r(Config::get('code'));
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
