<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-04
 * Time: 01:39
 * 代表所以的Task异步任务都在这里执行
 */

namespace app\command;

use app\sms\UcpaasConf;
use think\Config;
use app\command\Predis;


class Task
{
    /*异步发送验证*/
    public function sendSms($data)
    {
        /*发送验证码*/
        try {
            $json_rst = UcpaasConf::send($data['phone'], $data['code']);
        } catch (\Exception $e) {
            return false;
        }
        /*验证*/
        /*判断云之讯断线是否发送成功*/
        $rst = json_decode($json_rst, true);
        $rst['code'] = '000000';
        if ($rst['code'] === '000000') {
            /*将验证码存储到redis  存储可以异步。验证必须要同步的 */
//            go(function () use ($data) {
//                $redis_server = new \Swoole\Coroutine\Redis();
//                $link = $redis_server->connect(Config::get('redis.host'), Config::get('redis.port'));
//                $redis_server->set(Redis::smsKey($data['phone']),$data['code'],Config::get('redis.over_time'));
//            });
//            return Util::show(Config::get('code.success'), '发送成功');
            Predis::getIntance()->set(Redis::smsKey($data['phone']), $data['code'], Config::get('redis.over_time'));
            return true;
        } else {
            return false;
        }
    }
}