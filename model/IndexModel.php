<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/9
 * Time: 下午5:41
 */

namespace model;
use core\model\BaseModel;

class IndexModel extends BaseModel
{
    public $cate = [];

    /**
     * 根据pid获取wiki列表
     * @param $pid
     * @return array|bool
     */
    public function getPidWiki($pid)
    {
        $res = $this->db->select('opq_wiki_content',['id','pid','name','uid','is_dir','create_time','file_name'],['pid'=>$pid,'ORDER'=>'create_time']);
        return $res;
    }

    public function getLastWiki($pid)
    {
        $res = $this->db->select('opq_wiki_content',['id','pid','name','uid','is_dir','create_time','file_name'],['pid[>]'=>0,'ORDER'=>["create_time" => "DESC"]]);
        foreach ($res as $key=>$val){
            $val['create_time'] = date('Y-m-d H:i:s',$val['create_time']);
            $res[$key]=$val;
        }
        return $res;
    }

    public function getWiki($id)
    {
        $res = $this->db->get('opq_wiki_content',['id','name','uid','is_dir','create_time','file_name'],['id'=>$id]);
        $res['create_time'] = date('Y-m-d H:i:s',$res['create_time']);
        return $res;
    }

    public function insertWiki($data)
    {
        return $this->db->insert('opq_wiki_content',$data);
    }

    public function getNavigation()
    {
        $res = $this->db->select('opq_wiki_content',['id','pid','name','file_name'],['pid'=>0]);
        return $res;
    }

    public function category($id,$cate=[])
    {
        $res = $this->db->get('opq_wiki_content',['id','pid','name'],['id'=>$id]);
        $this->cate[] = ['name'=>$res['name'],'id'=>$res['id'],'active'=>0];
        if($res['pid'] && $res['pid'] != 0){
            $this->category($res['pid'],$cate);
        }
        $this->cate[0]['active']=1;
        krsort($this->cate);
        return $this->cate;
    }

    public function log($log)
    {
        $res_log = [];
        foreach ($log as $key=>$val){
            $res_log[$key]['hash'] = substr($val['hash'],0,6);
            $res_log[$key]['date'] = date('Y-m-d H:i:s',strtotime($val['date']));
            $info = json_decode($val['title'],true);
            $res_log[$key]['title'] = $info['msg'];
            $res_log[$key]['name'] = $info['name'];
        }
        return $res_log;
    }
}