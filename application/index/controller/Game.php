<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-12
 * Time: 22:22
 */

namespace app\index\controller;

use app\command\Util;
use think\Db;
use think\Config;
use app\command\Predis;
use app\command\Redis;


class Game extends Auth
{
    public function getData()
    {
        if(!$_GET['game_id']){
            return Util::show(-1,'暂无数据',[]);
        }
        $game_id = $_GET['game_id'];
        $live = Predis::getIntance()->get(Redis::$live_pre) ?: self::liveData($game_id);
        $chat = Predis::getIntance()->get(Redis::$chat_pre) ?: self::chatData($game_id);
        $game = Predis::getIntance()->get(Redis::$data_pre) ?: self::gameData($game_id);
        return Util::show(Config::get('code.success'), 'ok', [
            'live' => json_decode($live, true),
            // 'chat' => json_decode($chat, true),
            'chat' => [], // 不获取历史聊天数据
            'game' => json_decode($game, true)
        ]);
    }

    /*首页数据*/
    public function gameData($game_id = 1)
    {
        $data = Db::table('live_game')->alias('t1')
            ->join('live_palyer t2', 't1.a_id=t2.id', 'left')
            ->join('live_palyer t3', 't1.b_id=t3.id', 'left')
            ->where('t1.id', '=', $game_id)
            ->field('
                t1.image as banner_image,
                t2.id as a_id,
                t2.name as a_name,
                t2.image as a_image,
                t3.id as b_id,
                t3.name as b_name,
                t3.image as b_image,
                t1.a_score as a_score,
                t1.b_score as b_score
            ')
            ->select();
        $data = json_encode($data);
        Predis::getIntance()->set(Redis::$data_pre, $data, 60);
        return $data;
    }

    /*图片直播数据*/
    public function liveData($game_id = 1)
    {
        $newData = [
            [],
            [],
            [],
            []
        ];
        $data = Db::table('live_outs')->alias('t1')
            ->join('live_palyer t2', 't1.team_id=t2.id', 'left')
            ->where(['t1.game_id' => $game_id])
            ->field('
                t2.id as uid,
                t2.name as uname,
                t2.image as uimage,
                t1.game_id as game_id,
                t1.content as content,
                t1.image as image,
                t1.type as type
            ')
            ->order('t1.type')
            ->select();
        foreach ($data as $val) {
            switch ($val['type']) {
                case 1:
                    array_push($newData[0], $val);
                    break;
                case 2:
                    array_push($newData[1], $val);
                    break;
                case 3:
                    array_push($newData[2], $val);
                    break;
                case 4:
                    array_push($newData[3], $val);
                    break;
            }
        }
        $data = array_filter($newData);
//        Predis::getIntance()->set(Redis::$live_pre,$data,60);
        return json_encode($data);
    }

    /*聊天室数据*/
    public function chatData($game_id = 1)
    {
        $res = Db::table('live_chart')->alias('t1')
            ->join('live_user t2', 't1.user_id=t2.id', 'left', 'left')
            ->where(['t1.game_id' => $game_id])
            ->field('
                t1.user_id as uid,
                t2.name as uname,
                t1.content as content,
                t1.create_time as time
            ')
            ->select();
        $data = json_encode($data);
        Predis::getIntance()->set(Redis::$chat_pre, $data, 60);
        return $data;
    }
}