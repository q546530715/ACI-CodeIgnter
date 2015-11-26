<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Weixin_oauth / wxjsapi 类库，主要是远程抓取页面，默认http请求，也可以使用https请求，
 * 可以在初始化的时候通过传入可选参数https为true，设置为https请求
 */
class Wx_oauth {

    const TIMEOUT = 5;                        // 设置超时时间

    private $ci;                                // CI对象
    private $ch;                                // curl对象

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->config->load('wx_oauth');                // 载入配置文件
    }

    /**
     * 验证配置接口信息
     * @param array 从微信接口发送来的信息，通过$_GET获得
     */
    public function interface_valid($get_request) {
        $signature = $get_request['signature'];
        $timestamp = $get_request['timestamp'];
        $nonce = $get_request['nonce'];

        $token = $this->ci->config->item('token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            echo $get_request['echostr'];
            exit;
        }
    }

    /**
     * (用户传参可变)生成用户授权的地址
     * @param string 自定义需要保持的信息
     * @param bool 是否是通过公众平台方式认真
     */
    public function callback_url($url, $state = '') {
        if ($this->ci->input->cookie("snsapi_userinfo") == 1) {

            $scope = 'snsapi_base';
        } else {
            $scope = 'snsapi_userinfo';
        };

        $data = array(
            'appid' => $this->ci->config->item('appid'),
            'redirect_uri' => urlencode($url),
            'response_type' => 'code',
            'scope' => $scope,
            'state' => $state,
            '#wechat_redirect' => '');
        $url = $this->ci->config->item('authorize_url');

        return $url . $this->create_url($data);
    }

    /**
     * (系统配置固定的)生成用户授权的地址
     * @param string 自定义需要保持的信息
     * @param bool 是否是通过公众平台方式认真
     */
    public function authorize_addr($state = '', $mp = false) {
        if ($mp) {
            $data = array(
                'appid' => $this->ci->config->item('appid'),
                'secret' => $this->ci->config->item('secret'),
                'grant_type' => 'client_credential');
            $url = $this->ci->config->item('mp_authorize_url');
        } else {
            $data = array(
                'appid' => $this->ci->config->item('appid'),
                'redirect_uri' => urlencode($this->ci->config->item('redirect_uri')),
                'response_type' => 'code',
                'scope' => $this->ci->config->item('scope'),
                'state' => $state,
                '#wechat_redirect' => '');
            $url = $this->ci->config->item('authorize_url');
        }

        return $url . $this->create_url($data);
    }

    /**
     * 获取 access token
     * @param string 用于换取access token的code，微信提供
     */
    public function access_token($code) {
        $data = array(
            'appid' => $this->ci->config->item('appid'),
            'secret' => $this->ci->config->item('secret'),
            'code' => $code,
            'grant_type' => 'authorization_code');
        // 生成授权url
        $url = $this->ci->config->item('access_token_url');
        return $this->send_request($url, $data);
    }

    /**
     * 刷新 access token
     * @param string 用于刷新的token
     */
    public function refresh_token($refresh_token) {
        $data = array(
            'appid' => $this->ci->config->item('appid'),
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token');
        // 生成授权url
        $url = $this->ci->config->item('refresh_token_url');
        return $this->send_request($url, $data);
    }

    /**
     * 从文件获取全局token
     */
    public function token_result() {

        return $this->getAccessToken();
    }

    /**
     * 获取用户信息
     * @param string access token
     * @param string 用户的open id
     */
    public function userinfo($token, $openid) {
        $data = array(
            'access_token' => $token,
            'openid' => $openid,
            'lang' => $this->ci->config->item('lang'));
        // 生成授权url
        $url = $this->ci->config->item('userinfo_url');
        return $this->send_request($url, $data);
    }

    /**
     * 检验access token 是否有效
     * @param string access token
     * @param string 用户的open id
     */
    public function valid($token, $openid) {
        $data = array(
            'access_token' => $token,
            'openid' => $openid);
        // 生成授权url
        $url = $this->ci->config->item('valid_token_url');
        return $this->send_request($url, $data);
    }

    /**
     * 发送curl请求，并获取请求结果
     * @param string 请求地址
     * @param array 如果是post请求则需要传入请求参数
     * @param string 请求方法，get 或者 post， 默认为get
     * @param bool 是否以https协议请求
     */
    private function send_request($request, $params, $method = 'get', $https = true) {
        // 以get方式提交
        if ($method == 'get') {
            $request = $request . $this->create_url($params);
        }

        $this->ch = curl_init($request);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); // 设置不显示结果，储存入变量
        curl_setopt($this->ch, CURLOPT_TIMEOUT, self::TIMEOUT); // 设置超时限制防止死循环
        // 判断是否以https方式访问
        if ($https) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        }

        if ($method == 'post') {        // 以post方式提交
            curl_setopt($this->ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params); // Post提交的数据包
        }

        $tmpInfo = curl_exec($this->ch); // 执行操作
        if (curl_errno($this->ch)) {
            echo 'Errno:' . curl_error($this->ch); //捕抓异常
        }
        curl_close($this->ch); // 关闭CURL会话

        return $tmpInfo; // 返回数据
    }

    /**
     * 生成url
     */
    private function create_url($data) {
        $temp = '?';
        foreach ($data as $key => $item) {
            $temp = $temp . $key . '=' . $item . '&';
        }
        return substr($temp, 0, -1);
    }

    /*
     * 
     * 
     */

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->ci->config->item('appid'),
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );

        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /*
     * jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
     * 如果是企业号用以下 URL 获取 ticket
     * $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
     */

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/wxconf/jsapi_ticket.json'));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->http_request($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/wxconf/jsapi_ticket.json', "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    /*
     * 以下是由jsAPi改造
     * 
     */

    private function getAccessToken() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/wxconf/access_token.json'));

        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->ci->config->item('appid') . "&secret=" . $this->ci->config->item('secret');
            $res = json_decode($this->http_request($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/wxconf/access_token.json', "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    public function http_request($url, $data = null) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

}

/**
 * End fo wx_oauth.php file
 */
 