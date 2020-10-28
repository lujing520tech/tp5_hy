<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/28
 * Time: 17:30
 */

namespace app\lib\exception;


use Throwable;

class ParameterException extends BaseException
{
    public $code = 404;

    public $msg = '参数异常';

    public $errorCode = 10000;


}