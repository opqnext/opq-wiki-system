<?php
/**
 *
 */

namespace core\model;
use Medoo\Medoo;


class BaseModel
{

    protected $db = 'db';
    //public $InstanceModel;

    /**
     * 构造函数
     */
    public function __construct()
    {
        //$this->db = MysqlDB::getInstance(HOST, DB_NAME, USER, PASS);
        $this->db = new Medoo([
            'database_type' => 'mysql',
            'database_name' => DB_NAME,
            'server' => HOST,
            'username' => USER,
            'password' => PASS
        ]);
    }

}