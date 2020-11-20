<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 14:38
 */

namespace app\api\validate;



use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'product' =>'checkProduct'
    ];
    protected $singleRule = [
        'product_id' =>'require|isNotEmpty',
        'count' =>'require|isNotEmpty',
    ];

    protected function checkProduct($value)
    {
        if(!is_array($value)){
            throw new ParameterException([
                'msg' => 'product 不是数组',
            ]);
        }
        if(empty($value)){
            throw new ParameterException([
                'msg' => '不能为空'
            ]);
        }
        foreach ($value as $v){
            $this->checkProductAction($v);
        }
        return true;
    }

    protected function checkProductAction($value)
    {
        $validata = new BaseValidate($this->singleRule);
        $result = $validata->check($value);
        if(!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }

}