<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 13:54
 */

namespace app\api\validate;



use app\lib\exception\ParameterException;
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
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
//            $e->msg = $this->error;
            throw $e;
//            $error = $this->error;
//            throw new Exception($error);
        }
        else{
            return true;
        }
    }

    /**
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     * 验证id参数
     */
    protected function isPositiveInteger($value,$rule='',$data='',$field='')
    {
        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0)
        {
            return true;
        }
        else{
            return $field.'必须是整正数';
        }

    }
    protected function isNotEmpty($value,$rule='',$data='',$field='')
    {
        if(!empty($value))
        {
            return true;
        }

        else{
            return false;
        }

    }

    /**
     * @param $arrays
     * @return array
     * @throws ParameterException
     * 过滤接口传来其他参数
     */
    public function getDataByRule($arrays)
    {
        if(array_key_exists('user_id',$arrays)||array_key_exists('uid',$arrays)){
            throw new ParameterException([
                'msg' => '非法请求，请求字段中包含uid，user_id 等敏感字段',
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }




}