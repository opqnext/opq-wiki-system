<?php
/**
 * Created by PhpStorm.
 * User: opq.next
 * Date: 2016/6/14
 * Time: 16:00
 */
namespace controller;
use core\controller\Controller;
use PHPGit\Git;

class IndexController extends Controller{

    public function index(){
        $this->assign('msg',"赋值");
        $this->display('index/index.html');
    }

    public function clone_wiki()
    {
        $git = new Git();

        var_dump($git);
        $c = $git->clone('https://github.com/opqnext/opq-wiki.git', './wiki');
        var_dump($c);
    }
} 