<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 微信接口文件
 * 
 * @author Liang
 * @Email  admin@5byt.com
 * @since  1.0
 * 
 */

class Wechat extends Front_Controller {

    public $msg = array();
    public $debug = true;
    public $wechat_config = array();

    function __construct() {
        parent::__construct();
        $this->config->load('wechat');
        $this->wechat_config = $this->config->item('wechat_config');
    }

    /*
     * function message();
     * 微信接口,接收消息,发送消息
     */

    function message() {
        $this->_index();
        $reply = '';
        $msgType = empty($this->msg->MsgType) ? '' : strtolower($this->msg->MsgType);

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
                break;
            default:
                //无效消息情况下的处理方式
                break;
        }

        $this->reply($reply);
    }

    function receiveText($content) {
        $keyword = trim($content);
        $str = file_get_contents('http://www.tuling123.com/openapi/api?key=c0812880810d29f83f1467fab3f819c7&info=' . urlencode($keyword));
        $arr = json_decode($str, true);
        $content = $arr['text'];
        $result = $this->transmitText($content);

        return $result;
    }

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
        $postStr = empty($GLOBALS["HTTP_RAW_POST_DATA"]) ? '' : $GLOBALS["HTTP_RAW_POST_DATA"];
        if ($this->debug) {
            $this->log($postStr);
        }
        if (!empty($postStr)) {
            $this->msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    public function _valid() {
        $echoStr = $this->input->get('echostr');

        //valid signature , option
        if ($this->_checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    private function _checkSignature() {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $this->input->get('signature');
        $timestamp = $this->input->get('timestamp');
        $nonce = $this->input->get('nonce');
        $token = $this->wechat_config['token'];
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

    private function log($log) {
        if ($this->debug) {
            file_put_contents('weixin_log.xml', var_export($log, true) . "\n\r", FILE_APPEND);
        }
    }

}
