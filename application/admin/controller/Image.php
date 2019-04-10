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

class Image
{

    public function index()
    {
        $file = $_FILES['file'];
//        print_r($file);
        /*获取最后一个小数点后的所有字符串*/
        $type = strrchr($file['name'], '.');
        $name = self::str_rand(5);
        $res = move_uploaded_file($file['tmp_name'], '../public/static/upload/' . $name . $type);
        if ($res) {
            return Util::show(Config::get('code.success'), 'ok', [
                'image' => Config::get('web.image_host') . '/upload/' . $name . $type]);
        } else {
            return Util::show(Config::get('code.error_upload_image'), 'error');
        }
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