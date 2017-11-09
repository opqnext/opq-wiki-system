<?php
/**
 * 框架Controller基类
 * Created by PhpStorm.
 * User: lz
 * Date: 2015/11/9
 * Time: 11:49
 */
namespace core\controller;

use core\lib\Curl;
use core\lib\Excel;
use Core\Lib\ExcelInit;
use core\lib\IdCard;
use Core\lib\Pager;
use core\lib\Uuid;
use Core\Mongo\MongoDB;
use Core\Push\Push;
use Core\Redis\RedisDB;
use core\view\Template;
use Core\View\viewInit;
use Core\Xsearch\XS;
use Core\Xsearch\XSearch;
use Core\Lib\SmsSend;
use Core\Model\BaseModel;
use PHPGit\Git;

class Controller extends Validate{

    protected $temp;
    protected $git;

    /**
     * 构造函数
     */
    public function __construct() {
        $this->temp = Template::getInstance();
        $this->git = new Git();
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
     * 获取讯搜接口类
     * @return XSearch
     */
    public function getLibrary(){
        $xs = new XS('herxi');
        return XSearch::getInstance($xs);
    }

    /**
     * 获取发短信接口
     * @return SmsSend
     */
    public function getSms(){
        return new SmsSend();
    }

    /**
     * 获取Excel类
     * @return ExcelInit
     */
    public function getExcel(){
        return new ExcelInit();
    }

    /**
     * @param $model
     * @return \Model\MemberModel
     */
    public function model($model){
        $class = "\\Model\\".ucfirst($model)."Model";
        $obj = new $class();
        return $obj;
    }

    /**
     * 获取推送接口类
     */
    public function getPush(){
        //return new Push();
    }

    public function getMongoDB(){
        return new MongoDB(MBHOST, MNAME, MOUSER, MPASS);
    }

    public function getRedisDB(){
        return new RedisDB('10.66.123.5','crs-77hndx96:Rnf1qW3H');
    }

    /**
     * 获取uuid
     * @return mixed
     */
    public function getUuid(){
        $uuid = new Uuid();
        return $uuid->uuid();
    }

    /**
     * 获取星座
     * @return mixed
     */
    public function getConstellation($month, $day){
        $uuid = new Uuid();
        return $uuid->getConstellation($month, $day);
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


    /**
     * curl获取内容
     * @param $url
     * @return mixed
     */
    public function getCurlContent($url){
        $curl = new Curl();
        return $curl->getCurlContent($url);
    }
    /** 获取身份证号出生地 */
    public function ClassIdCard($code){
        $card = new IdCard('5bb4fd173720da1a753a84db814c261e',$code);
        return $card->getCardInfo();
    }

    public function error($msg){
        echo $msg;exit;
    }

} 