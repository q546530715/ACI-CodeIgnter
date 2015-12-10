<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WechatSite extends Admin_Controller {

    public $formhash;
    public $method_config;

    function __construct() {
        parent::__construct();
        $this->formhash = md5(md5($this->user_id . date('YMD', time()))); // formhash
        $this->load->model(array('WechatSite_model', 'Diymenu_model'));

        //文件上传配置
        $this->method_config['upload'] = array(
            'thumb' => array('upload_size' => 1024, 'upload_file_type' => 'jpg|png|gif', 'upload_path' => 'uploadfile/user', 'upload_url' => SITE_URL . 'uploadfile/user/'),
        );
    }

    /*
     * =============================
     *      添加删除修改微信关键字
     *         2015年12月03日
     * =============================
     */

    public function keywords($page_no = 1) {

        $page_no = max(intval($page_no), 1);
        //查询记录并且还分好页
        $data['data_list'] = $this->WechatSite_model->listinfo('', '*', '', $page_no, 10, '', 10, page_list_url('adminpanel/WechatSite/keywords', true));

        $data['formhash'] = $this->formhash;
        $data['pages'] = $this->WechatSite_model->pages; //分页按钮
        $data['require_js'] = true;  //配置是否使用js

        $this->view('keywords', $data);
    }

    /**
     * 删除选中数据
     * @param post pid 
     * @return void
     */
    function delete() {
        if (isset($_POST)) {
            $pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', base_url(ADMIN_URL_PATH . 'WechatSite/diymenu'));
            $where = $this->WechatSite_model->to_sqls($pidarr, '', 'id');
            $status = $this->WechatSite_model->delete($where);
            if ($status) {
                $this->showmessage('操作成功', base_url(ADMIN_URL_PATH . 'WechatSite/keywords'));
            } else {
                $this->showmessage('操作失败');
            }
        }
    }

    /**
     * 添加数据 
     * @param post pid 
     * @return void
     */
    function add() {

        $data['data_info'] = array(
            'name' => null,
            'keyword' => null,
            'type' => null,
            'contents' => null,
            'news_imgurl' => null,
            'news_title' => null,
            'news_desc' => null,
            'news_url' => null,
            'thumb' => 'nopic.gif',
        );

        if ($this->input->post('formhash') == $this->formhash && $this->input->post('keyword') != '') {

            $data = array();
            $data['name'] = $this->input->post('name');
            $data['keyword'] = $this->input->post('keyword');
            $data['type'] = $this->input->post('type');

            if ($data['type'] == 1) {
                $data['contents'] = $this->input->post('contents');
            }

            if ($data['type'] == 2) {
                $data['thumb'] = $this->input->post('thumb');
                $data['news_title'] = $this->input->post('news_title');
                $data['news_desc'] = $this->input->post('news_desc');
                $data['news_url'] = $this->input->post('news_url');
            }

            $inster = $this->WechatSite_model->insert($data);
            if ($inster) {
                $this->showmessage('添加成功', base_url(ADMIN_URL_PATH . 'WechatSite/keywords'));
            } else {
                $this->showmessage('添加失败');
            }
        }

        $data['is_edit'] = false;
        $data['formhash'] = $this->formhash;
        $data['require_js'] = true;  //配置是否使用js

        $this->view('edit', $data);
    }

    function edit($id = 0) {

        $id = (int) $id;
        $data['data_info'] = $this->WechatSite_model->get_one(array('id' => $id));
        if (empty($data_info['thumb'])) {
            $data_info['thumb'] = 'nopic.gif';
        }
        if ($this->input->post('keyword') != '' && $this->input->post('formhash') == $this->formhash) {

            $data = array();
            $data['name'] = $this->input->post('name');
            $data['keyword'] = $this->input->post('keyword');
            $data['type'] = $this->input->post('type');

            if ($data['type'] == 1) {

                $data['contents'] = $this->input->post('contents');
                $data['thumb'] = null;
                $data['news_title'] = null;
                $data['news_desc'] = null;
                $data['news_url'] = null;
            }

            if ($data['type'] == 2) {
                $data['contents'] = null;
                $data['thumb'] = $this->input->post('thumb');
                $data['news_title'] = $this->input->post('news_title');
                $data['news_desc'] = $this->input->post('news_desc');
                $data['news_url'] = $this->input->post('news_url');
            }

            $status = $this->WechatSite_model->update($data, array('id' => $id));
            if ($status) {
                $this->showmessage('修改成功', base_url(ADMIN_URL_PATH . 'WechatSite/keywords'));
            } else {
                $this->showmessage('修改失败');
            }
        }

        $formhash = $this->formhash;
        $data['is_edit'] = false;
        $data['formhash'] = $this->formhash;
        $data['require_js'] = true;  //配置是否使用js

        $this->view('edit', $data);
    }

    /*
     * =============================
     *      生成微信自定义菜单
     *      2015年12月03日
     * =============================
     */

    function diymenu() {


        $data['menudata'] = $this->Diymenu_model->getMenu();
        $data['formhash'] = $this->formhash;

        //视图配置
        $data['is_edit'] = false;

        $this->view('diymenu', $data);
    }

    function menu_add() {

        if ($this->input->post('formhash') == $this->formhash && $this->input->post('pid') != '' && $this->input->post('title') != '') {
            $data = array(
                'pid' => (int) $this->input->post('pid'),
                'title' => $this->input->post('title'),
                'keyword' => $this->input->post('keyword'),
                'url' => $this->input->post('url'),
                'is_show' => $this->input->post('is_show'),
                'sort' => (int) $this->input->post('sort'),
            );
            if ($this->Diymenu_model->insert($data) > 0) {
                $this->showmessage('添加成功', base_url(ADMIN_URL_PATH . 'WechatSite/diymenu'));
            } else {
                $this->showmessage('网络错误');
            }
            exit;
        }

        $data['menu_info'] = array(
            'pid' => null,
            'title' => null,
            'keyword' => null,
            'url' => null,
            'is_show' => 1,
            'sort' => 0,
        );

        $data['parent_menu'] = $this->Diymenu_model->select(array('pid' => 0));
        $data['formhash'] = $this->formhash;
        $data['is_edit'] = false;

        $this->view('menu_edit', $data);
    }

    function menu_edit($id = 0) {
        $id = (int) $id;
        if ($this->input->post('formhash') == $this->formhash && $this->input->post('pid') != '' && $this->input->post('title') != '') {
            $data = array(
                'pid' => (int) $this->input->post('pid'),
                'title' => $this->input->post('title'),
                'keyword' => $this->input->post('keyword'),
                'url' => $this->input->post('url'),
                'is_show' => $this->input->post('is_show'),
                'sort' => (int) $this->input->post('sort'),
            );

            if ($this->Diymenu_model->update($data, array('id' => $id))) {
                $this->showmessage('修改成功', base_url(ADMIN_URL_PATH . 'WechatSite/diymenu'));
            } else {
                $this->showmessage('修改失败');
            }

            exit;
        }
        $data['parent_menu'] = $this->Diymenu_model->select(array('pid' => 0));
        $data['menu_info'] = $this->Diymenu_model->get_one(array('id' => $id));
        $data['formhash'] = $this->formhash;
        $data['is_edit'] = true;

        $this->view('menu_edit', $data);
    }

    function menu_delete($id = 0, $formhash) {

        $id = (int) $id;
        if ($formhash == $this->formhash && $id > 0) {

            if ($this->Diymenu_model->delete(array('id' => $id))) {
                $this->showmessage('操作成功', base_url(ADMIN_URL_PATH . 'WechatSite/diymenu'));
            } else {
                $this->showmessage('操作失败');
            }
        }
    }

    public function class_send() {

        $data = '{"button":[';

        // $class = M('Diymen_class')->where(array('token' => session('token'), 'pid' => 0, 'is_show' => 1))->limit(3)->order('sort desc')->select(); //dump($class);
        $class = $this->Diymenu_model->select(array('pid' => 0, 'is_show' => 1), '*', 3, 'sort desc');

        //$kcount = M('Diymen_class')->where(array('token' => session('token'), 'pid' => 0, 'is_show' => 1))->limit(3)->order('sort desc')->count(array('pid' => 0, 'is_show' => 1));
        $kcount = count($class);
        $k = 1;
        foreach ($class as $key => $vo) {
            //主菜单
            $data.='{"name":"' . $vo['title'] . '",';

            // $c = M('Diymen_class')->where(array('token' => session('token'), 'pid' => $vo['id'], 'is_show' => 1))->limit(5)->order('sort desc')->select();
            $c = $this->Diymenu_model->select(array('pid' => $vo['id'], 'is_show' => 1), '*', 5, 'sort desc');

            // $count = M('Diymen_class')->where(array('token' => session('token'), 'pid' => $vo['id'], 'is_show' => 1))->limit(5)->order('sort desc')->count();
            $count = count($c);

            //子菜单
            $vo['url'] = str_replace(array('&amp;'), array('&'), $vo['url']);
            if ($c != false) {
                $data.='"sub_button":[';
            } else {
                if (!$vo['url']) {
                    $data.='"type":"click","key":"' . $vo['keyword'] . '"';
                } else {
                    $data.='"type":"view","url":"' . $vo['url'] . '"';
                }
            }
            $i = 1;
            foreach ($c as $voo) {
                $voo['url'] = str_replace(array('&amp;'), array('&'), $voo['url']);
                if ($i == $count) {
                    if ($voo['url']) {
                        $data.='{"type":"view","name":"' . $voo['title'] . '","url":"' . $voo['url'] . '"}';
                    } else {
                        $data.='{"type":"click","name":"' . $voo['title'] . '","key":"' . $voo['keyword'] . '"}';
                    }
                } else {
                    if ($voo['url']) {
                        $data.='{"type":"view","name":"' . $voo['title'] . '","url":"' . $voo['url'] . '"},';
                    } else {
                        $data.='{"type":"click","name":"' . $voo['title'] . '","key":"' . $voo['keyword'] . '"},';
                    }
                }
                $i++;
            }
            if ($c != false) {
                $data.=']';
            }

            if ($k == $kcount) {
                $data.='}';
            } else {
                $data.='},';
            }
            $k++;
        }
        $data.=']}';
        $this->load->library('wx_oauth');
        $access_token = $this->wx_oauth->token_result();

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $rt = json_decode($this->wx_oauth->http_request($url, $data));

        if ($rt->errmsg == 'ok') {
            $this->showmessage('生成菜单成功', base_url(ADMIN_URL_PATH . 'WechatSite/diymenu'));
        } else {
            $this->showmessage('网络错误,错误代码:' . $rt->errcode . $rt->errmsg);
        }
        exit;
    }

}
