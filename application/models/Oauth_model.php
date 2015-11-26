<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oauth_model extends Base_Model {

    public $mode_table_name = '';

    public function __construct() {
        $this->db_tablepre = 'ci_';
        $this->table_name = 'game_rank';
        parent::__construct();
        $this->mode_table_name = $this->table_name;
    }

    public function check_openid($openid) {

        $result = $this->db->get_where($this->table_name, array('g_openid' => $openid))->row_array();

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
