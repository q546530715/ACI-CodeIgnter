<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wechat extends Front_Controller {

    //public $msg = array();
    public $debug = true;

    function __construct() {
        parent::__construct();
        $this->config->load('wechat_config');
        //$this->load->model(array('Wechat_model', 'Keywords_model'));
        log_message('debug', "Weixin Class Initialized.");
    }

    public function receivemsg() {
        $this->_valid();
        //get post data, May be due to the different environments
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

        $this->log($postStr);

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
              the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                        </xml>";
            if (!empty($keyword)) {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            echo "1111";
            exit;
        }
    }

    public function _valid() {
        $echoStr = $this->input->get('echostr');
        $this->log('echoStr' . $echoStr . 0);
        //valid signature , option
        if ($this->_check_signature()) {
            $this->log('echoStr' . $echoStr . 1);
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
            $this->log('error._checkSignature_yes');
            return true;
        } else {
            $this->log('error._checkSignature_no');
            return false;
        }
    }

    public function log($log) {
        if ($this->debug) {
            file_put_contents('weixin_log.xml', var_export($log, true) . "\n\r", FILE_APPEND);
        }
    }

}
