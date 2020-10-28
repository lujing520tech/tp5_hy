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
use app\lib\exception\BaseException;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //重写获取基类
    public function render(Exception $e)
    {

        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->errorCode = $e->errorCode;
            $this->msg = $e->msg;
        }
        else{

            //错误开关，页面or json 读取配设信息。和调试、生产模式相关
            if(config('app_debug')){
                //调用父类
                return parent::render($e);
            }
            else{
                $this->code = 500;
                $this->errorCode = 999;
                $this->msg = '未知错误,系统内容错误';
                $this->recordErrorLog($e);
            }

        }
            $request = Request::instance();
            $result = [
                'errorCode' => $this->errorCode,
                'msg' => $this->msg,
                'requestUrl' => $request->url(),
            ];
            return json($result,$this->code);
    }

    private function recordErrorLog(Exception $e){
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}