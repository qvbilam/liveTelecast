<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-06
 * Time: 21:05
 */

namespace app\admin\controller;

use app\command\Predis;
use think\Config;

class Live
{
    /*直播赛况表单上传*/
    public function push()
    {
        /*当后端人员发送数据后应该推送给前端用户 GET是解说员发送到服务端的消息。然后转发给客户端*/
//        $users = Predis::getIntance()->sMembers(Config::get('redis.live_game_key'));
//        foreach ($users as $val) {
//            $_POST['http_server']->push($val, json_encode($_GET));
//        }
        foreach ($_POST['http_server']->ports[2]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($_GET));
        }
    }
}