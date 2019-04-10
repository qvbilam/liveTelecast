<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-03
 * Time: 21:27
 */

namespace app\command;

use think\Config;

class Predis
{
    /*
     * 定义单例模式
     * 多次使用redis但是只链接一次redis*/
    public $redis = '';

    static private $_instance = null;

    private function __construct()
    {
        $this->redis = new \Redis();
        $link = $this->redis->connect(Config::get('redis.host'), Config::get('redis.port'), Config::get('redis.link_time_out'));
        if (!$link) {
            throw new \Exception('redis connect error');
        }
    }

    static public function getIntance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function set($key, $value, $time = 0)
    {
        if (!$key) {
            return '';
        }
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (!$time) {
            return $this->redis->set($key, $value);
        }
        return $this->redis->setex($key, $time, $value);
    }

    public function get($key)
    {
        if (!$key) {
            return '';
        }
        return $this->redis->get($key);
    }

//    /*添加有序合集*/
//    public function sadd($key,$value)
//    {
//        return $this->redis->sadd($key,$value);
//    }
//
//    /*删除有序集合的值*/
//    public function sRem($key,$value)
//    {
//        return $this->redis->sRem($key,$value);
//    }

    /*获取所有set的值*/
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }

    public function __call($name, $arguments)
    {
        if(count($arguments) != 2){
            return '';
        }
        return $this->redis->$name($arguments[0],$arguments[1]);
    }

}

