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
    protected $hidden = ['state','add_time','from','adv_type','sort'];



    public function items()
    {
        return $this->hasMany('banner_item','banner_id','id');
    }


    public static function getBannerById()
    {
        $result = self::all();
        return $result;
    }
    public function getImgUrlAttr($value,$data)
    {
      $result = self::prefixGetUrl($value,$data);
      return $result;
    }

    /**
     * @param $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @type = 1,2,3,4,
     * @注：根据不同的type，确定广告类型
     */
    public function getAdvByType($type)
    {
        $result = self::where('adv_type','=',$type)->select();

        return $result;
    }

}