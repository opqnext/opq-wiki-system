<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/6
 * Time: 下午4:01
 */


$str= "/data/wiki.opqnext.com/wiki/";
ListDir($str);

function ListDir ($dirname)
{
    $Ld= dir($dirname);
    echo"<ul>";
    while(false !== ($entry= $Ld->read())) {
        $checkdir=$dirname."/".$entry;
        if(is_dir($checkdir)&&!preg_match("[^\.]",$entry)){
            echo"<li><p>".$checkdir."当前<span style='color:#ff00a  
    a'>是</span>目录</p></li>";
            ListDir($checkdir);
        }else{
            echo"<li><p>".$entry."当前不是目录</p></li>";
        }
    }
    $Ld->close();
    echo"</ul>";
}