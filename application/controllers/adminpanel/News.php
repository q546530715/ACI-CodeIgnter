<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class News extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('News_model'));
        $this->load->helper(array('member', 'auto_codeIgniter', 'string'));
    }

    function nlist() {
        $data['list'] = $this->News_model->nlist();

        $this->view('nlist', array('list' => $data['list'], 'require_js' => true));
    }

    /**
     * 删除选中数据
     * @param post pid 
     * @return void
     */
    function delete() {
        if (isset($_POST)) {
            $pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
            $where = $this->News_model->to_sqls($pidarr, '', 'news_id');
            $status = $this->News_model->delete($where);
            if ($status) {
                $this->showmessage('操作成功', HTTP_REFERER);
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
        $data_info = array(
            'news_title' => null,
            'news_content' => null,
            'public_url' => null,
            'news_original_url' => null,
        );
        if ($this->input->post('formhash') == md5($this->user_id . date('YMD', time())) && $this->input->post('news_title') != '') {

            $data['news_title'] = $this->input->post('news_title');
            $data['news_content'] = $this->input->post('news_content');
            $data['public_url'] = $this->input->post('public_url');
            $data['news_time'] = time();
            $data['news_original_url'] = $this->input->post('news_original_url');

            $inster = $this->News_model->insert($data);
            if ($inster) {
                $this->showmessage('添加成功', base_url(ADMIN_URL_PATH . 'news/nlist'));
            } else {
                $this->showmessage('添加失败');
            }
        }

        $formhash = md5($this->user_id . date('YMD', time()));

        $this->view('edit', array('is_edit' => false, 'formhash' => $formhash, 'data_info' => $data_info));
    }

    function edit($id = 0) {

        $id = (int) $id;
        $data_info = $this->News_model->get_one(array('news_id' => $id));

        if ($this->input->post('news_title') != '' && $this->input->post('formhash') == md5($data_info['news_id'] . date('YMD', time()))) {

            $data['news_title'] = $this->input->post('news_title');
            $data['news_content'] = $this->input->post('news_content');
            $data['public_url'] = $this->input->post('public_url');
            $data['news_time'] = time();
            $data['news_original_url'] = $this->input->post('news_original_url');

            $status = $this->News_model->update($data, array('news_id' => $id));
            if ($status) {
                $this->showmessage('修改成功', base_url(ADMIN_URL_PATH . 'news/nlist'));
            } else {
                $this->showmessage('修改失败');
            }
        }

        $formhash = md5($data_info['news_id'] . date('YMD', time()));


        $this->view('edit', array('is_edit' => true, 'formhash' => $formhash, 'data_info' => $data_info));
    }

}
