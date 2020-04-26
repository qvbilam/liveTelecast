<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2020-04-26
 * Time: 16:45
 */

namespace app\index\controller;

use app\command\Util;
use app\index\controller\Token;
use think\Config;
use think\Exception;

class Auth extends Base
{
    public $userId;

    public function _initialize()
    {
        if (empty($_SERVER['AUTHORIZATION'])) {
            echo json_encode(['code' => -1, 'msg' => 'token不能为空']);
            exit();
        }
        $authorization = $_SERVER['AUTHORIZATION'];
        $userId = Token::getUserId($authorization);
        if (!$userId) {
            echo json_encode(['code' => 403, 'msg' => '登录失败']);
            exit();
        }
        $this->userId = $userId;
    }
}