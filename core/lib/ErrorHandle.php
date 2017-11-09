<?php
namespace core\lib;
class ErrorHandle
{
    public $debug;
    protected static $_instance;
    public $storage = null;
    public $table = null;
    protected $errorLevel = array(
        E_ERROR => 'E_ERROR',                            // 致命的运行时错误
        E_WARNING => 'E_WARNING',                        // 运行时警告 (非致命错误)
        E_PARSE => 'E_PARSE',                            // 编译时语法解析错误
        E_NOTICE => 'E_NOTICE',                        // 运行时通知
        E_CORE_ERROR => 'E_CORE_ERROR',                    // PHP初始化启动过程中发生的致命错误
        E_CORE_WARNING => 'E_CORE_WARNING',            // PHP初始化启动过程中发生的警告 (非致命错误)
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',            // 致命编译时错误
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',        // 编译时警告 (非致命错误
        E_USER_ERROR => 'E_USER_ERROR',                // 用户产生的错误信息
        E_USER_WARNING => 'E_USER_WARNING',            // 用户产生的警告信息
        E_USER_NOTICE => 'E_USER_NOTICE',                // 用户产生的通知信息
        E_STRICT => 'E_STRICT',                        // 启用 PHP 对代码的修改建议
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',    // 可被捕捉的致命错误
        E_DEPRECATED => 'E_DEPRECATED',                // 运行时通知
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',        // 用户产生的警告信息
    );

    /**
     * For example,
     * $error=\biwow\error\ErrorHandle::getInstance(true);
     * $mongo=\biwow\log\MongoLog::getInstance('127.0.0.1','shop','test','111111');
     * $log=new \biwow\log\Log($mongo);
     * $error->storage=$log;
     *
     * @param bool|false $debug
     */
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        //捕获意外终止程序的错误信息
        register_shutdown_function(array($this, 'handleFatalError'));
        //自定义错误处理方式
        set_error_handler(array($this, 'handleError'));
        //自定义异常处理方式
        set_exception_handler(array($this, 'handleException'));
    }

    public static function getInstance($debug = false)
    {
        if (static::$_instance === null) {
            static::$_instance = new static($debug);
        }
        return static::$_instance;
    }

    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    public function handleException($e)
    {
        $error = array();
        $error['message'] = $e->getMessage();
        $trace = $e->getTrace();
        if ('E' == $trace[0]['function']) {
            $error['file'] = $trace[0]['file'];
            $error['line'] = $trace[0]['line'];
        } else {
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
        }
        //$error['trace'] = $e->getTraceAsString();
        if ($this->debug) {
            echo "<br>异常--<br>";
        }
        $this->showError($error);
    }

    public function handleError($type, $message, $file, $line)
    {
        $error = array();
        if (empty($type)) {
            $error = array('type' => $type, 'message' => $message, 'file' => $file, 'line' => $line);
        }
        if (!empty($error)) {
            if($this->debug){
                echo "<br>错误--<br>";
            }
            $this->showError($error);
        }

        return true;
    }

    public function handleFatalError()
    {
        $error = error_get_last();
        if (!is_null($error)) {
            if($this->debug){
                echo "<br>致命错误--<br>";
            }
            $this->showError($error);
        }
    }

    public function showError($error)
    {
        if($this->debug) {
            echo '<pre>';
            print_r($error);
            debug_print_backtrace();
            echo '</pre>';
        }
        if (!empty($this->storage)) {
            $table = $this->table ? $this->table : "error";
            $this->storage->set($table, json_encode($error));
        }
    }
}