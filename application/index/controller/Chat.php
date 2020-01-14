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

class Chat
{
    /*接受用户聊天室传来的数据*/
    public function index()
    {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $userId = Token::getUserId($authorization);
        $name = Db::table('live_user')->where(['id'=>$userId])->value('name')?:'用户'.rand(1000,9999);
        $data = [
            'user' => $name,
            'connect' => $_POST['content']
        ];
        Db::table('live_chart')->insert([
            'game_id' => 1,
            'user_id' => $userId,
            'content' => $_POST['content'],
            'create_time' => time()
        ]);
        foreach ($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($data));
        }

    }

}