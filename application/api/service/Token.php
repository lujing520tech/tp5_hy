<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 17:38
 */

namespace app\api\service;

use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Request;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ParameterException;

class Token
{
    protected function createToken()
    {
        $randString = randString(32);
        $todayTime = $_SERVER['REQUEST_TIME_FLOAT'];
        $token_salt = config('token.token_salt');
        return md5($randString . $todayTime . $token_salt);
    }

    public static function getcurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $cacheUser = Cache::get($token);
        if (!$cacheUser) {
            throw new TokenException();
        }
        if (!is_array($cacheUser)) {
            $cacheUser = json_decode($cacheUser, true);
        }
        return $cacheUser[$key];

    }

    public function getCurrentUid($key)
    {
        $uid = self::getcurrentTokenVar($key);
        return $uid;
    }


    public static function UserCheckScope()
    {
        //权限控制
        //前置方法
        $scope = self::getCurrentUid('scope');
        if ($scope) {
            if ($scope == ScopeEnum::USER) {//用户权限可以访问
                return true;
            } else {
                throw new TokenException([
                    'msg' => '用户权限不够'
                ]);
            }
        } else {
            throw new ParameterException([
                'msg' => '获取用户权限失败，scope'
            ]);
        }
    }

    public static function MemberCheckScope()
    {
        //权限控制
        //前置方法
        $scope = (new Token())->getCurrentUid('scope');
        if ($scope) {
            if ($scope == ScopeEnum::MEMBER) {//用户权限可以访问
                return true;
            } else {
                throw new TokenException([
                    'msg' => '用户权限不够'
                ]);
            }
        } else {
            throw new ParameterException([
                'msg' => '获取用户权限失败，scope'
            ]);
        }
    }

    public function checkUserOrder($orderUserId)
    {
        $uid = $this->getcurrentTokenVar('uid');
        if($uid != $orderUserId){
            return false;
        }
        return true;
    }


}