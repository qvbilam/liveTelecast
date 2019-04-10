<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-10
 * Time: 15:08
 */

namespace app\index\controller;

class Chat
{
    /*接受用户聊天室传来的数据*/
    public function index()
    {
        $data = [
            'user' => '用户' . rand(1000, 9999),
            'connect' => $_POST['content']
        ];
        foreach ($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($data));
        }

    }

}