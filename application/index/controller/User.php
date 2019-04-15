<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-11
 * Time: 14:17
 */

namespace app\index\controller;

use Firebase\JWT\JWT;
use app\command\Util;


class User
{

    public function index()
    {
        $data = input('post.');
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
        $user = TestModel::where('username', $username)->find();
        if (!empty($user)) {
            if ($username === $user['username'] && $password === $user['password']) {
                $msg = [
                    'status' => 1001,
                    'msg' => '登录成功',
                    'jwt' => self::createJwt($user['id'])
                ];
                return $msg;
            } else {
                return [
                    'status' => 1002,
                    'msg' => '账号密码错误'
                ];
            }
        } else {
            return [
                'status' => 1002,
                'msg' => '请输入账号密码'
            ];
        }
    }

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