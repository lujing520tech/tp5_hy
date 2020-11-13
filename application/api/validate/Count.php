<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/12
 * Time: 11:53
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
            'count' => 'isPositiveInteger|between:1,15'
    ];
}