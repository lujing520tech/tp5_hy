<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 17:43
 */

namespace app\api\controller\v1;


use app\api\validate\IsIdInt;
use app\api\service\Pay as PayService;

class Pay
{
    public function pay($id)
    {
        (new IsIdInt())->goCheck();
        $result = (new PayService($id))->pay();
    }

    public function receiveNotify()
    {

    }

}