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
use think\Db;
use app\command\Mysql;
use Firebase\JWT\JWT;
use app\index\controller\Token;

class Login extends Base
{

    // 用户登录 GET
    public function index()
    {
        if (empty($_GET['code']) && empty($_POST['code'])) {
            return Util::show(Config::get('code.error_phone_code_empty'), '验证码不能为空');
        }
        if (empty($_GET['phone_num']) && empty($_POST['phone_num'])) {
            return Util::show(Config::get('code.error_phone_code_empty'), '手机号不能为空');
        }
        $phone = isset($_GET['phone_num']) ? $_GET['phone_num'] : $_POST['phone_num'];
        $code = isset($_GET['code']) ? $_GET['code'] : $_POST['code'];
        /*获取Redis code*/
        $redis_code = Predis::getIntance()->get(Redis::smsKey($phone));
        if ($redis_code == $code) {
            /*记录用户手机号登录时间等，*/
            $autoName = 'auto_id' . rand(1000, 9999);
            $user = json_decode(self::createUser($phone, $autoName), true);
            $token = self::createJwt($user['user_id'], md5('nobita'));
            if ($user['type'] == 'register') {
                return Util::show(Config::get('code.success'), 'perfect', ['token' => $token]);
            } else {
                return Util::show(Config::get('code.success'), 'login', ['token' => $token]);
            }
        } else {
            return Util::show(Config::get('code.error_login_set'), 'error');
        }

    }

    public function perfect()
    {
        if (empty($_GET['name']) && empty($_POST['name'])) {
            return Util::show(Config::get('code.error_perfect_empty'), '昵称不能为空');
        }
        // 验证token
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return Util::show(Config::get('code.error_perfect_empty'), 'token不能为空');
        }
        $userId = $this->getUserId($_SERVER['HTTP_AUTHORIZATION']);
        $name = isset($_GET['name']) ? $_GET['name'] : $_POST['name'];
        if ($userId) {
            $res = Db::table('live_user')->where(['id' => $userId])->update([
                'name' => $name,
                'update_time' => time()
            ]);
            if (!$res) {
                return Util::show(Config::get('code.error_perfect'), 'error');
            }
            return Util::show(Config::get('code.success'), 'ok');
        } else {
            return Util::show(Config::get('code.error_perfect_token'), 'error');
        }
    }

    /*创建用户*/
    public function createUser($phone, $name)
    {
        $user = Db::table('live_user')->where(['phone' => $phone])->find();
        if (!$user['id']) {
            Db::table('live_user')->insert([
                'phone' => $phone,
                'name' => $name,
                'create_time' => time(),
                'update_time' => time()
            ]);
            $id = Db::table('live_user')->getLastInsID();
            $data = json_encode([
                'user_id' => $id,
                'type' => 'register'
            ]);
        } else {
            Db::table('live_user')->where(['phone' => $phone])->update(['update_time' => time()]);
            $data = json_encode([
                'user_id' => $user['id'],
                'type' => 'login'
            ]);
        }
        return $data;
    }


    /*创建token*/
    public function createJwt($userId)
    {
        $key = md5('nobita'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 14400; //过期时间
        $token = array(
            "user_id" => $userId,
            "iss" => "http://www.qvbilam.xin",//签发组织
            "aud" => "QvBiLam", //签发作者
            "iat" => $time,
            "nbf" => $time,
            "exp" => $expire
        );
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

}