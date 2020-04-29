<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-10
 * Time: 15:08
 */

namespace app\index\controller;

use think\Db;
use Firebase\JWT\JWT;
use app\index\controller\Token;
use app\command\Util;

class Chat extends Auth
{
    /*接受用户聊天室传来的数据*/
    public function index()
    {
        $userId = $this->userId;
        if(!$_POST['data']){
            return Util::show(-1,'获取数据失败');
        }
        $data = $_POST['data'];
        // $data = base64_encode(('{"game_id":1,"content":"傻逼赵彩霞"}'));
        $params = json_decode(base64_decode($data),true);
        $params_base = base64_decode($data);
        $params_url = urldecode($params);
        $params = json_decode($params);
        if(!$params){
            return Util::show(-1,'数据格式不正确');
        }
        // $name = Db::table('live_user')->where(['id' => $userId])->value('name') ?: '用户' . rand(1000, 9999);
        $userInfo = Db::table('live_user')->where(['id' => $userId])->field('name,vip')->find();
        $data = [
            'user' => $userInfo['name'] ?: '用户' . rand(1000, 9999),
            'content' => $params['content'],
            'vip' => $userInfo['vip'] ?: 0,
            'type' => 'chat'
        ];
        Db::table('live_chart')->insert([
            'game_id' => $params['game_id']?:0,
            'user_id' => $userId,
            'content' => $params['content'],
            'create_time' => time()
        ]);
        foreach ($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, base64_encode(json_encode($data)));
        }

    }

}