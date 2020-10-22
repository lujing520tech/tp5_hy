<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/20
 * Time: 17:38
 */

namespace app\sample\controller;


use think\Request;

class Test
{
        public function pig($id,$name)
        {
            echo $id;
            echo "|";
            echo $name;
        }
        //通过路由获取参数
        public function two($id,$name,$egg)
        {
            echo $id;
            echo '|';
            echo $name;
            echo '|';
            echo $egg;
        }
        //通过request获取参数
        public function three()
        {
            $id = Request::instance()->param('id');
            $name = Request::instance()->param('name');
            $arr_three = Request::instance()->route();//获取路径参数；
            $get_three = Request::instance()->get();//获取问号后面的参数；
            $POST_three = Request::instance()->post();//获取post里面的参数；

            //助手函数
            $id = input('param.');//获取全部
            $id = input('get.id');
            $id = input('post.id');
            echo $id;
         echo '|';
            echo $name;
        }
        public function four()
        {
            //独立验证
            $data = [
                'name'=>'nihao2321321',
                'email'=>'846572985@qq.com'
            ];
//            $validata = new Validate([
//                'name' => 'require|max:10',
//                'email' => 'email'
//            ]);
            $validata = new TestValidate();
            $result = $validata->check($data);
            var_dump($validata->getError());
            //验证器
        }

}