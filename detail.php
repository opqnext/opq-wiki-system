<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:09
 */
date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';
echo time();
echo "<br>";

//echo './wiki/'.$_GET['id'].'.html';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$log = $git->log($_GET['id'].'.html',['limit'=>2]);

echo "<pre>";
print_r($log);

include './wiki/'.$_GET['id'].'.html';

echo "----";