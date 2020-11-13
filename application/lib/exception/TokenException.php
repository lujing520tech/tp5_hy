<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 17:52
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 404;

    public $msg = '请求的Token不存在或过期';

    public $errorCode = 40000;
}