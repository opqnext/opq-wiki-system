<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 2016/6/14
 * Time: 15:25
 */


require_once YIN_PATH.'/core/yin/AutoLoad.php';


use core\yin\AutoLoad;
use core\yin\Yin;

//自动载入
spl_autoload_register([new AutoLoad(),'loadprint']);
require_once YIN_PATH.'/core/conf/conf.ini.php';

$Yin = Yin::getInstance();
$Yin->run();

