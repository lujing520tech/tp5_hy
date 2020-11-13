<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/11
 * Time: 16:08
 */

namespace app\api\model;


class Classify extends BaseModel
{
    protected $table = 'ims_cadic_classify';
    protected $hidden =['from','son_id','add_time','sort'];

    public function joinGoods()
    {
        return $this->hasMany('Goods','classify_id');
    }

    /**
     * @return array
     * @throws \think\exception\DbException
     * 获取分类列表
     */
    public function getClassify()
    {

        $result =  $this->classifyAction(self::select()->toArray());
        return $result;
    }

    /**
     * @param $items
     * @return array
     * 处理分类方法
     */
    private function classifyAction($items)
    {
        $temp_key = array_column($items,'id');  //键值
        $items= array_combine($temp_key,$items) ;
        $tree = array();
        foreach($items as $item){
            if(!empty($items[$item['path_id']])){
                $items[$item['path_id']]['son'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    public function getClassifyGoods($pid)
    {
        $result = self::with('joinGoods')->find($pid);
        return $result;
    }
}