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

$hash = $_GET['hash'];

echo $git->show($hash);