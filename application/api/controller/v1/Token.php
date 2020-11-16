<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/12
 * Time: 17:40
 */

namespace app\api\controller\v1;
use app\api\validate\GetToken;
use app\api\model\Token as TokenModel;
use app\lib\exception\TokenException;
class Token
{
    public function getToken($code='')
    {

        (new GetToken())->goCheck($code);
        $result = (new TokenModel())->getToken($code);
        if (empty($result)){
            throw new TokenException();
        }
        return $result;

    }
}