<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:09
 */

echo time();

echo '/wiki/'.$_GET['id'].'.html';

include '/wiki/'.$_GET['id'].'.html';