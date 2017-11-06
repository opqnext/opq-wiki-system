<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/6
 * Time: 下午2:51
 */

date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

$git = new PHPGit\Git();
var_dump($git);
exit;
$c = $git->clone('https://github.com/opqnext/opq-wiki.git', '/path/to/repo');
//var_dump($c);