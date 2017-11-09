<?php
/**
 * 配置文件
 * User: lz
 * Date: 2015/11/12
 * Time: 11:04
 */

namespace core\lib;

class Config {
    public static  $_conf = array();
    public static function set($name, $object) {
        self::$_conf[$name] = $object;
    }
    public static function get($name) {
        return self::$_conf[$name];
    }

} 