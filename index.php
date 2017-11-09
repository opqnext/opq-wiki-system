<?php
/**
 * Yin框架——入口文件
 * Created by PhpStorm.
 * User: lz
 * Date: 2016/6/14
 * Time: 15:00
 */

header("Content-type: text/html; charset=utf-8");

//报告运行时错误
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set("Asia/Shanghai");

define("YIN_PATH", dirname(__FILE__)); //项目根目录
define("WEB_URL","http://".$_SERVER['SERVER_NAME']);  //项目当前域名

require 'vendor/autoload.php';

define("DEBUG",true);  //是否开启调试模式

if(DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

/**
 * 是否是命令行运行
 */
$isCli = php_sapi_name() ==='cli';
if($isCli) {
    $_SERVER['REQUEST_URI'] = "/".$argv[1]."/".$argv[2];
}

require_once YIN_PATH . '/conf/conf.php'; //引入配置文件
require_once YIN_PATH . '/core/init.php'; //引入核心文件

//错误调试
if($_GET['debug']=="herxi"){
    require_once YIN_PATH . '/core/lib/ErrorHandle.php';
    $error=\core\lib\ErrorHandle::getInstance(true);
}
/**
 * 获取\model\InstanceModel
 * @return \model\InstanceModel
 */
function M(){
    return new \model\InstanceModel();
}























?>

