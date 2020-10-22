<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 12:05
 */

namespace app\api\validate;

use think\Validate;

class IsIdInt extends BaseValidate
{
    protected $rule = [
        'id' =>'require|isPositiveInteger'
    ];
    protected function isPositiveInteger($value,$rule='',$data='',$field='')
    {
        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0)
        {
            return true;
        }
        else{
            return $field.'必须是整正数';
        }


    }

}