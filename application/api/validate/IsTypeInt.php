<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/16
 * Time: 11:04
 */

namespace app\api\validate;


class IsTypeInt extends BaseValidate
{
    protected $rule = [
        'type' => 'require|isPositiveInteger|between:1,3'
    ];

}