<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/5/6
 * Time: 15:53
 */

namespace core\lib;
class Cookie {
    private $prefix = "yin_"; //cookie前缀
    private $expire = 2592000; //cookie时间
    private $path   = '/'; //cookie路径
    private $domain = '';

    /**
     * 设置cookie的值
     * @param  string $name    cookie的名称
     * @param  string $val     cookie值
     * @param  string $expire  cookie失效时间
     * @param  string $path    cookie路径
     * @param  string $domain  cookie作用的主机
     * @return string
     */
    public function set($name, $val, $expire = '', $path = '', $domain = '') {
        $expire = (empty($expire)) ? time() + $this->expire : $expire; //cookie时间
        $path   = (empty($path)) ? $this->path : $path; //cookie路径
        $domain = (empty($domain)) ? $this->domain : $domain; //主机名称
        if (empty($domain)) {
            setcookie($this->prefix.$name, $val, $expire, $path);
        } else {
            setcookie($this->prefix.$name, $val, $expire, $path, $domain);
        }
        $_COOKIE[$this->prefix.$name] = $val;
    }

    /**
     * 获取cookie的值
     * @param  string $name    cookie的名称
     * @return string
     */
    public function get($name) {
        return $_COOKIE[$this->prefix.$name];
    }

    /**
     * 删除cookie值
     * 使用方法：$this->getUtil('cookie')->del($name)
     * @param  string $name    cookie的名称
     * @param  string $path    cookie路径
     * @return string
     */
    public function del($name, $path = '') {
        $this->set($name, '', time() - 3600, $path);
        $_COOKIE[$this->prefix.$name] = '';
        unset($_COOKIE[$this->prefix.$name]);
    }

    /**
     * 检查cookie是否存在
     * @param  string $name    cookie的名称
     * @return string
     */
    public function is_set($name) {
        return isset($_COOKIE[$this->prefix.$name]);
    }
} 