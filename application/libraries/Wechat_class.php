<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wechat_class {

    private $ci;    // CI对象

    function __construct() {
        $this->ci = & get_instance();
        //$this->ci->config->load('wechat_config');   // 载入配置文件
    }

    function template_message_send($template_id, $openid, $content, $url = '') {

        switch ($template_id) {
            case 'GNh95-aHriTVy-PNAuJMlEKEzrk-5E2nUtlRev5ZyFc':
                $template = '
                        {
                           "touser":"' . $openid . '",
                           "template_id":"GNh95-aHriTVy-PNAuJMlEKEzrk-5E2nUtlRev5ZyFc",
                           "url":"' . $url . '",            
                           "data":{
                                   "first": {
                                       "value":"' . $content['first'] . '",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"' . $content['keyword1'] . '",
                                       "color":"#FF0000"
                                   },
                                   "keyword2": {
                                       "value":"' . $content['keyword2'] . '",
                                       "color":"#FF0000"
                                   },
                                   
                                   "remark":{
                                       "value":"' . $content['remark'] . '",
                                       "color":"#173177"
                                   }
                           }
                       }
                       ';

                break;
            case '8C7SsmQlTVxtJ9Wj58k2UWPQuCklqe5xri5PDhumpvY':
                $template = '
                        {
                           "touser":"' . $openid . '",
                           "template_id":"GNh95-aHriTVy-PNAuJMlEKEzrk-5E2nUtlRev5ZyFc",
                           "url":"' . $url . '",               
                           "data":{
                                   "first": {
                                       "value":"$content[first]",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"' . $content['keyword1'] . '",
                                       "color":"#FF0000"
                                    },
                                    "keyword2": {
                                        "value":"' . $content['keyword2'] . '",
                                        "color":"#FF0000"
                                        },
                                    "keyword3": {
                                        "value":"' . $content['keyword3'] . '",
                                        "color":"#FF0000"
                                        },
                                        "remark": {
                                            "value":"' . $content['remark'] . '",
                                            "color":"#173177"
                                        }
                                    }
                                }
                                ';
                break;
            default:


                break;
        }



        return $template;
    }

}
