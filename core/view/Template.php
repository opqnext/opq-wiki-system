<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/13
 * Time: 10:53
 */

namespace core\view;

use core\lib\Config;

class Template {


    //指定模板目录
    private $template_dir;

    //编译后的目录
    private $compile_dir;

    private $template_tag_left;
    private $template_tag_right;

    //保存类实例的静态成员变量
    private static $_instance;

    //读取模板中所有变量的数组
    public $view=array();

    //构造方法
    public function __construct() {
        $this->template_tag_left = "<!--{";
        $this->template_tag_right = "}-->";
        $this->template_dir= YIN_PATH."/view/";
        $this->compile_dir = YIN_PATH."/cache/templates_c/";
    }

    //创建__clone方法防止对象被复制克隆
    public function __clone(){
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    //单例方法,用于访问实例的公共的静态方法
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    //模板中变量分配调用的方法
    public function assign($tpl_var,$value=null) {
        $this->view[$tpl_var]=$value;
    }

    public function tmp_compile($fileName){
        $tplFile=$this->template_dir.$fileName;
        if(!is_dir($this->compile_dir)){
            echo "【Yin 错误信息：<span style='color: red'>目录 $this->compile_dir 不存在</span>】";exit;
        }
        if(!file_exists($tplFile)){
            echo "【Yin 错误信息：<span style='color: red'>模板 $tplFile 不存在</span>】";exit;
        }

        //定义编译合成的文件 加了前缀 和路径 和后缀名.php
        $comFileName=$this->compile_dir."com_".$fileName.".php";
        //创建文件夹
        $path = substr($comFileName,0,strrpos($comFileName,'/'));
        @mkdir($path,0777,true);

        if(!file_exists($comFileName) || filemtime($comFileName) < filemtime($tplFile) || !Config::get('is_cache')){//如果缓存文件不存在则 编译 或者文件修改了也编译
            $repContent=$this->tmp_replace(file_get_contents($tplFile));//得到模板文件 并替换占位符 并得到替换后的文件
            file_put_contents($comFileName,$repContent);//将替换后的文件写入定义的缓存文件中
        }
        return $comFileName;
    }

    //调用模板显示
    public function display($fileName) {
        $comFileName = $this->tmp_compile($fileName);
        foreach($this->view as $key=>$val){
            $$key = $val;
        }
        //包含编译后的文件
        //$name ='我是通过模赋值到模板里的';
        include $comFileName;
       // var_dump($this->view);

    }

    //替换模板中的占位符
    private function tmp_replace($content){

        $content = $this->layout($content); //layout模板页面中加载模板页
        $repContent = $this->init($content,$this->template_tag_left,$this->template_tag_right);

        return $repContent;

    }

    /**
     * 模板驱动-简单的驱动
     * @param  string $str 模板文件数据
     * @return string
     */
    public function init($str, $left, $right) {

        //if操作
        $str = preg_replace( "/".$left."if([^{]+?)".$right."/", "<?php if \\1 { ?>", $str );
        $str = preg_replace( "/".$left."else".$right."/", "<?php } else { ?>", $str );
        $str = preg_replace( "/".$left."elseif([^{]+?)".$right."/", "<?php } elseif \\1 { ?>", $str );
        //foreach操作
        $str = preg_replace("/".$left."foreach([^{]+?)".$right."/","<?php foreach \\1 { ?>",$str);
        $str = preg_replace("/".$left."\/foreach".$right."/","<?php } ?>",$str);
        //for操作
        $str = preg_replace("/".$left."for([^{]+?)".$right."/","<?php for \\1 { ?>",$str);
        $str = preg_replace("/".$left."\/for".$right."/","<?php } ?>",$str);
        //输出变量
        $str = preg_replace( "/".$left."(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\'\"]*)".$right."/", "<?php echo \\1;?>", $str );
        //常量输出
        $str = preg_replace( "/".$left."([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)".$right."/s", "<?php echo \\1;?>", $str );
        //标签解析
        $str = preg_replace ( "/".$left."\/if".$right."/", "<?php } ?>", $str );
        $pattern = array('/'.$left.'/', '/'.$right.'/');
        $replacement = array('<?php ', ' ?>');
        return preg_replace($pattern, $replacement, $str);
    }

    /**
     * 模板编译-layout 模板layout加载机制
     * 1. 在HTML模板中直接使用<!--{layout:user/version}-->就可以调用模板
     * @param  string $str 模板文件数据
     * @return string
     */
    private function layout($str) {
        preg_match_all("/(".$this->template_tag_left."layout:)(.*)(".$this->template_tag_right.")/", $str, $matches);

        $matches[2] = array_unique($matches[2]); //重复值移除
        $matches[0] = array_unique($matches[0]);
        //foreach ($matches[2] as $val) $this->tmp_replace($val);
        foreach ($matches[2] as $val) {
            $this->tmp_compile($val);
        }
        foreach ($matches[0] as $k => $v) {
            $str = str_replace($v, $this->layout_path($matches[2][$k]), $str);
        }
        return $str;
    }

    /**
     * 模板编译-layout路径
     * @param  string $template_name 模板名称
     * @return string
     */
    private function layout_path($template_name) {
        //echo $this->compile_dir.$template_name;
        //exit;
        return "<?php include('".$this->compile_dir."com_".$template_name.".php'); ?>";
    }
}

