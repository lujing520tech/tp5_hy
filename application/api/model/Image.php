<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 11:22
 */

namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id','form','update_time'];

    public function getUrlAttr($value,$data)
    {
        $result = $this->prefixGetUrl($value,$data);
        return $result;
    }
}