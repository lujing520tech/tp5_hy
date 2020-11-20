<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 13:51
 */

namespace app\api\controller\v1;


use think\Controller;
use app\api\service\Token;

class BaseController extends Controller
{
    protected function checkUserScope()
    {
        echo 11;
        die;
        //权限控制
        Token::UserCheckScope();
    }
    protected function checkMemberScope()
    {
        //权限控制
        //前置方法
       Token::MemberCheckScope();
    }
}