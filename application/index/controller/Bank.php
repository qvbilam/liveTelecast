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
    public $size = 6;
    /*大版块首页*/
    public function index()
    {
//        $data = Db::table('live_program')->field('id,name,image')->select();
//        $data = Db::table('live_program')->alias('t1')
//            ->join('live_bank t2', 't1.bank_id=t2.id', 'LEFT')
//            ->where('t2.state',1)
//            ->field('t1.id as id,t1.name as name,t1.image as image,t2.name as bank_name')
//            ->select();
        $data = Db::table('live_bank')->where('state', 1)->field('id as bank_id,name as bank_name')->order('order', 'desc')->select();
        foreach ($data as &$v) {
            $v['data'] = Db::table('live_program')->where('bank_id', $v['bank_id'])->field('id,name,image')->order('order', 'desc')->limit(4)->select();
        }
        return Util::show(0, 'ok', $data);
    }

    public function detail()
    {
        if (!isset($_GET['bank_id'])) {
            return Util::show(-20001, '获取板块信息错误');
        }
        $pageInfo['page'] = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $pageInfo['size'] = !empty($_GET['size']) ? intval($_GET['size']) : $this->size;
        $pageInfo['from'] = ($pageInfo['page'] - 1) * $pageInfo['size'];
        $state = Db::table('live_bank')->where('state', 1)->where('id', $_GET['bank_id'])->find();
        if (empty($state)) {
            return Util::show(-20002, '板块被禁用');
        }
        $data_count = Db::table('live_program')->where('bank_id', $_GET['bank_id'])->count('*');
        $data_res = Db::table('live_program')->where('bank_id', $_GET['bank_id'])->order('id', 'desc')->limit($pageInfo['from'], $pageInfo['size'])->select();
        $data = (new Base())->getPagingDatas($data_count,$pageInfo['size'],$data_res);
        return Util::show(0, 'ok', $data);
    }

    public function fight()
    {
        if (!isset($_GET['program_id'])) {
            return Util::show(-20003, '获取信息失败');
        }
        $program_id = $_GET['program_id'];
        $data = Db::table('live_camp')->where(['program_id' => $program_id])->field('id,name,image')->select();
        return Util::show(0, 'ok', $data);
    }

    public function banner()
    {
        $data = Db::table('live_banner')->where('state', 1)->order('order', 'desc')->field('image')->select();

        return Util::show(0, 'ok', $data);
    }


}