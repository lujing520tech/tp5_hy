<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/12
 * Time: 17:41
 */

namespace app\api\validate;


class GetToken extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    protected $msg = '没有code参数';
}