<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-12-25
 * Time: 15:14
 */

namespace app\index\controller;

use app\command\Util;
use think\Config;
use app\command\Predis;
use app\command\Redis;
use think\Db;
use app\command\Mysql;
use Firebase\JWT\JWT;
use app\index\controller\Token;

class Base
{
    public function getUserId($jwt)
    {
        $key = md5('nobita');
        $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
        $authInfo = json_decode($jwtAuth, true);
        if ($authInfo['code'] == 0) {
            return $authInfo['data']['user_id'];
        }
        return false;
    }
}