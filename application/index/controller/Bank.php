<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-12
 * Time: 17:29
 */

namespace app\index\controller;

use app\command\Util;
use think\Db;

class Bank
{
    /*大版块首页*/
    public function index()
    {
        $data = Db::table('live_program')->field('id,name,image')->select();
        return Util::show(0, 'ok', $data);
    }

    public function fight()
    {
        $program_id = $_GET['program_id'];
        $data = Db::table('live_camp')->where(['program_id' => $program_id])->field('id,name,image')->select();
        return Util::show(0, 'ok', $data);
    }
}