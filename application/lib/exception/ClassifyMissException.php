<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 16:39
 */

namespace app\lib\exception;


class ClassifyMissException extends BaseException
{
    public $code = 404;

    public $msg = '请求classify不存在';

    public $errorCode = 40000;
}