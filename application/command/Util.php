<?php
/**
 * Created by PhpStorm.
 * User: qvbilam
 * Date: 2019-04-02
 * Time: 15:14
 */
namespace app\command;

class Util
{
    static public function show($code,$msg='',$data=[])
    {
        $result = [
            'code' => $code,
            'msg' =>$msg,
            'data'=> $data
        ];
        return json_encode($result);
    }

}