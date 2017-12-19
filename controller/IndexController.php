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
        $wiki = $this->model->index->getLastWiki(0);
        $nav = $this->model->index->getNavigation();
//        print_r($wiki);
        $this->assign('wiki',$wiki);
        $this->assign('nav',$nav);
        $this->display('index/index.html');
    }

    public function clone_wiki()
    {
        $c = $this->git->clone('https://gitee.com/opqnext/opqnext-wiki.git', './wiki');
        echo 'git clone wiki '.$c;
    }

    public function pull_wiki()
    {
        $res = $this->git->pull();
        echo "git pull wiki ".$res;
    }

    public function wiki($pid,$id)
    {
        $this->assign('pid',$pid);
        $pid_list = $this->model->index->getPidWiki($pid);
        $this->assign('pid_list',$pid_list);

        $wiki = $this->model->index->getWiki($id);
        $this->assign('wiki',$wiki);

        $cate = $this->model->index->category($id);
        $this->assign('cate',$cate);
        // html内容
        $md = file_get_contents('./wiki/'.$wiki['file_name'].'.md');
        $this->assign('html',$this->parser->makeHtml($md));
        // 历史版本
        $log = $this->git->log($wiki['file_name'].'.md',['limit'=>5]);

        // 格式化log
        $log = $this->model->index->log($log);

        $this->assign('log',$log);
        $this->assign('id',$id);
        $this->display('index/wiki.html');
    }

    public function add($is_dir,$pid)
    {
        $this->assign('is_dir',$is_dir);
        $this->assign('pid',$pid);
        $this->display('index/add.html');
    }

    public function edit($pid,$id){
        $wiki = $this->model->index->getWiki($id);
        $md = file_get_contents('./wiki/'.$wiki['file_name'].'.md');
        $this->assign('wiki',$wiki);
        $this->assign('markdown',$md);
        $this->assign('html',$this->parser->makeHtml($md));
        $this->display('index/edit.html');
    }

    public function ajax_new_wiki()
    {
        $markdown = $this->getParams('markdownText','P');
        $title = $this->getParams('markdownTitle','P');
        $is_dir = $this->getParams('is_dir','P');
        $pid = $this->getParams('pid','P');
        //$html = $this->getParams('html','P');
        $pingyin = new Pinyin();
        $file_name = $pingyin->permalink($title);

        $data = [
            'name'=>$title,
            'uid'=>0,
            'is_dir'=>$is_dir,
            'pid'=>$pid,
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
        //$add = $this->git->add($html_file)`;
        $add = $this->git->add($md_file);
        var_dump($add);
        $message = ['msg'=>'添加'.$title,'name'=>'zhang.san'];
        $commit = $this->git->commit(json_encode($message));
        var_dump($commit);
        $push = $this->git->push();
        var_dump($push);
    }

    public function ajax_edit_wiki()
    {
        $markdown = $this->getParams('markdownText','P');
        $file_name = $this->getParams('file_name','P');
        $msg = $this->getParams('msg','P');
        $md_file = $file_name.'.md';
        //$html_file = '11.html';
        $markdown_res = file_put_contents('./wiki/'.$md_file,html_entity_decode($markdown));
        //$html_res = file_put_contents('./wiki/'.$html_file,html_entity_decode($html));
        var_dump($markdown_res);
        //var_dump($html_res);
        //$add = $this->git->add($html_file);
        $add = $this->git->add($md_file);
        var_dump($add);
        $message = ['msg'=>$msg,'name'=>'ren.kaiming'];
        $commit = $this->git->commit(json_encode($message));
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

    public function navigation()
    {
        $this->assign('is_dir',3);
        $this->assign('pid',0);
        $this->display('index/add.html');
    }
} 