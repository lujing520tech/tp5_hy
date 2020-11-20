<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');
Route::get('api/:version/adv/:type','api/:version.Banner/getAdv');
Route::get('api/:version/theme','api/:version.Theme/getTheme');
Route::get('api/:version/theme/:id','api/:version.Theme/getThemeGoods');
Route::get('api/:version/classify','api/:version.Classify/getClassify');
Route::get('api/:version/classify/:pid','api/:version.Classify/getClassifyGoods');
Route::get('api/:version/getNewGoods/:count','api/:version.Goods/GetNewGoods');
Route::post('api/:version/getToken/user','api/:version.Token/getToken');
Route::get('api/:version/newGoods','api/:version.Goods/GetNewGoods');
Route::get('api/:version/getGoods/:id','api/:version.Goods/getGoods');
Route::post('api/:version/address/create','api/:version.Address/createAddress');
Route::post('api/:version/address/update','api/:version.Address/updateAddress');
Route::post('api/:version/order','api/:version.Order/placeOrder');
Route::post('api/:version/pay','api/:version.Pay/pay');
Route::post('api/:version/notify','api/:version.Pay/receiveNotify');

