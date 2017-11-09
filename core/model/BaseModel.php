<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/11/11
 * Time: 14:10
 */

namespace core\model;
use core\lib\MysqlDB;

class BaseModel
{

    public $db;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->db = MysqlDB::getInstance(HOST, DB_NAME, USER, PASS);
    }

    /**
     * 取得指定的Model
     * @param $value
     * @return mixed
     */
    public static function getModel($value) {
        $class = "\\Model\\".ucfirst($value)."Model";
        $obj = new $class();
        return $obj;
    }

}