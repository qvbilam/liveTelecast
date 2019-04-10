<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-03
 * Time: 17:40
 */

namespace app\command;

class Redis
{

    static public $sms_pre = 'sms_';
    static public $user_pre = 'user_';
    /*手机验证码 redis key的 前缀的*/
    static public function smsKey($phone)
    {
        return self::$sms_pre . $phone;
    }

    static public function userkey($phone)
    {
        return self::$user_pre . $phone;
    }
}