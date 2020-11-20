<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 11:54
 */

namespace app\lib\exception;


class ScopeException extends BaseException
{
    protected $rule = [
        'code' => 403,
        'msg' => '用户权限不足，无法访问',
        'errorCode' => 20001,
    ];
}