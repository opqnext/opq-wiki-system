<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:09
 */
date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';
echo '<style>a{text-decoration:none;color: cornflowerblue}</style>';
echo time();
echo "<br>";

//echo './wiki/'.$_GET['id'].'.html';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$log = $git->log($_GET['id'].'.html',['limit'=>5]);
echo "<pre>";

echo '--版本历史(仅显示最近5次修订版本)--';
$log_html = '<div style="font-size: 12px;color: darkorange">';
foreach ($log as $val){
    $log_html .='<p><a href="/show.php?hash='.$val['hash'].'" >'.$val['hash'].'</a> | name:'.$val['name'].' | date:'.$val['date'].' | title:'.$val['title'].'</p>';
}
$log_html .= '</div>';

echo $log_html;

echo '--文件内容--';

include './wiki/'.$_GET['id'].'.html';// mikoa.com

echo "----";