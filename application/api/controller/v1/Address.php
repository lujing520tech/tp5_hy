<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/17
 * Time: 17:45
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token;
use app\api\validate\AddressUpdate;
use app\lib\enum\ScopeEnum;
use app\lib\exception\AddressMiss;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use app\api\model\Address as AddressModel;
use think\Controller;

class Address extends Controller
{
    protected $beforeActionList = [
            'first' => ['only' => 'createAddress,updateAddress']
    ];

    private function first()
    {
        //权限控制
        //前置方法
        $scope = (new Token())->getCurrentUid('scope');
        if($scope){
            if($scope>=ScopeEnum::USER){//用户权限可以访问
                return true;
            }
            else{
                throw new TokenException([
                   'msg' => '用户权限不够'
                ]);
            }
        }else{
            throw new ParameterException([
                'msg' => '获取用户权限失败，scope'
            ]);
        }

    }


    /**
     * @param $type
     * @throws TokenException
     * @throws \app\lib\exception\ParameterException
     *
     */
    public function createAddress()
    {

        (new AddressNew())->goCheck();
        //获取token确认uid
        $uid = (new Token())->getCurrentUid('uid');
        if(!$uid){
            throw new TokenException([
                'code' =>'404',
                'msg' => '用户信息错误，uid未获取到',
                'errorCode' => '40002'
            ]);
        }
        $result = (new AddressModel())->createOrUpdateAddress($uid);
        if($result){
            throw new AddressMiss([
                'msg' => '新建成功'
            ]);
        }
    }

    public function updateAddress()
    {
        (new AddressUpdate())->goCheck();
        $uid = (new Token())->getCurrentUid('uid');
        if(!$uid){
            throw new TokenException([
                'code' =>'404',
                'msg' => '用户信息错误，uid未获取到',
                'errorCode' => '40002'
            ]);
        }
        $result = (new AddressModel())->updateAddress($uid);
        if($result){
            throw new AddressMiss([
                'msg' => '修改成功'
            ]);
        }
    }
}