<?php
/**
 * 客户端crashlog解析入库(mongo)
 * 请在$dmp_dir目录下生成对应的sym文件（名字为{appid}.so.sym）
 * 如何生成.so.sym文件? http://blog.csdn.net/brook0344/article/details/20126351
 * 步骤：
 * 1. cd /home/deploy/upload_crash_log/crash_log/
 * 2. ./dump_syms {appid}.so > {appid}.so.sym
 * 3. 讲{appid}.so.sym 文件放到 /home/deploy/upload_crash_log/crash_log/symbols/{appid}.so/446D829425908004B8DE663940A0D27C0({appid}.so.sym文件的第一行)/ 目录下
 * @author zhou.yongguo
 * @date 2015-09-22
 */

$redis = new redis();
//$redis->connect('redis_node_6201.momo.com', 6201);
$redis->connect('redis_node_queue_6534.momo.com', 6534);//专门存放队列的redis
$redisKey = 'crash_log_list';

$mongo = new Mongo("mongodb://mongo_node_app_10810.momo.com:10810");
$db    = $mongo->selectDB("bi");
$col   = $db->selectCollection("spam_ban_log");

$dmp_dir = '/home/deploy/upload_crash_log/crash_log/';

while(true) {
    $lineData = $redis->brpop($redisKey, 0);

    $data = json_decode($lineData[1], true);
    if (!$data) {
        echo "Error message json_decede 为空，message=" . var_export($lineData, true) . "\n";
        continue;
    }


    //入库数据
    $appid       = $data['appid'];
    $version     = $data['version'];
    $momoid      = $data['momoid'];
    $ctime       = $data['ctime'];
    $os          = $data['os'];
    $os_version  = $data[''];
    $device      = $data['device'];

    $insertData = array(
        'appid'       => $appid,
        'version'     => intval($version),
        'momoid'      => $momoid,
        'ctime'       => $ctime,
        'os'          => $os,
        'os_version'  => $os_version,
        'device'      => $device,
        'reason'      => $reason,
        'stacktrace'  => $stacktrace,
        'stack_crc32' => $stack_crc32,
        'market'      => $market,
    );

    echo "Success~\n";

    $ret = $col->insert($insertData);

}