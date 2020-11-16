<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 14:18
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected function prefixGetUrl($value,$data)
    {
        if($data['from'] != 1){
            //本地
            return config('queue.img_prefix').$value;
        }
        else{
            //网络资源
            return $value;
        }
    }
}