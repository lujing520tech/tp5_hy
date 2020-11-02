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
    public  function topicImg()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }
    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }
    public function byTheme()
    {
        $result = self::with(['topicImg','headImg'])->find();
        return $result;
    }

}