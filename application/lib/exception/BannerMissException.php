<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 16:59
 */

namespace app\lib\exception;


class BannerMissException
{
    public $code = 404;

    public $msg = '请求banner不存在';

    public $errorCode = 40000;

}