<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/6
 * Time: 下午2:51
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

$git = new \PHPGit\Git();

//var_dump($git);
$c = $git->clone('https://github.com/opqnext/opq-wiki.git', '/data/wiki.opqnext.com/wiki');
var_dump($c);
//$git->setRepository('/data/wiki.opqnext.com/wiki');
//$res = $git->pull();
echo "git pull ".$res;