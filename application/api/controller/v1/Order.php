<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 13:07
 */

namespace app\api\controller\v1;



use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    //前置方法，验证权限
    protected $beforeActionList = ['checkUserScope' => ['only'=>'placeOrder']];

    private $OrderArr = [
                    [
                        'product_id'=>3,
                        'count'=>3
                    ],
                    [
                        'product_id'=>3,
                        'count'=>2
                    ],
                    [
                        'product_id'=>4,
                        'count'=>2
                    ]
        ];
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
//        $products = input('post.products/a');
        $products = $this->OrderArr;
        $uid = 1;
        $result = (new OrderService())->place($uid,$products);
        return $result;
    }
}