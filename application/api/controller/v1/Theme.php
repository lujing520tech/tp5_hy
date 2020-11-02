<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/2
 * Time: 15:27
 */

namespace app\api\controller\v1;
use app\api\model\Theme as ThemeModel;

class Theme
{
    public function getTheme()
    {
        $result = (new ThemeModel)->byTheme();
        return $result;
    }
}