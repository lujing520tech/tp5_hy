<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 16:59
 */

namespace app\lib\exception;


class BaseException
{
    // HTTP 状态码 401 ，200
    public $code = 400;

    //错误具体信息
    public $msg = 'parameter is error';

    //自定义的错误码
    public $errorCode = '10000';
}