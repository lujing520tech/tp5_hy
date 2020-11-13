<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 15:24
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $table = 'ims_cadic_theme';
    public  function topicImg()
    {
        return $this->belongsTo('ThemeGoods','topic_img_id','id');
    }
    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }
    public function goods()
    {
        return $this->belongsToMany('Goods','ims_cadic_theme_goods','goods_id','theme_id');
    }
    public function byTheme()
    {
        $result = self::all();
        return $result;
    }
    public function byThemeGoods($id)
    {
        $result = self::with('goods')->find($id);
        return $result;
    }

}