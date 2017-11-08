<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:09
 */

echo time();
echo "<br>";

//echo './wiki/'.$_GET['id'].'.html';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$shortlog = $git->shortlog->summary();

echo "<pre>";
print_r($shortlog);

include './wiki/'.$_GET['id'].'.html';