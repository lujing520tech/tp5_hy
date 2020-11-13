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
    protected $table = 'ims_cadic_adv';
//    protected $hidden = ['update_time','delete_time'];

    public function items()
    {
        return $this->hasMany('banner_item','banner_id','id');
    }


    public static function getBannerById()
    {
        $result = self::all();
        return $result;
    }

}