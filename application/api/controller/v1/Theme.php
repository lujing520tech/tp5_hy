<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 15:27
 */

namespace app\api\controller\v1;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IsIdInt;
use app\lib\exception\ThemeMissException;

class Theme
{
    /**
     * @return ThemeModel[]|false
     * @throws ThemeMissException
     *
     */
    public function getTheme()
    {
        $result = (new ThemeModel)->byTheme();
        if(!$result){
            throw new ThemeMissException();
        }
        return $result;
    }
    /**
     * @param $id
     * @url theme/:id
     */
    public function getThemeGoods($id)
    {
        (new IsIdInt)->goCheck();
        $result = (new ThemeModel)->byThemeGoods($id);
        if(!$result){
            throw new ThemeMissException();
        }
        return $result;
    }
}