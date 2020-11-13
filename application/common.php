<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function curl_get($url){

    $ch = curl_init();


    curl_setopt($ch,CURLOPT_URL,$url); //请求的URL
    curl_setopt($ch,CURLOPT_HEADER,false); //是否显示头部
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); //是否直接输出到屏幕
//上面true 和 false 也可以用0、1，但我习惯用这个。由于只是取数据，没必要显示到屏幕上
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //https请求 不验证证书 其实只用这个就可以了
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //https请求 不验证HOST

//curl_setopt($ch,CURLOPT_POST,true); //是否以post方式
    $accToken = curl_exec($ch);
    curl_close($ch);
    return $accToken;
};

function randString($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890sdsadwcafafwadscxcasdwadsfwfadscfeadwqdsacgujh";
    $max = strlen($strPol)-1;

    for ($i = 0; $i<$length; $i++){
        $str.= $strPol[rand(0,$max)];
    }
    return $str;
}