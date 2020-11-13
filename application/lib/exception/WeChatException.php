<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 11:51
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 404;

    public $msg = 'weChat不存在';

    public $errorCode = 40000;
}