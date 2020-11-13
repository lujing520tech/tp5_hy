<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 16:07
 */

namespace app\api\controller\v1;

use app\api\model\Classify as ClassifyModel;
use app\api\validate\IsIdInt;
use app\lib\exception\ClassifyMissException;
class Classify
{
    /**
     * @return array
     * @throws ClassifyMissException
     * @throws \think\exception\DbException
     * 分类列表
     */
    public function getClassify()
    {
        $result = (new ClassifyModel())->getClassify();
        if(!$result){
            throw new ClassifyMissException();
        }
        return $result;
    }

    /**
     * @param $pid
     * @return array|false|PDOStatement|string|\think\Model
     * @throws ClassifyMissException
     * 获取具体分类下的商品
     */
    public function getClassifyGoods($pid)
    {
        (new IsIdInt());
        $result = (new ClassifyModel())->getClassifyGoods($pid);
        if(!$result){
            throw new ClassifyMissException();
        }
        return $result;
    }
}