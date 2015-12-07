<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keywords_model extends Base_Model {

    public function __construct() {
        $this->db_tablepre = 'ci_';
        $this->table_name = 'wx_keywords';
        parent::__construct();
    }
    
    
}
