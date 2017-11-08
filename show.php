<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:56
 */

date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$hash = strval($_GET['hash']);

echo $hash;
//var_dump($git->tree('master'));

$c = $git->show('2ee3e2f22e5d8463944689662c3447c1ce0d1f32');
var_dump($c);