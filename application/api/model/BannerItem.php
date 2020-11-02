<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 10:51
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['update_time','delete_time','id','img_id','banner_id'];

    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}