<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oauth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('wx_oauth');
        $this->load->model(array('Oauth_model'));
    }

    /*
     *  function index($url) 
     *  进行地址组装,根据传进来的参数当作回调参数 ,组装成微信oauth网页链接 
     *  $url 例:http://ww.xx.com/oauth/index/npy520.comZcallbackZyes 传参,带有Z的换成/,方便下个方法进行获取参数
     * 
     */

    public function index($url, $state) {

        $url = 'http://' . strtr($url, 'Z', '/');
        $addr = $this->wx_oauth->callback_url($url, $state);
        header("location:$addr");
    }

    /*
     * callback()
     * 接收微信网页oauth认证回调参数code并查询用户信息
     * 保存cookie判断用户二次打开时是否使用静默授权
     * 接收state参数打开相应名字的视图
     */

    public function callback() {
        if (empty($_GET['code'])) {
            die('未获取到code参数');
        }
        $code = $_GET['code'];
        $views = isset($_GET['state']) ? $_GET['state'] : '';
        //获取 token , openid
        $response = $this->wx_oauth->access_token($code);
        $data['userinfo'] = json_decode($response, true);

        $this->input->set_cookie("snsapi_userinfo", 1, 504800);
        $this->input->set_cookie("u_openid", $data['userinfo']['openid'], 504800);

        $data['signPackage'] = $this->wx_oauth->GetSignPackage();
        $this->load->view('oauth/' . $views, $data);
    }

    /*
     * addresults()
     * 接收拼图游戏成绩并做相应的处理
     */

    function addresults() {
        $result = array();
        $counttime = $this->input->post('counttime');
        $access_token = $this->input->post('access_token');
        $openid = $this->input->post('openid');
        $checkpoint = $this->input->post('checkpoint');

        //数据库数据
        $userinfo = array();
        $userinfo['g_openid'] = $openid;
        $userinfo['g_rank'] = substr($counttime, 0, -1);
        $userinfo['checkpoint'] = (int) $checkpoint;
        $userinfo['g_time'] = date("m.d h:i", time());

        //检测是否存在openid.
        $check = $this->Oauth_model->check_openid($openid);
        if ($check == false) {

            //执行插入操作
            $result = $this->wx_oauth->userinfo($access_token, $openid);
            $arr = json_decode($result, true);

            $userinfo['nickname'] = $arr['nickname'];
            $userinfo['headimgurl'] = $arr['headimgurl'];
            $alert = $this->db->insert($this->Oauth_model->mode_table_name, $userinfo);
            if ($alert) {
                $this->_show_message('提交成功', base_url('oauth/viewrank'));
            }
        } else {
            $alert = '';
            //执行更新操作.
            //如果关卡大于数据库的,则更新关卡和时间.
            if ($check['checkpoint'] < $checkpoint) {
                $alert = $this->db->where('g_openid', $openid)->update($this->Oauth_model->mode_table_name, $userinfo);
            }


            //如果关卡相等,游戏时间小于数据库的.则更新数据库
            if ($check['g_rank'] > $counttime && $checkpoint >= $check['checkpoint']) {

                $alert = $this->db->where('g_openid', $openid)->update($this->Oauth_model->mode_table_name, $userinfo);
            }

            $this->_show_message('提交成功', base_url('oauth/viewrank'));
        }
    }

    /*
     * viewrank()
     * 拼图游戏排行视图
     */

    function viewrank() {
        $data['rank'] = $this->db->where('checkpoint >= 1')->order_by('checkpoint DESC , g_rank ASC')->limit(10)->get($this->Oauth_model->mode_table_name)->result_array();

        if ($this->input->cookie("u_openid")) {
            foreach ($data['rank'] AS $k => $v) {
                if (array_search($this->input->cookie("u_openid"), $v)) {
                    $keys = $k + 1;
                    break;
                }
            }
        }
        //print_r( $data['rank']);

        $data['rank_key'] = isset($keys) ? $keys : 0;
        $this->load->view('oauth/jigsaw_rank', $data);
    }

    /*
     * send()
     * 发送奖励模板消息的方法
     */

    function send() {
        $data['rank'] = $this->db->where('checkpoint >= 1')->order_by('checkpoint DESC , g_rank ASC')->limit(10)->get($this->Oauth_model->mode_table_name)->result_array();

        $access_token = $this->wx_oauth->token_result();

        foreach ($data['rank'] as $val) {
            $template = '
                        {
                           "touser":"' . $val['g_openid'] . '",
                           "template_id":"GNh95-aHriTVy-PNAuJMlEKEzrk-5E2nUtlRev5ZyFc",
                           "url":"",            
                           "data":{
                                   "first": {
                                       "value":"恭喜您中奖了.",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"恭喜您中奖了",
                                       "color":"#173177"
                                   },
                                   "keyword2": {
                                       "value":"恭喜您中奖了",
                                       "color":"#173177"
                                   },
                                   
                                   "remark":{
                                       "value":"恭喜您中奖了",
                                       "color":"#173177"
                                   }
                           }
                       }
                       ';

            $tempURL = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
            $result = $this->wx_oauth->http_request($tempURL, $template);
            print_r($result);
        }
    }

    /*
     * 生成带参数的二维码
     * 99999为优惠券参数 .
     */

    function ticket() {
        $access_token = $this->wx_oauth->token_result();

        $ticketURL = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $postSTR = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 99999}}}';

        $result = json_decode($this->wx_oauth->http_request($ticketURL, $postSTR),true);
        $codeURL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($result['ticket']);
        $img = $this->wx_oauth->http_request($codeURL);
        $filename = 'test.jpg';
        $fp = @fopen($filename, "a"); //将文件绑定到流    
        fwrite($fp, $img); //写入文件  
    }

    /**
     * 信息提示函数
     * @param string $info 提示内容
     * @param string $link 跳转地址
     * @example: show_message('提示成功', "http://www.baidu.com");
     */
    function _show_message($info, $link = '') {
        if ($link) { // 提示信息，跳转页面
            exit("<script>alert('{$info}');location.href='{$link}'</script>");
        } else { // 提示信息，返回上一页（有输入记录）
            exit("<script>alert('{$info}');history.back()</script>");
        }
    }

    public function refresh($refresh_token) {
        $response = $this->wx_oauth->refresh_token($refresh_token);
        echo '<pre>';
        print_r(json_decode($response));
        echo '</pre>';
    }

    public function info($access_token, $openid) {
        header("Content-type: text/html; charset=utf-8");
        $response = $this->wx_oauth->userinfo($access_token, $openid);
        echo '<pre>';
        print_r(json_decode($response));
        echo '</pre>';
    }

    public function valid($access_token, $openid) {
        $response = $this->wx_oauth->valid($access_token, $openid);
        echo '<pre>';
        print_r(json_decode($response));
        echo '</pre>';
    }

}

/* End of file site.php */
/* Location: ./application/controllers/site.php */
 
 