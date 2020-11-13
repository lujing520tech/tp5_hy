<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 17:38
 */

namespace app\api\service;


class Token
{
    protected function createToken()
    {
        $randString = randString(32);
        $todayTime = $_SERVER['REQUEST_TIME_FLOAT'];
        $token_salt = config('token.token_salt');
        return md5($randString.$todayTime.$token_salt);
    }
}