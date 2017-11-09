<?php
/**
 * Created by PhpStorm.
 * User: opq.next
 * Date: 2016/6/14
 * Time: 16:00
 */
namespace controller;
use core\controller\Controller;

class IndexController extends Controller{

    public function index(){
        $this->assign('msg',"赋值");
        $this->display('index/index.html');
    }

    public function clone_wiki()
    {
        $c = $this->git->clone('https://github.com/opqnext/opq-wiki.git', './wiki');
        echo 'git clone wiki '.$c;
    }

    public function pull_wiki()
    {
        $res = $this->git->pull();
        echo "git pull wiki ".$res;
    }

    public function wiki()
    {

    }

    public function test(){
        echo json_encode(['ec'=>0]);
    }
} 