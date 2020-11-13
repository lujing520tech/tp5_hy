<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 15:59
 */

namespace app\api\controller\v1;

use app\api\model\Goods as GoodsModel;
use app\api\validate\Count;
use app\api\validate\IsIdInt;
use app\lib\exception\GoodsMissException;
class Goods
{
    /**
     * @param $id
     * @throws GoodsMissException
     * 获取指定id的商品
     */
    public function GetGoods($id)
    {
        (new IsIdInt());
        $result = (new GoodsModel())->getGoods($id);
        if($result->isEmpty()){
            throw new GoodsMissException;
        }
    }

    /**
     * @param int $count
     * @throws GoodsMissException
     * @throws \app\lib\exception\ParameterException
     * 获取最新数据（默认15条）
     */
    public function GetNewGoods($count=15)
    {
        (new Count())->goCheck();
        $result = (new GoodsModel())->getNewGoods($count);
        if($result->isEmpty()){
            throw new GoodsMissException();
        }
        return $result;
    }
}