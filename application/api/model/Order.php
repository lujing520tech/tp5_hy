<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 13:47
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $table = 'ims_cadic_order';
    protected $autoWriteTimestamp;
//    protected $createTime = 'add_time';
}