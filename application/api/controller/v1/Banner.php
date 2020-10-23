<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22
 * Time: 10:44
 */

namespace app\api\controller\v1;

    use app\api\model\Banner as BannerModel;
    use app\api\validate\IsIdInt;
    use think\Exception;

    class Banner
    {
        /**
         * 指定id获取banner信息
         * @http GET
         * @url /banner/:id
         * @id banner的id号
         */
        public function getBanner($id)
        {

            (new IsIdInt())->goCheck();
            $re = BannerModel::getBannerById();
            return $re;
        }


    }