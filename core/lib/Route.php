<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/9
 * Time: 20:04
 */
namespace core\lib;

class Route {

    /**
     * 路由分发-路由分发核心函数
     * 1. 判断是否开启分发
     * 2. 获取request信息
     * 3. 解析URI
     */
    public function dispatcher() {
        switch (Config::get('is_uri')) {
            case 'path' :
                $this->parsePathUri();
                break;
            case 'rewrite' :
                $this->parseRewriteUri();
                break;
            case 'html' :
                $this->parseHtmlUri();
                break;
            default :
                return false;
                break;
        }
        return true;
    }

    /**
     * 解析Path Uri
     * 1. 解析index.php/user/new/username
     * 2. 解析成数组，array()
     * @return array|bool
     */
    private function parsePathUri() {
        $request = $_SERVER['REQUEST_URI'];
        //echo '--------path-----------';
        $request = trim($request, '/');
        if (!$request) {
            return false;
        }
        $info = explode('/', $request);
        if (!is_array($info) || count($info) == 0) {
            return false;
        }

        $_GET['c'] = $info[0] ? $info[0] : '';
        $_GET['a'] = $info[1] ? $info[1] : '';
        unset($info[0],$info[1]);

        //如果数组中的参数大于1，说明除了m,c,a参数外还有其它参数
        if (count($info) > 1) {
            $mark = 0;
            $val = $key = array();
            foreach($info as $value) {
                $mark++;
                if ($mark % 2 == 0) {
                    $val[] = $value;
                } else {
                    $key[] = $value;
                }
            }
            if(count($key) !== count($val)) {
                $val[] = null;
            }
            $get = array_combine($key,$val);
            //循环重组数据
            foreach($get as $key=>$value) {
                $_GET[$key] = $value;
            }
        }
        return $info;
    }

    /**
     * 解析rewrite方式的路由
     * 1. 解析/user/new/username/?id=100
     * 2. 解析成数组，array()
     */
    private function parseRewriteUri() {
        //echo '---------write----------';
        $request = $_SERVER['REQUEST_URI'];
        $request = trim($request, '/');
        if (!$request) {
            return false;
        }
        $info = explode('/?', $request);
        if (!$info[0] || !$info[1]) {
            return false;
        }
        $tmp = explode('/', $info[0]);

        $_GET['c'] = $tmp[0] ? $tmp[0] : '';
        $_GET['a'] = $tmp[1] ? $tmp[1] : '';

        return $tmp;
    }

    /**
     * 解析html方式的路由
     * 1. 解析member-user-add.htm?uid=100
     * 2. 解析成数组，array()
     * @return array|bool
     * @author jyx
     * @date 2015/10/29
     */
    private function parseHtmlUri() {
        //echo '--------html-----------';
        $request = $_SERVER['REQUEST_URI'];
        $request = trim($request, '/');
        $request = str_replace('.htm', '', $request);
        if (!$request) {
            return false;
        }
        $tmp = explode('?', $request);
        $info = explode('-', $tmp);
        if (!is_array($info) || count($info) == 0) {
            return false;
        }

        $_GET['c'] = $info[0] ? $info[0] : '';
        $_GET['a'] = $info[1] ? $info[1] : '';

        return $info;
    }


} 