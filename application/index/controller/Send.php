<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-02
 * Time: 02:52
 */

namespace app\index\controller;

use app\command\Util;
use app\sms\Ucpaas;
use app\sms\UcpaasConf;
use think\Config;
use app\command\Redis;

class Send
{
    /*
     * 发送验证码
     * */
    public function index()
    {
        /*
         * 获取手机号
         * 默认参数是0。将传来的自负转改成整型
         * 这里是有问题的。用tp的获取方式第一次传的值比如是1。第二次传的值是2。他永远都是第一次的值。要想修改就需需要修改框架的东西了。
         * 我们直接用原生的。因为在swoolehttp服务做了这方面的修改
         * */
        //  $phoneNum = request()->get('phone_num', 0, 'intval');
        $phoneNum = intval($_GET['phone_num']);
        if (empty($phoneNum)) {
            return Util::show(Config::get('code.error_phone_empty'), '手机号不能为空 ');
        }
        $code = rand(1000, 9999);

//        $taskData = [
//            'phone' => $phoneNum,
//            'code' => $code
//        ];
        $taskData = [
            'method' => 'sendSms',
            'data' => [
                'phone' => $phoneNum,
                'code' => $code
            ]
        ];
        $_POST['http_server']->task($taskData);
        return Util::show(Config::get('code.success'), '发送成功');
//        try {
//            $json_rst = UcpaasConf::send($phoneNum, $code);
//        } catch (\Exception $e) {
//            return Util::show(Config::get('code.error_sms_error'), '云之信短信异常');
//        }
        /*判断云之讯断线是否发送成功*/
//        $rst = json_decode($json_rst,true);
//        $rst['code'] = '000000';
//        if ($rst['code'] === '000000') {
//            /*将验证码存储到redis  存储可以异步。验证必须要同步的 */
//            go(function () use ($phoneNum, $code) {
//                $redis_server = new \Swoole\Coroutine\Redis();
//                $link = $redis_server->connect(Config::get('redis.host'), Config::get('redis.port'));
//                $redis_server->set(Redis::smsKey($phoneNum),$code,Config::get('redis.over_time'));
//            });
//            return Util::show(Config::get('code.success'), '发送成功');
//        }
    }
}