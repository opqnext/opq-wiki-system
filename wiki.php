<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/6
 * Time: 下午4:01
 */

date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

// 数据库
$db = new \Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'opq_wiki',
    'server' => '123.206.221.110',
    'username' => 'root',
    'password' => 'shayu1234'
]);

$res = $db->select('opq_wiki_content','',['id','name','uid','is_dir'],['pid'=>0]);
echo "<pre>";
print_r($res);