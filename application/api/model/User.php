<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 12:01
 */

namespace app\api\model;


class User extends BaseModel
{
    protected $table = 'ims_cadic_user';
    public function getUser($openid)
    {
        $result = self::where('openid','=',$openid)->find();
        return $result;

    }
}