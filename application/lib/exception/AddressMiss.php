<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 11:45
 */

namespace app\lib\exception;


class AddressMiss extends BaseException
{
    protected $rule = [
        'code' => 201,
        'msg' => '成功',
        'errorCode' => 0
    ];
}