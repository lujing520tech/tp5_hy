<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 15:55
 */

namespace app\lib\exception;


class ThemeMissException extends BaseException
{
    public $code = 404;

    public $msg = '请求theme不存在';

    public $errorCode = 40000;
}