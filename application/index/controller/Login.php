<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-03
 * Time: 21:23
 */

namespace app\index\controller;
use app\command\Util;
use think\Config;
use app\command\Predis;
use app\command\Redis;

class Login
{

    public function index()
    {
        $phone = intval($_GET['phone_num']);
        $code = intval($_GET['code']);
        if(empty($phone) || empty($code)){
            return Util::show(Config::get('code.error_phone_code_empty'),'手机号或验证码不能为空');
        }
        /*获取Redis code*/
        $redis_code = Predis::getIntance()->get(Redis::smsKey($phone));
        if($redis_code == $code){
            /*记录用户手机号登录时间等，*/
            $data = [
                'user' => '用户' . $phone,
                'srcKey' => md5(Redis::userkey($phone)),
                'time' => time(),
                'isLogin' => true
            ];
            Predis::getIntance()->set(Redis::userkey($phone),$data);
            return Util::show(Config::get('code.success'),'ok',$data);
        }else{
            return Util::show(Config::get('code.error_login_set'),'ok');
        }

    }

}