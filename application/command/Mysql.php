<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-11
 * Time: 00:09
 */

namespace app\command;

use think\Config;

class Mysql
{
    public $database = '';
    public $db_conf = '';

    public function __construct()
    {

        $this->database = new \Swoole\Coroutine\MySQL();
        $this->db_conf = ([
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => 'root',
            'database' => 'live'
        ]);
        print_r($this->database);
    }

    public function add()
    {
//        todo
    }

    public function upd()
    {
//   todo
    }

    public function del()
    {
//        todo
    }

    public function execut($id, $user_id)
    {
        go(function () use ($id, $user_id) {
            $connect = $this->database->connect($this->db_conf);
            if(!$connect){
                print_r($this->database->connect_error);
            }
            //$sql = "select * from live_palyer";
            $sql = 'insert into live_palyer (name) value (77)';
            $rst = $this->database->query($sql);
            if ($rst === false) {
                print_r($this->database->error);
            } elseif ($rst === true) {
                echo '修改或添加成功';
            } else {
//                打印查询出来的结果集
                print_r($rst);
            }
            $this->database->close();
        });
        return '你好';

    }

}