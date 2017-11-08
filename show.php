<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:56
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$hash = strval($_GET['hash']);
//
//echo $hash;
//var_dump($git->tree('master'));

$a = ['oneline', 'short', 'medium', 'full', 'fuller', 'email', 'raw','format'];
foreach ($a as $vv){
    echo $git->show($hash,['format'=>$vv,'abbrev-commit'=>true]);
    echo '-----------------------------------------------------';
}
