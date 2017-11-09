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

/** 常量设置 */
//RPC搜索
define(RPC,"http://vpn-rpc.herxi.com/search/goods/Hgt3Tr7UfM");


//默认定义框架配置常量
define(HOST,"115.159.53.240");          //数据库主机
define(USER,"root");                    //数据库用户名
define(PASS,"V9YjN9AkxEjX");               //数据库连接密码
define(DB_NAME,"herxi_test");           //数据库名称
define(DB_PREFIX,"herxi_");             //数据表前缀

//默认定义框架配置常量
define(MBHOST,"115.159.53.240");            //芒果主机
define(MOUSER,"access");                    //芒果用户名
define(MPASS,"access2015");                 //芒果密码
define(MNAME,"access_log");                 //芒果数据库库名称

/*define(HOST,"115.159.45.122");          //数据库主机
define(USER,"root");                    //数据库用户名
define(PASS,"her2015xi");               //数据库连接密码
define(DB_NAME,"www.herxi.com");           //数据库名称
define(DB_PREFIX,"herxi_");             //数据表前缀*/

/*define(HOST,"10.105.58.249");          //数据库主机
define(USER,"root");                    //数据库用户名
define(PASS,"herxi2016");               //数据库连接密码
define(DB_NAME,"hotel");           //数据库名称
define(DB_PREFIX,"herxi_");             //数据表前缀*/

