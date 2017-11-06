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
            echo"<li><p>".$checkdir."</p></li>";
            ListDir($checkdir);
        }else{
            if($entry != '.' && $entry != '..'){
                echo"<li><p><a href='#' >".$entry."</a></p></li>";
            }
        }
    }
    $Ld->close();
    echo"</ul>";
}