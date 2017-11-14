<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/10/27
 * Time: 10:36
 */

$Web_conf = array();

/** 配置文件 */
$Web_conf['url'] = "http://{$_SERVER['HTTP_HOST']}";
$Web_conf['is_uri'] = "default";
/** 数据库驱动 可以选择 PDO 和 Mysqli 两种方式*/
$Web_conf['db_driver'] = "PDO";
$Yin = array();
$Yin['is_cache'] = false;   //是否开启缓存 true为开启 false为不开启


//默认定义框架配置常量
define(HOST,"123.206.221.110");         //数据库主机
define(USER,"root");                    //数据库用户名
define(PASS,"shayu1234");               //数据库连接密码
define(DB_NAME,"opq_wiki");             //数据库名称


