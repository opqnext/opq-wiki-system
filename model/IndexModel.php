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

    public function getWiki()
    {
        $res = $this->db->select('opq_wiki_content',['id','name','uid','is_dir'],['pid'=>0]);
        return $res;
    }

    public function insertWiki($data)
    {
        return $this->db->insert('opq_wiki_content',$data);
    }
}