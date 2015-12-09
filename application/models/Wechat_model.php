<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wechat_model extends Base_Model {

    public function __construct() {
        $this->db_tablepre = 'ci_';
        $this->table_name = 'user';
        parent::__construct();
    }

    /*
     * 检测openid是否存在,没有的话则存入数据库.
     */

    function checkopenid($openid, $groupid = 0) {
        //将openid存进数据表，48小时内可以发送消息
        if (!empty($openid)) {

            $user = $this->db->get_where($this->table_name, array('u_openid' => $openid))->row_array();
            if (empty($user)) {

                $user = array(
                    'u_openid' => $openid,
                    'groupid' => $groupid,
                    'openid_deadline' => time() + 172800
                );
                $this->insert($user);
            } else {
                $user = array(
                    'groupid' => $groupid,
                    'openid_deadline' => time() + 172800
                );

                $status = $this->update($user, array('u_openid' => $openid));
            }
        }
    }

    /*
     * 检测openid是否存在,没有的话则存入数据库.
     */

    function check_is_receive_coupons($openid) {
        $user = $this->get_one(array('u_openid' => $openid));
        if ($user['is_receive_coupons'] == 0) {
            return true;
        } else {
            return false;
        }
    }

}
