<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-06
 * Time: 16:55
 */

namespace app\admin\controller;

use app\command\Util;
use think\Config;
use \Upyun\Upyun;
use \Upyun\Config as UConfig;

class Image
{

    public function index()
    {
        $file = $_FILES['file'];
        /*获取最后一个小数点后的所有字符串*/
        $type = strrchr($file['name'], '.');
        $name = self::str_rand(5);
        // 创建实例
        $bucketConfig = new UConfig(Config::get('Upy.server'), Config::get('Upy.user'), Config::get('Upy.password'));
        $client = new Upyun($bucketConfig);
        // 读文件
        $file = fopen($file['tmp_name'], 'r');
        // 上传文件
        $res = $client->write('/' . Config::get('Upy.live_path') . $name . $type, $file);
        // 打印上传结果
        if (isset($res['x-upyun-content-length']) && $res['x-upyun-content-length'] > 0) {
            return Util::show(Config::get('code.success'), 'ok', [
                'image' => Config::get('Upy.site') . Config::get('Upy.live_path') . $name . $type]);
        }

//        $res = move_uploaded_file($file['tmp_name'], '../public/static/upload/' . $name . $type);
//        if ($res) {
//            return Util::show(Config::get('code.success'), 'ok', [
//                'image' => Config::get('web.image_host') . '/upload/' . $name . $type]);
//        } else {
//            return Util::show(Config::get('code.error_upload_image'), 'error');
//        }
    }

    /*返回m长度的字符串*/
    static public function str_rand($m)
    {
        $new_str = '';
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwsyz0123456789';
        for ($i = 1; $i <= $m; ++$i) {
            $new_str .= $str[mt_rand(0, 61)];
        }
        return $new_str;
    }
}