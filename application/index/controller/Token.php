<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-12
 * Time: 00:07
 */

namespace app\index\controller;

use think\Request;
use Firebase\JWT\JWT;
use app\command\Util;

class Token
{

    public function checkToken()
    {

        //return json_encode($_SERVER['AUTHORIZATION']);
        $authorization = $_SERVER['AUTHORIZATION'];
        if (empty($authorization)) {
            return 'nmsl';
        } else {
            $checkJwtToken = $this->verifyJwt($authorization);
            return Util::show(0, '0k', $checkJwtToken);
        }

    }

    static public function getUserId($token=0)
    {
        $token = $_POST['token'];
        $key = md5('nobita');
        $jwtAuth = JWT::decode($token, $key, array('HS256'));
        if($jwtAuth['code'] != 0){
            return 0;
        }else{
            return $jwtAuth['data']->user_id;
        }
    }

    //校验jwt权限API
    protected function verifyJwt($jwt)
    {
        $key = md5('nobita');
        // JWT::$leeway = 3;

        $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
        $authInfo = json_decode($jwtAuth, true);
        $msg = [];
        if (!empty($authInfo['user_id'])) {
            $msg = [
                'status' => 1001,
                'msg' => 'Token验证通过'
            ];
        } elseif ($authInfo['error'] == 'expired') {
            $msg = ['status' => 1002, 'msg' => 'token过期'];
        } else {
            $msg = [
                'status' => 1003,
                'msg' => 'Token验证不通过,用户不存在'
            ];
        }
        return $msg;
    }

}
