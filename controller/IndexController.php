<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/6/14
 * Time: 16:00
 */
namespace controller;
use core\controller\Controller;

class IndexController extends Controller{

    public function index(){
        echo "666";
        $this->assign('msg',"赋值");
        $this->display('index/index.html');
    }
} 