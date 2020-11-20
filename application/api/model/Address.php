<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 9:57
 */

namespace app\api\model;


use app\api\validate\AddressNew;
use app\api\validate\AddressUpdate;
use app\lib\exception\ParameterException;

class Address extends BaseModel
{
    /**
     * @param $uid
     * @param
     */
    public function createAddress($uid)
    {
        $address = (new AddressNew())->getDataByRule(input('post.'));
        $address['uid'] = $uid;
        $createAddress = self::insert($address);
        if(!$createAddress){
            throw new ParameterException([
                'msg' => '服务器新增数据失败'
            ]);
        }
        return $createAddress;
    }

    public function updateAddress($uid)
    {
        $address = (new AddressUpdate())->getDataByRule(input('post.'));
        $updateAddress = self::where(['uid','=',$uid])->where(['id'=>$address['id']])->update($address);
        if(!$updateAddress){
            throw new ParameterException([
                'msg' => '服务器修改数据失败'
            ]);
        }
        return $updateAddress;
    }
}