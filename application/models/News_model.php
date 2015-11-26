<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_model extends Base_Model {
    
    var $page_size = 10;
    public function __construct() {
        $this->db_tablepre = 'ci_'; 
        $this->table_name  = 'news';
        parent::__construct();
    }
    
    public function nlist() {
        
        return $this->db->get($this->db_tablepre.'wechat_news_info')->result_array();
        
    }

}
