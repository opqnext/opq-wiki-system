<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 2015/10/27
 * Time: 10:55
 */
require YIN_PATH."/core/conf/conn.ini.php";

use \core\lib\Config;

$Yin_conf = array();
//取默认的配置信息
$Yin_conf['is_uri'] = $Web_conf['is_uri']?$Web_conf['is_uri']:'path';
$Yin_conf['controller'] = $Web_conf['controller']?$Web_conf['controller']:'Index';
$Yin_conf['action'] = $Web_conf['action']?$Web_conf['action']:'index';
$Yin_conf['db_driver'] = $Web_conf['db_driver']?$Web_conf['db_driver']:'PDO';


Config::set('is_uri',$Yin_conf['is_uri']);
Config::set('controller',$Yin_conf['controller']);
Config::set('action',$Yin_conf['action']);
Config::set('db_driver',$Yin_conf['db_driver']);

if(is_array($Yin)) {
    foreach($Yin as $key=>$val) {
        Config::set($key,$val);
    }
}
