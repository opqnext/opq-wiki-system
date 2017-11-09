<?php
/**
 * 自动加载类
 * Created by PhpStorm.
 * User: lz
 * Date: 2015/11/2
 * Time: 17:30
 */

namespace core\yin;
use \controller;

class AutoLoad {
    public static function loadprint($class) {

        $file = YIN_PATH."/".$class.'.php';
        //echo "Linux需要转义斜杠";
        $file = str_replace('\\','/',$file);
        if (is_file($file)) {
            include($file);
        }
    }

}


