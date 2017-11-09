<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/9
 * Time: 13:58
 */

namespace core\yin;

use core\lib\Cookie;
use core\lib\Route;
use core\lib\Config;
use core\lib\Session;


class Yin{

    public $controller;
    public $action;

    //保存类实例的静态成员变量
    private static $_instance;

    //private标记的构造方法
    private function __construct(){
        //echo 'This is a Constructed method;';
    }

    //创建__clone方法防止对象被复制克隆
    public function __clone(){
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    //单例方法,用于访问实例的公共的静态方法
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * 框架核心入口
     */
    public function run(){
        //路由分发功能
        $url = new Route();
        $url->dispatcher();
        $this->checkRequest();
        $class = "\\controller\\".ucfirst($this->controller)."Controller";
        $obj = new $class();
        $action = $this->action;
        $obj->$action();
    }

    /**
     * 检查url有没有访问指定控制器
     * 没有就去默认控制器和方法
     * @date 2015-11-12
     */
    public function checkRequest() {
        $this->controller  = $_GET['c'] ? $_GET['c'] : Config::get('controller');
        $this->action      = $_GET['a'] ? $_GET['a'] : Config::get('action');
    }

    /**
     * 组装URL
     * default：index.php?m=user&c=index&a=run
     * rewrite：/user/index/run/?id=100
     * path: /user/index/run/id/100
     * html: user-index-run.htm?uid=100
     * 全局使用方法：InitPHP::url('user|delete', array('id' => 100))
     * @param String $action m,c,a参数，一般写成 cms|user|add 这样的m|c|a结构
     * @param array $params URL中其它参数
     * @param String $baseUrl 是否有默认URL，如果有，则
     */
    public static function url($action, $params = array(), $baseUrl = '')
    {
        $action = explode("|", $action);
        $baseUrl = ($baseUrl == '') ? rtrim(Config::get('url'), "/") . "/" : $baseUrl;
        switch (Config::get('is_uri')) {

            case 'rewrite' :
                $actionStr = implode('/', $action);
                $paramsStr = '';
                if ($params) {
                    $paramsStr = '?' . http_build_query($params);
                }
                return $baseUrl . $actionStr . $paramsStr;
                break;

            case 'path' :
                $actionStr = implode('/', $action);
                $paramsStr = '';
                if ($params) {
                    foreach ($params as $k => $v) {
                        $paramsStr .= $k . '/' . $v . '/';
                    }
                    $paramsStr = '/' . $paramsStr;
                }
                return $baseUrl . $actionStr . $paramsStr;
                break;

            case 'html' :
                $actionStr = implode('-', $action);
                $actionStr = $actionStr . '.htm';
                $paramsStr = '';
                if ($params) {
                    $paramsStr = '?' . http_build_query($params);
                }
                return $baseUrl . $actionStr . $paramsStr;
                break;

            default:
                $actionStr = '';

                $actionStr .= 'c=' . $action[0];
                $actionStr .= '&a=' . $action[1] . '&';

                $actionStr = '?' . $actionStr;
                $paramsStr = '';
                if ($params) {
                    $paramsStr = http_build_query($params);
                }
                return $baseUrl . $actionStr . $paramsStr;
                break;
        }
    }

    /**
     * 获取session
     * @return Session
     */
    public static function session(){
        return new Session();
    }

    /**
     * 获取cookie
     * @return Cookie
     */
    public static function cookie(){
        return new Cookie();
    }


} 