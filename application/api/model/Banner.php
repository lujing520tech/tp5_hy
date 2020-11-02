<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 15:58
 */

namespace app\api\model;



use think\Exception;
use think\Db;

class Banner extends BaseModel
{
    //可以重新定义表名
//    protected $table = 'banner_item';
    protected $hidden = ['update_time','delete_time'];
    public function items()
    {
        return $this->hasMany('banner_item','banner_id','id');
    }


    public static function getBannerById($id)
    {
        $result = self::with(['items','items.img'])->find($id);
        return $result;
    }
    public static function test()
    {
        $data = [
            'name' => 'name',
            'age' => 'age'
        ];
        return $data;
    }
}