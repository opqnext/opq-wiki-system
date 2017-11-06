<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/6
 * Time: 下午4:01
 */


$str= "/data/wiki.opqnext.com/wiki/";
function listDir($dir)
{
    if(is_dir($dir))
    {
        if ($dh = opendir($dir))
        {
            while (($file = readdir($dh)) !== false)
            {
                if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
                {
                    echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
                    listDir($dir."/".$file."/");
                }
                else
                {
                    if($file!="." && $file!="..")
                    {
                        echo $file."<br>";
                    }
                }
            }
            closedir($dh);
        }
    }
}
//开始运行
listDir($str);