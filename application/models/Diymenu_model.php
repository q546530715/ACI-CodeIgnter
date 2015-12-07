<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diymenu_model extends Base_Model {

    public function __construct() {
        $this->db_tablepre = 'ci_';
        $this->table_name = 'wx_diymen_class';
        parent::__construct();
    }

    function getMenu() {
        $data = $this->select(array('pid' => 0), '*', 3, 'sort');
        foreach ($data as $key => $val) {

            $data[$key]['Submenu'] = $this->select(array('pid' => $val['id']), '*', 5, 'sort');
        }
        return $data;
    }
    
    

}
