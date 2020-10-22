<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 13:54
 */

namespace app\api\validate;



use think\Exception;
use think\Validate;
use think\Request;

class BaseValidate extends Validate
{
    public function  goCheck()
    {
        //获取http传入的参数
        //对这些参数做检验
        $request = Request::instance();
        $param = $request->param();
        $result = $this->check($param);
        if(!$result){
            $error = $this->error;
            throw new Exception($error);
        }
        else{
            return true;
        }
    }


}