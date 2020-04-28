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
            return Util::show(-1, '获取token失败');
        } 
        $checkJwtToken = $this->getUserId($authorization);
        if ($checkToken['code'] != 0){
            return Util::show(-1, '验证token失败');
        }
        return Util::show(0,'ok');
        
    }

    static public function getUserId($token = 0)
    {
        $key = md5('nobita');
        $jwtAuth = JWT::decode($token, $key, array('HS256'));
        if ($jwtAuth['code'] != 0) {
            return 0;
        }
        if (empty($jwtAuth['data']->user_id)) {
            $jwtAuth['data']->user_id = -1;
        }
        return $jwtAuth['data']->user_id;
    }

    //校验jwt权限API | 废弃
    protected function verifyJwt($jwt)
    {
        $key = md5('nobita');
        // JWT::$leeway = 3;

        $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
        $authInfo = json_decode($jwtAuth, true);
        $msg = [];
        if (!empty($authInfo['user_id'])) {
            $msg = [
                'status' => 0,
                'msg' => 'ok'
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
