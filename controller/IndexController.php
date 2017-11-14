<?php
/**
 * opq-wiki
 * @author opq.next
 * @date  2017/11/10
 */
namespace controller;
use core\controller\Controller;

class IndexController extends Controller{

    public function index(){
        $wiki = $this->model->index->getWiki();
        //print_r($wiki);
        $this->assign('wiki',$wiki);
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

    public function wiki($num)
    {
        $wiki = $this->model->index->getWiki();
        $this->assign('wiki',$wiki);
        // html内容
        $this->assign('html',file_get_contents('./wiki/'.$num.'.html'));
        // 历史版本
        $log = $this->git->log($num.'.html',['limit'=>5]);
        $this->assign('log',$log);
        $this->display('index/wiki.html');
    }

    public function add($is_dir)
    {
        //echo $is_dir;
        $this->display('index/add.html');
    }

    public function ajax_new_wiki()
    {
        $markdown = $this->getParams('markdownText','P');
        $html = $this->getParams('html','P');
        $md_file = '10.md';
        $html_file = '10.html';
        $markdown_res = file_put_contents('./wiki/'.$md_file,$markdown);
        $html_res = file_put_contents('./wiki/'.$html_file,html_entity_decode($html));
        var_dump($markdown_res);
        var_dump($html_res);
        $add = $this->git->add($html_file);
        $add = $this->git->add($md_file);
        var_dump($add);
        $commit = $this->git->commit('添加10.html文件');
        var_dump($commit);
        $push = $this->git->push();
        var_dump($push);
    }

    public function commit()
    {
        $commit = $this->git->commit('添加9.html文件');
        var_dump($commit);
        $push = $this->git->push();
        var_dump($push);
    }


    public function test(){
        echo json_encode(['ec'=>0]);
    }
} 