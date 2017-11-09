<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/11
 * Time: 11:40
 */

//$Yin_conn = array();
//$Yin_conn['host'] = $Web_conf['host']?$Web_conf['host']:'localhost';

//默认定义框架配置常量
defined("HOST")  or  define("HOST","localhost");         //数据库主机
defined("USER")  or     define("USER","root");              //数据库用户名
defined("PASS")  or     define("PASS","");                  //数据库连接密码
defined("DB_NAME")  or     define("DB_NAME","test");           //数据库名称
defined("DB_PREFIX")  or     define("DB_PREFIX","");        //数据表前缀

defined("DEFAULT_ACTION") or define("DEFAULT_ACTION","index");  //设置默认的action控制器
defined("DEFAULT_METHOD") or define("DEFAULT_METHOD","index");  //设置默认的method方法