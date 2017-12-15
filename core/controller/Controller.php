<?php
/**
 * 框架Controller基类
 * Created by PhpStorm.
 * User: lz
 * Date: 2015/11/9
 * Time: 11:49
 */
namespace core\controller;

use core\view\Template;
use HyperDown\Parser;
use model\InstanceModel;
use PHPGit\Git;

class Controller extends Validate{

    protected $temp;
    protected $git;
    protected $model;
    protected $parser;

    /**
     * 构造函数
     */
    public function __construct() {
        $this->temp = Template::getInstance();
        $this->git = new Git();
        $this->git->setRepository('./wiki');
        $this->model = new InstanceModel();
        $this->parser = new Parser();   //markdown
    }

    /**
     * 控制器 重定向
     * @param string  $url   跳转的URL路径
     * @param int     $time  多少秒后跳转
     */
    public function redirect($url, $time = 0) {
        if (!headers_sent()) {
            if ($time === 0) header("Location: ".$url);
            header("refresh:" . $time . ";url=" .$url. "");
        } else {
            exit("<meta http-equiv='Refresh' content='" . $time . ";URL=" .$url. "'>");
        }
    }

    /**
     * 获取参数 如果是GET $type == 'G'
     * @param $value
     * @param $type
     * @return string
     */
    public function getParams($value,$type) {
        if($type == 'G') {
            return $this->filter_str($_GET[$value]);
        } elseif($type == 'P') {
            return $this->filter_str($_POST[$value]);
        }
    }

    /**
     * 安全过滤类-字符串过滤 过滤特殊有危害字符
     *  Controller中使用方法：$this->controller->filter_str($value)
     * @param  string $value 需要过滤的值
     * @return string
     */
    public function filter_str($value) {
        $value = str_replace(array("\0","%00","\r"), '', $value);
        $value = preg_replace(array('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/','/&(?!(#[0-9]+|[a-z]+);)/is'), array('', '&amp;'), $value);
        $value = str_replace(array("%3C",'<'), '&lt;', $value);
        $value = str_replace(array("%3E",'>'), '&gt;', $value);
        $value = str_replace(array('"',"'","\t",'  '), array('&quot;','&#39;','    ','&nbsp;&nbsp;'), $value);
        return $value;
    }

    /**
     * 模板赋值
     * @param $key
     * @param null $value
     */
    public function assign($key,$value=null) {
        $temp = Template::getInstance();
        $temp->assign($key,$value);
        //$this->view->assign($key,$value);
        //var_dump($this->temp->view);
    }

    /**
     * 输出模板
     * @param $filename
     */
    public function display($filename) {
        $temp = Template::getInstance();
        $temp->display($filename);
        //$this->view->display($filename);
    }

    /**
     * 获取Excel类
     * @return ExcelInit
     */
    public function getExcel(){
        return new ExcelInit();
    }

    /**
     * @param $count
     * @param $size
     * @param $url
     * @return string
     */
    public function getPager($count,$size,$url){
        $pager = new Pager();
        return $pager->pager($count,$size,$url);
    }

    public function error($msg){
        echo $msg;exit;
    }

} 