<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-06
 * Time: 21:05
 */

namespace app\admin\controller;

use app\command\Predis;
use app\command\Util;
use think\Config;
use think\Db;

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

        print_r($_GET);

        $data = [];
        $data['game_id'] = $_GET['fight_id'];
        $data['type'] = $_GET['type'];
        $data['team_id'] = $_GET['team_id'];
        if(isset($_GET['image'])){
            $data['image'] = $_GET['image'];
        }
        $data['content'] = $_GET['content'];
        $sqlData = Db::table('live_palyer')->where(['id' => $data['team_id']])->field('name,image')->find();
        $data['u_image'] = $sqlData['image'];
        $data['u_name'] = $sqlData['name'];
        foreach ($_POST['http_server']->ports[2]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($data));
        }
        unset($data['u_image']);
        unset($data['u_name']);
        Db::table('live_outs')->insert($data);
    }

    /*获取直播数据*/
    public function data()
    {
        /*fight_id=1*/
        $game_id = $_GET['fight_id'];
        /*如果没有节数默认为1*/
        if(!isset($_GET['section'])){
            $_GET['section'] = 1;
        }
        if (!$game_id) {
            return Util::show(Config::get('code.error_admin_game_id_empty'), 'error', '获取直播id失败');
        }
        $data = Db::table('live_game')
            ->alias('t1')
            ->join('live_palyer t2','t1.a_id = t2.id','left')
            ->join('live_palyer t3','t1.b_id = t3.id','left')
            ->where(['t1.id' => $game_id])
            ->field('
                t1.id as id,
                t1.a_id as a_id,
                t1.b_id as b_id,
                t1.a_score as a_score,
                t1.b_score as b_score,
                t1.image as game_image,
                t2.name as a_name,
                t3.name as b_name
            ')
            ->find();
        if(!$data){
            return Util::show(Config::get('code.error_admin_game_data_empty'), 'error', '暂无直播');
        }
        return Util::show(Config::get('code.success'),'ok',$data);
    }
}