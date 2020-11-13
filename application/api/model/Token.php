<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 9:59
 */

namespace app\api\model;
use app\api\service\UserToken;

class Token extends BaseModel
{
    /**
     *
     */
    public function getToken($code)
    {
        $result = (new UserToken($code))->getToken();

        return $result;
    }
}