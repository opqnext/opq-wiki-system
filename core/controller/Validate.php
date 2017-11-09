<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/9
 * Time: 12:26
 */

namespace core\controller;

class Validate extends Filter{

    /**
     *	数据基础验证-是否是Email 验证：xxx@qq.com
     *  Controller中使用方法：$this->controller->is_email($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_email($value) {
        return preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', trim($value));
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
     *	数据基础验证-是否必须填写的参数
     *  Controller中使用方法：$this->controller->is_require($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_require($value) {
        return preg_match('/.+/', trim($value));
    }

    /**
     *	数据基础验证-是否是空字符串
     *  Controller中使用方法：$this->controller->is_empty($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_empty($value) {
        if (empty($value) || $value=="") return true;
        return false;
    }

    /**
     *	数据基础验证-检测数组，数组为空时候也返回FALSH
     *  Controller中使用方法：$this->controller->is_arr($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_arr($value) {
        if (!is_array($value) || empty($value)) return false;
        return true;
    }

    /**
     *	数据基础验证-是否是IP
     *  Controller中使用方法：$this->controller->is_ip($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_ip($value) {
        return preg_match('/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/', trim($value));
    }

    /**
     *	数据基础验证-是否是数字类型
     *  Controller中使用方法：$this->controller->is_number($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_number($value) {
        return preg_match('/^\d{0,}$/', trim($value));
    }

    /**
     *	数据基础验证-是否是身份证
     *  Controller中使用方法：$this->controller->is_card($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_card($value){
        return preg_match("/^(\d{15}|\d{17}[\dx])$/i", $value);
    }

    /**
     *	数据基础验证-是否是电话 验证：0571-xxxxxxxx
     *  Controller中使用方法：$this->controller->is_mobile($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_mobile($value) {
        return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/', trim($value));
    }

    /**
     *	数据基础验证-是否是移动电话 验证：1385810XXXX
     *  Controller中使用方法：$this->controller->is_phone($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_phone($value) {
        return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(13|15)\d{9}$/', trim($value));
    }

    /**
     *	数据基础验证-是否是URL 验证：http://www.easyphp.cc
     *  Controller中使用方法：$this->controller->is_url($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_url($value) {
        return preg_match('/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/', trim($value));
    }

    /**
     *	数据基础验证-是否是邮政编码 验证：311100
     *  Controller中使用方法：$this->controller->is_zip($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_zip($value) {
        return preg_match('/^[1-9]\d{5}$/', trim($value));
    }

    /**
     *	数据基础验证-是否是QQ
     *  Controller中使用方法：$this->controller->is_qq($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_qq($value) {
        return preg_match('/^[1-9]\d{4,12}$/', trim($value));
    }

    /**
     *	数据基础验证-是否是英文字母
     *  Controller中使用方法：$this->controller->is_english($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_english($value) {
        return preg_match('/^[A-Za-z]+$/', trim($value));
    }

    /**
     *	数据基础验证-是否是中文
     *  Controller中使用方法：$this->controller->is_chinese($value)
     * 	@param  string $value 需要验证的值
     *  @return bool
     */
    public function is_chinese($value) {
        return preg_match("/^([\xE4-\xE9][\x80-\xBF][\x80-\xBF])+$/", trim($value));
    }

    /**
     * 检查对象中是否有可调用函数
     *  Controller中使用方法：$this->controller->is_method($object, $method)
     * @param string $object
     * @param string $method
     * @return bool
     */
    public function is_method($object, $method) {
        $method = strtolower ( $method );
        return method_exists($object, $method) && is_callable (array($object, $method));
    }
} 