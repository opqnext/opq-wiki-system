<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午2:14
 */
echo '<pre>';

shell_exec("git pull");

error_log('git pull '.date('Y-m-d H:i:s'));