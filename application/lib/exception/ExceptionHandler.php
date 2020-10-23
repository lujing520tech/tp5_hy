<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 16:58
 * 异常处理
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;

class ExceptionHandler extends Handle
{
    //重写获取基类
    public function render(Exception $ex)
    {
        return json('-------------');
    }
}