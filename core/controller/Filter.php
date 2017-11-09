<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/23
 * Time: 10:49
 */

namespace core\controller;


class Filter {

    /**
     * 安全过滤类-获取GET或者POST的参数值，经过过滤
     * 如果不指定$type类型，则获取同名的，POST优先
     * $isfilter 默认开启，强制转换请求的数据
     * 该方法在Controller层中，获取所有GET或者POST数据，都需要走这个接口
     *  Controller中使用方法：$this->controller->get_gp($value, $type = null,  $isfilter = true)
     * @param  string|array $value 参数
     * @param  string|array $type 获取GET或者POST参数，P - POST ， G - GET, U - PUT , D -DE
     * @param  bool         $isfilter 变量是否过滤
     * @return string|array
     */
    public function get_gp($value, $type = null,  $isfilter = false) {
        if ($type == 'U' || $type == 'D') {
            parse_str(file_get_contents('php://input'), $requestData);
        }
        if (!is_array($value)) {
            if ($type === null) {
                if (isset($_GET[$value])) $temp = $_GET[$value];
                if (isset($_POST[$value])) $temp = $_POST[$value];
            } elseif ($type == 'U' || $type == 'D') { //PUT 和 DEL
                $temp = $requestData[$value];
            } else {
                $temp = (strtoupper($type) == 'G') ? $_GET[$value] : $_POST[$value];
            }
            $temp = ($isfilter === true) ? $this->filter_escape($temp) : $temp;
            return $temp;
        } else {
            $temp = array();
            foreach ($value as $val) {
                if ($type === null) {
                    if (isset($_GET[$val])) $temp[$val] = $_GET[$val];
                    if (isset($_POST[$val])) $temp[$val] = $_POST[$val];
                } elseif ($type == 'U' || $type == 'D') {
                    $temp[$val] = $requestData[$val];
                } else {
                    $temp[$val] = (strtoupper($type) == 'G') ? $_GET[$val] : $_POST[$val];
                }
                $temp[$val] = ($isfilter === true) ? $this->filter_escape($temp[$val]) : $temp[$val];
            }
            return $temp;
        }
    }

    /**
     * 安全过滤类-通用数据过滤
     *  Controller中使用方法：$this->controller->filter_escape($value)
     * @param string $value 需要过滤的变量
     * @return string|array
     */
    public function filter_escape($value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::filter_str($v);
            }
        } else {
            $value = self::filter_str($value);
        }
        return $value;
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
} 