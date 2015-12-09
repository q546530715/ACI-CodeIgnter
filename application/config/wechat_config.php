<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 用于验证微信接口配置信息的Token，可以任意填写
$config['token'] = 'weixin';
 
// appID
$config['appid'] = 'wxbdc4ed16624422a4';
 
// appSecret
$config['secret'] = 'cc4abf35ac4a381c6f7848ac4c2bf449';
 
// 回调链接地址
$config['redirect_uri'] = 'http://mp.npy520.com/index.php/oauth/callback/';
 
// 是否以 HTTPS 安全协议访问接口
$config['https_request']        = true;
 
// 授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
// snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，
// 即使在未关注的情况下，只要用户授权，也能获取其信息）
$config['scope'] = 'snsapi_base';
 
// 语言
$config['lang'] = 'zh_CN'; // zh_CN 简体，zh_TW 繁体，en 英语
 
// 微信公众账户授权地址
$config['mp_authorize_url'] = 'https://api.weixin.qq.com/cgi-bin/token';
// 授权地址
$config['authorize_url'] = 'https://open.weixin.qq.com/connect/oauth2/authorize';
// 获取access token 的地址
$config['access_token_url'] = 'https://api.weixin.qq.com/sns/oauth2/access_token';
// 刷新 token 的地址
$config['refresh_token_url'] = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';
// 获取用户信息地址
$config['userinfo_url'] = 'https://api.weixin.qq.com/sns/userinfo';
// 验证access token
$config['valid_token_url'] = 'https://api.weixin.qq.com/sns/auth';
 
 