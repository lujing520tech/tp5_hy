<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 16:57
 */

namespace app\lib\exception;


class GoodsMissException extends BaseException
{
    public $code = 404;

    public $msg = '请求goods不存在';

    public $errorCode = 3000;
}