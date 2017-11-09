<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午2:14
 */

shell_exec("git pull origin master");

error_log('git pull '.date('Y-m-d H:i:s'));