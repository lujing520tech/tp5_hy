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
    use app\lib\exception\BannerMissException;
    use think\Exception;
    use think\Model;

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
            $result =  (new BannerModel)->getBannerById($id);
            if(!$result){
                throw new BannerMissException();
            }
            return $result;
        }


    }