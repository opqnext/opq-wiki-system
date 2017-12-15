<?php
/**
 * opq-wiki
 * @author opq.next
 * @date  2017/11/10
 */
namespace controller;
use core\controller\Controller;
use Overtrue\Pinyin\Pinyin;

class IndexController extends Controller{

    public function index(){
        $wiki = $this->model->index->getWiki();
//        print_r($wiki);
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

    public function wiki($id)
    {
        $wiki = $this->model->index->getWiki();
        $this->assign('wiki',$wiki);
        // html内容
        $md = file_get_contents('./wiki/'.$id.'.md');
        $this->assign('html',$this->parser->makeHtml($md));
        // 历史版本
        $log = $this->git->log($id.'.html',['limit'=>5]);
        $this->assign('log',$log);
        $this->assign('id',$id);
        $this->display('index/wiki.html');
    }

    public function add($is_dir)
    {
        //echo $is_dir;
        $this->display('index/add.html');
    }

    public function edit($id){
        $md = file_get_contents('./wiki/'.$id.'.md');
        $this->assign('markdown',$md);
        $this->assign('html',$this->parser->makeHtml($md));
        $this->display('index/add.html');
    }

    public function ajax_new_wiki()
    {
        $markdown = $this->getParams('markdownText','P');
        $title = $this->getParams('markdownTitle','P');
        //$html = $this->getParams('html','P');
        $pingyin = new Pinyin();
        $file_name = $pingyin->permalink($title);

        $data = [
            'id'=>time(),
            'name'=>$title,
            'uid'=>0,
            'is_dir'=>0,
            'pid'=>0,
            'create_time'=>time(),
            'file_name'=>$file_name
        ];
        $res = $this->model->index->insertWiki($data);

        $md_file = $file_name.'.md';
        //$html_file = '11.html';
        $markdown_res = file_put_contents('./wiki/'.$md_file,html_entity_decode($markdown));
        //$html_res = file_put_contents('./wiki/'.$html_file,html_entity_decode($html));
        var_dump($markdown_res);
        //var_dump($html_res);
        //$add = $this->git->add($html_file);
        $add = $this->git->add($md_file);
        var_dump($add);
        $commit = $this->git->commit('添加'.$title);
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

    public function diff($hash)
    {
        $diff =  $this->git->show($hash,['format'=>'oneline','abbrev-commit'=>true]);
        $this->assign('diff',str_replace("\n", '\n',$diff));
        $this->display('index/diff.html');
    }


    public function test(){
        echo json_encode(['ec'=>0]);
    }
} 