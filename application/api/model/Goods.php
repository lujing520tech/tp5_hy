<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 15:10
 */

namespace app\api\model;


class Goods extends BaseModel
{
    protected $table = 'ims_cadic_goods';
    protected $hidden = ['from','add_time'];

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取指定商品
     */
    public function getGoods($id)
    {
        $result = self::find($id);
        return $result;
    }

    public function getGoodsImgAttr($value,$data)
    {
         $result = self::prefixGetUrl($value,$data);
         return $result;
    }

    public function getNewGoods($count)
    {
        $result = self::limit($count)->order('id desc')->select();

        return $result;
    }

}