<?php

namespace app\sms;

use app\sms\Ucpaas;

class UcpaasConf
{
    static public function send($mobile,$param)
    {
        //初始化必填
//填写在开发者控制台首页上的Account Sid
        $options['accountsid'] = '455c8c069efd3405548fcb0747909a23';
//填写在开发者控制台首页上的Auth Token
        $options['token'] = 'e4ff654f2bd6d2db1dc9e82e00ed456c';

//初始化 $options必填
        $ucpass = new Ucpaas($options);
        $appid = "f58f8cd5633945bdbce69b3246582c3e";    //应用的ID，可在开发者控制台内的短信产品下查看
        $templateid = "272661";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID
//$param = $_POST['yzm']; //多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
//$mobile = $_POST['yzmtel'];
        /*$param = 1324;
        $mobile = 13501294164;*/
        $uid = "";

//70字内（含70字）计一条，超过70字，按67字/条计费，超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。

        return $ucpass->SendSms($appid, $templateid, $param, $mobile, $uid);
    }
}
