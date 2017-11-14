<?php

namespace model;

/**
 * @package model
 * @property \model\IndexModel $index
 * @property \model\AdminModel $admin
 */

class InstanceModel
{
    protected $component = array();


    public function __get($key) {
        $class = "\\model\\".ucfirst($key)."Model";
        $this->component[$key] =  new $class();
        return isset($this->component[$key]) ? $this->component[$key] : null;
    }
}