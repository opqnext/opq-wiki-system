<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/5/20
 * Time: 18:47
 */

namespace core\lib;

class MysqlDB {
    protected static $_instance;
    protected $db;
    protected $res;

    public function __construct($host, $dbName, $user, $pass, $port = 3306)
    {
        $this->connect($host, $dbName, $user, $pass, $port);
    }

    /**
     * For example,
     * $mysql=\biwow\db\MysqlDB::getInstance($_db['MYSQL_MASTER']['DB_HOST'],$_db['MYSQL_MASTER']['DB_NAME'],$_db['MYSQL_MASTER']['DB_USER'],$_db['MYSQL_MASTER']['DB_PWD']);
     *
     * @param $host
     * @param $dbName
     * @param $user
     * @param $pass
     * @param int $port
     * @return MysqlDB
     */
    public static function getInstance($host, $dbName, $user, $pass, $port = 3306)
    {
        if (!self::$_instance instanceof MysqlDB) {
            self::$_instance = new self($host, $dbName, $user, $pass, $port);
        }
        return self::$_instance;
    }

    /**
     * @param $host
     * @param $dbName
     * @param $user
     * @param $pass
     * @param $port
     */
    public function connect($host, $dbName, $user, $pass, $port)
    {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=UTF8";
        $this->db = new \PDO($dsn, $user, $pass);
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function query($sql)
    {
        $res = $this->db->query($sql, \PDO::FETCH_ASSOC);
        $this->getError();
        $this->res = $res;
        return $this->res;
    }

    /**
     * For example,
     * $mysql->query('select * from user limit 1');
     * $rs = $mysql->fetch();
     *
     * @return mixed
     */
    public function fetch()
    {
        return $this->res->fetch();
    }

    /**
     * For example,
     * $mysql->query('select * from user');
     * $rs = $mysql->fetchAll();
     *
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->res->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * For example,
     *$res=$mysql->insert("goods",["goods_name"=>"qiqi","store_id"=>1,"type"=>"1","introduction"=>"1","cate_id"=>1,"cate_name"=>"1","brand"=>"1"]);
     *
     * @param $table
     * @param $array
     * @return mixed
     */
    public function insert($table, $array)
    {
        $sql = "INSERT INTO `{$table}` (`" . implode('`,`', array_keys($array)) . "`) VALUES ('" . implode("','", $array) . "')";
        $result = $this->db->exec($sql);
        $this->getError();
        return $result;
    }

    /**
     * For example,
     *$res=$mysql->update("goods",["goods_name"=>"qiqi"],"store_id=63");
     *
     * @param $table
     * @param $array
     * @param string $where
     * @return mixed
     * @throws \Exception
     */
    public function update($table, $array, $where = '')
    {
        $where = $this->checkWhere($where);

        $sql = '';
        foreach ($array as $key => $value) {
            $sql .= ", `$key`='$value'";
        }
        $sql = substr($sql, 1);
        $sql = "UPDATE `{$table}` SET {$sql} WHERE {$where}";

        $result = $this->db->exec($sql);
        $this->getError();
        return $result;
    }

    /**
     * For example,
     * $res=$mysql->delete("goods",["type"=>"material","store_id"=>61]);
     *
     * @param $table
     * @param string $where
     * @return mixed
     * @throws \Exception
     */
    public function delete($table, $where = '')
    {
        $where = $this->checkWhere($where);

        $sql = "DELETE FROM `{$table}` WHERE {$where}";
        $result = $this->db->exec($sql);
        $this->getError();
        return $result;
    }

    protected function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    protected function commit()
    {
        $this->db->commit();
    }

    protected function rollBack()
    {
        $this->db->rollBack();
    }

    /**
     * For example,
     * $mysql->execTransaction(["delete from `user` where id=14","INSERT INTO `user` (`username`) VALUES('qiqi123')"]);
     * 事务中的sql组可用insert update delete，不可用select
     *
     * @param $sql
     * @return bool
     */
    public function execTransaction($sql)
    {
        $status = 1;
        $this->beginTransaction();
        foreach ($sql as $v) {
            if ($this->execSql($v) == 0) $status = 0;
        }
        if ($status == 0) {
            $this->rollback();
            return false;
        } else {
            $this->commit();
            return true;
        }
    }

    protected function checkWhere($where)
    {
        if ($where == '') {
            $this->outputError("'WHERE' is Null");
        } else {
            if (is_array($where)) {
                $whereStr = "";
                foreach ($where as $k => $v) {
                    $v = is_int($v) ? $v : "'{$v}'";
                    $whereStr .= empty($whereStr) ? $k . "=" . $v : " and " . $k . "=" . $v;
                }
            } else {
                $whereStr = $where;
            }
        }
        return $whereStr;
    }

    /**
     * @param $strSql
     * @param bool|false $debug
     * @return mixed
     */
    public function execSql($sql)
    {
        $result = $this->db->exec($sql);
        $this->getError();
        return $result;
    }

    protected function getError()
    {
        if ($this->db->errorCode() != '00000') {
            $arrayError = $this->db->errorInfo();
            $this->outputError($arrayError[2]);
        }
    }

    protected function outputError($ErrMsg)
    {
        throw new \Exception('MySQL Error: ' . $ErrMsg);
    }
}