<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wechat extends Front_Controller {

    public $msg = array();
    public $debug = true;

    function __construct() {
        parent::__construct();
        $this->config->load('wechat_config');
        $this->load->model(array('Wechat_model', 'Keywords_model'));
        $this->_valid();
        log_message('debug', "Weixin Class Initialized.");
    }

    public function email($content) {
        $this->load->library('email');            //加载CI的email类  
        //以下设置Email参数  
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.163.com';
        $config['smtp_user'] = '08chenriliang';
        $config['smtp_pass'] = 'ro52liang+';
        $config['smtp_port'] = '25';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        //以下设置Email内容  
        $this->email->from('08chenriliang@163.com', 'Liang');
        $this->email->to('admin@npy520.com');
        $this->email->subject('debug');
        $this->email->message($content);
        $this->email->send();

        //echo $this->email->print_debugger();        //返回包含邮件内容的字符串，包括EMAIL头和EMAIL正文。用于调试。  
    }

    public function receivemsg() {
        $this->_index();
        $reply = '';
        $msgType = empty($this->msg->MsgType) ? '' : strtolower($this->msg->MsgType);
        //将openid存进数据表，48小时内可以发送消息
        $this->Wechat_model->checkopenid($this->msg->FromUserName);

        switch ($msgType) {
            case 'text':
                $reply = $this->receiveText($this->msg->Content);

                break;
            case 'image':
                //你要处理图片消息代码 
                break;
            case 'location':
                //你要处理位置消息代码
                break;
            case 'link':
                //你要处理链接消息代码
                break;
            case 'event':
                $this->receiveEvent($this->msg);
                break;
            default:
                //无效消息情况下的处理方式
                break;
        }

        if (!empty($reply)) {
            $this->reply($reply);
        }
    }

    function receiveText($content) {

        $keyword = trim($content);
        $data = $this->Keywords_model->get_one(array('keyword' => $keyword));
        if ($data) {
            //查询到系统有该关键字后,根据类型去检测并回复
            $result = $this->checkType($data);
        } else {

            //* 图灵机器人自动回复 * 没有查询到关键字的时候进行机器人回复
            $str = file_get_contents('http://www.tuling123.com/openapi/api?key=c0812880810d29f83f1467fab3f819c7&info=' . urlencode($keyword));
            $arr = json_decode($str, true);
            $result = $this->transmitText($arr['text']);
        }


        return $result;
    }

    /*
     * 检测回复消息的类型
     * 
     */

    function checkType($data) {

        switch ($data['type']) {
            case 1:

                $result = $this->transmitText($data['contents']);

                break;
            case 2:

                $news_data = array(
                    'title' => $data['news_title'],
                    'description' => $data['news_desc'],
                    'picurl' => $data['news_imgurl'],
                    'url' => $data['news_url'],
                );
                $result = $this->transmitNews($news_data);
                break;
        }
        return $result;
    }

    /*
     * 事件推送 : 二维码扫描事件 / 关注事件 /取消关注事件
     * 创建时间 2015年11月27日
     */

    function receiveEvent($EventObj) {
        $Event = $EventObj->Event;
        $EventKey = isset($EventObj->EventKey) ? $EventObj->EventKey : '';

        switch ($Event) {
            case 'subscribe':
                //automatic_reply 系统后台设置的回复关键字
                $automatic = $this->Keywords_model->get_one(array('keyword' => 'automatic_reply'));
                $this->reply($this->checkType($automatic)); // 欢迎关注回复设置
                
                //扫描二维码关注事件
                //EventKey 事件KEY值，qrscene_为前缀，后面为二维码的参数值
                if (!empty($EventKey)) {
                    $keyword = str_replace("qrscene_", "", $EventKey);
                    if ($keyword = 99999) {
                        //检查是否领取过优惠券
                        if ($this->Wechat_model->check_is_receive_coupons($this->msg->FromUserName)) {
                            $this->Event_template($keyword);
                        } else {
                            //通知已经领过优惠券
                            $this->reply($this->transmitText("亲,您已经领取过此优惠券了哦\r\n如果有问题的话可以联系一下我们的客服"));
                        }
                    }
                }


                break;
            case 'SCAN':
                //扫描二维码关注 EventKey 事件KEY值，是一个32位无符号整数，即创建二维码时的二维码scene_id
                if ($EventKey = 99999) {
                    //检查是否领取过优惠券
                    if ($this->Wechat_model->check_is_receive_coupons($this->msg->FromUserName)) {
                        $this->Event_template($EventKey);
                    } else {

                        //通知已经领过优惠券
                        $this->reply($this->transmitText("亲,您已经领取过此优惠券了哦\r\n如果有问题的话可以联系一下我们的客服"));
                    }
                }

                break;
            case 'unsubscribe':
                $this->Wechat_model->delete(array('u_openid' => $this->msg->FromUserName));
                break;
        }

        exit;
    }

    public function Event_template($where) {
        $data = $this->Keywords_model->get_one(array('keyword' => $where));
        if (!empty($data)) {
            $this->load->library('wechat_class');
            $template_id = '8C7SsmQlTVxtJ9Wj58k2UWPQuCklqe5xri5PDhumpvY';
            $template_content = array(
                'first' => '恭喜您,您可以领取一张男朋友通用优惠券一张',
                'keyword1' => '男朋友能用优惠券',
                'keyword2' => '男朋友',
                'keyword3' => date('Y-m-d H:i:s', time()),
                'remark' => '点击之后即可领取,不点击的话则领取不了哦亲,每人只能领取一次',
            );
            //构造模板消息
            $template = $this->wechat_class->template_message_send($template_id, $this->msg->FromUserName, $template_content, $data['contents']);

            //调用模板消息接口
            $this->load->library('wx_oauth');
            $access_token = $this->wx_oauth->token_result();
            $tempURL = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
            $curl = $this->wx_oauth->http_request($tempURL, $template);
            $return = json_decode($curl);
            // $this->email($curl);
            if ($return->errmsg == 'ok') {
                $this->Wechat_model->update(array('is_receive_coupons' => 1), array('u_openid' => $this->msg->FromUserName)); //更新为已领取优惠券  
            } else {
                $this->log('error-Event_template' . $return);
            }
        }
    }

    /*
     * 文字消息构建 
     */

    public function transmitText($content) {
        $xmlTpl = "
            <xml>
                <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName> 
                <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
            </xml>
            ";

        return sprintf($xmlTpl, time(), $content);
    }

    /*
     * 图文消息构建 
     */

    public function transmitNews($newsArray = array()) {

        //循环图文
        $itemTpl = "
            <item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
            </item>
            ";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['title'], $item['description'], $item['picurl'], $item['url']);
        }

        //把图文循环到模板里面去
        $xmlTpl = "
        <xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>%s</ArticleCount>
            <Articles>
                $item_str
            </Articles>
        </xml> 
        ";

        return sprintf($xmlTpl, time(), count($newsArray));
    }

    /**
     * reply
     *
     * @param mixed $data
     * @access public
     * @return void
     */
    public function reply($data) {
        if ($this->debug) {
            $this->log($data);
        }
        echo $data;
    }

    public function _index() {

        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

        if ($this->debug) {
            $this->log($postStr);
        }
        if (!empty($postStr)) {
            libxml_disable_entity_loader(true);
            $this->msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    public function _valid() {
        $echoStr = $this->input->get('echostr');
        //valid signature , option
        if ($this->_check_signature()) {
            echo $echoStr;
        } else {
            exit;
        }
    }

    private function _check_signature() {
        // you must define TOKEN by yourself

        $signature = $this->input->get('signature');
        $timestamp = $this->input->get('timestamp');
        $nonce = $this->input->get('nonce');
        $token = $this->config->item('token');
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {

            return true;
        } else {

            return false;
        }
    }

    public function log($log) {
        if ($this->debug) {
            file_put_contents('weixin_log.xml', var_export($log, true) . "\n\r", FILE_APPEND);
        }
    }

}
