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

//$hash = strval($_GET['hash']);
//
//echo $hash;
//var_dump($git->tree('master'));

$c = $git->show('ea923f390f6dbf0caf041239379b62e2f4e4518c');