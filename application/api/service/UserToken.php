<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/13
 * Time: 10:21
 */

namespace app\api\service;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
class UserToken extends Token
{
    protected $wxAppId ;
    protected $wxAppSecret;
    protected $code;
    protected $wxTokenUrl;
    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wx.wxAppId');
            $this->wxAppSecret = config('wx.wxAppSecret');
        $this->wxTokenUrl = sprintf(config('wx.wxTokenUrl'),$this->wxAppId,$this->wxAppSecret,$this->code);
    }

    public function getToken()
    {
        $request = curl_get($this->wxTokenUrl);
        $wxResult = json_decode($request,true);

        if (empty($wxResult)){
            throw new Exception('获取微信appId及secret失败，微信内部错误');
        }
        else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                //获取openid出错
                $this->TokenError($wxResult);
            }
            else{
              $result = $this->userToken($wxResult);
              return $result;
            }
        }

    }

    private function userToken($wxResult)
    {
        $openid = $wxResult['openid'];
        //select userInfo
        $getUser = (new UserModel())->getUser($openid);
        if (!$getUser){
            //insert user
            $uid = $this->newUser($openid);
        }
        else{
            $uid = $getUser->id;
        }
        //create cached array
        $cachedValue = $this->cachedValue($wxResult,$uid);
        $cachedValueJion = json_encode($cachedValue);
        //get token
        $token = self::createToken();
        $pastTime = config('queue.past_time');
        $result = cache($token,$cachedValueJion,$pastTime);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 20001
            ]);
        }
        return $token;
    }

    //insert user
    private function newUser($openid)
    {
        $insertUser = UserModel::create([
            'openid' => $openid
        ]);

        return $insertUser;
    }
    //create cached array
    private function cachedValue($wxResult,$uid)
    {
        $cachedArr = $wxResult;
        $cachedArr['uid'] = $uid;
        $cachedArr['scope'] = 16;
        return $cachedArr;
    }


    /**
     * @param $wxResult
     * @throws WeChatException
     * Wechat request fail action
     */
    private function TokenError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode'],
        ]);
    }


}