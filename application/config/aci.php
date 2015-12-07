<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$config['aci_status'] = array(
    'systemVersion' => '1.0.0',
    'installED' => true,
);
$config['aci_module'] = array(
    'welcome' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'welcome',
        'modulePath' => '',
        'moduleCaption' => '首页',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => '',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => '',
                'controller' => 'welcome',
                'method' => '',
                'caption' => '欢迎界面',
            ),
        ),
    ),
    'adminpanel' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'user',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '后台管理中心',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/user',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'index',
                'caption' => '管理中心-首页',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'login',
                'caption' => '管理中心-登录',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'logout',
                'caption' => '管理中心-注销',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'profile',
                'method' => 'change_pwd',
                'caption' => '管理中心-修改密码',
            ),
            4 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'login',
                'caption' => '管理中心-登录',
            ),
            5 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'go',
                'caption' => '管理中心-URL转向',
            ),
            6 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'manage',
                'method' => 'cache',
                'caption' => '管理中心-全局缓存',
            ),
        ),
    ),
    'user' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'user',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '用户 / 用户组管理',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/user',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'index',
                'caption' => '用户管理-列表',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'check_username',
                'caption' => '用户管理-检测用户名',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'delete',
                'caption' => '用户管理-删除',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'lock',
                'caption' => '用户管理-锁定',
            ),
            4 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'edit',
                'caption' => '用户管理-编辑',
            ),
            5 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'add',
                'caption' => '用户管理-新增',
            ),
            6 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'user',
                'method' => 'upload',
                'caption' => '用户管理-上传图像',
            ),
            7 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'role',
                'method' => 'index',
                'caption' => '用户组管理-列表',
            ),
            8 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'role',
                'method' => 'setting',
                'caption' => '用户组管理-权限设置',
            ),
            9 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'role',
                'method' => 'add',
                'caption' => '用户组管理-新增',
            ),
            10 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'role',
                'method' => 'edit',
                'caption' => '用户组管理-编辑',
            ),
            11 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'role',
                'method' => 'delete_one',
                'caption' => '用户组管理-删除',
            ),
        ),
    ),
    'member' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'user',
        'modulePath' => 'member',
        'moduleCaption' => '用户中心',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'member/manage',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'member',
                'controller' => 'manage',
                'method' => 'index',
                'caption' => '用户中心-首页',
            ),
            1 =>
            array(
                'folder' => 'member',
                'controller' => 'manage',
                'method' => 'login',
                'caption' => '用户中心-登录',
            ),
            2 =>
            array(
                'folder' => 'member',
                'controller' => 'manage',
                'method' => 'logout',
                'caption' => '用户中心-注销',
            ),
            3 =>
            array(
                'folder' => 'member',
                'controller' => 'profile',
                'method' => 'change_pwd',
                'caption' => '用户中心-修改密码',
            ),
            4 =>
            array(
                'folder' => 'member',
                'controller' => 'manage',
                'method' => 'public_go_[0-9+]',
                'caption' => '管理中心-URL转向',
            ),
        ),
    ),
    'moduleMenu' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'moduleMenu',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '菜单管理',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/moduleMenu',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleMenu',
                'method' => 'index',
                'caption' => '菜单管理-列表',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleMenu',
                'method' => 'add',
                'caption' => '菜单管理-新增',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleMenu',
                'method' => 'edit',
                'caption' => '菜单管理-编辑',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleMenu',
                'method' => 'delete',
                'caption' => '菜单管理-删除',
            ),
            4 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleMenu',
                'method' => 'set_menu',
                'caption' => '菜单管理-设置菜单',
            ),
        ),
    ),
    'moduleManage' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'module',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '模块安装管理',
        'description' => '由autoCodeigniter 系统的模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/moduleManage',
        'system' => true,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleManage',
                'method' => 'index',
                'caption' => '模块管理',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'index',
                'caption' => '模块管理-开始',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'check',
                'caption' => '模块管理-检查',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'setup',
                'caption' => '模块管理-安装',
            ),
            4 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'uninstall',
                'caption' => '模块管理-卸载',
            ),
            5 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'reinstall',
                'caption' => '模块管理-重新安装',
            ),
            6 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'moduleInstall',
                'method' => 'delete',
                'caption' => '模块管理-删除',
            ),
        ),
    ),
    'helloWorld' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'helloWorld',
        'modulePath' => 'adminpanel',
        'moduleCaption' => 'Hello World',
        'description' => '这里一个演示模块，来自于吸心大法第三章',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/helloWorld',
        'system' => false,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'helloWorld',
                'method' => 'index',
                'menu_name' => NULL,
                'caption' => NULL,
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'yes',
                'method' => 'delete',
                'caption' => 'yes-删除',
            ),
        ),
    ),
    'news' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'news',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '内容CMS模块',
        'description' => 'Liang - 内容发布模块',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/news',
        'system' => false,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'news',
                'method' => 'nlist',
                'caption' => '内容列表',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'news',
                'method' => 'delete',
                'caption' => '内容系统 - 删除',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'news',
                'method' => 'add',
                'caption' => '内容系统 - 添加',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'news',
                'method' => 'edit',
                'caption' => '内容系统 - 修改',
            ),
        ),
    ),
    'wechat' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'wechat',
        'modulePath' => '',
        'moduleCaption' => '微信前台握手控制器',
        'description' => '微信握手控制器',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => '',
        'system' => false,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => '',
                'controller' => 'wechat',
                'method' => '',
                'caption' => '微信握手控制器',
            ),
        ),
    ),
    'oauth' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015-10-09 20:10:10',
        'moduleName' => 'wechat',
        'modulePath' => '',
        'moduleCaption' => '微信 Oauth 网页认证接口',
        'description' => '微信 Oauth 网页认证接口',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => '',
        'system' => false,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'index',
                'caption' => '微信网页 oauth 认证',
            ),
            1 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'callback',
                'caption' => '微信网页 oauth 视图',
            ),
            2 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'addresults',
                'caption' => '',
            ),
            3 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'viewrank',
                'caption' => '微信网页 oauth 视图',
            ),
            4 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'send',
                'caption' => '发送奖励方法',
            ),
            5 =>
            array(
                'folder' => '',
                'controller' => 'oauth',
                'method' => 'actiondd',
                'caption' => '给用户分组发送消息',
            ),
        ),
    ),
    'WechatSite' =>
    array(
        'version' => '1',
        'charset' => 'utf-8',
        'lastUpdate' => '2015年12月01日',
        'moduleName' => 'moduleMenu',
        'modulePath' => 'adminpanel',
        'moduleCaption' => '微信配置管理',
        'description' => '微信官方接口开发',
        'fileList' => NULL,
        'works' => true,
        'moduleUrl' => 'adminpanel/WechatSite',
        'system' => false,
        'coder' => '啊亮学长',
        'website' => 'http://',
        'moduleDetails' =>
        array(
            0 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'keywords',
                'caption' => '微信-关键字列表',
            ),
            1 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'add',
                'caption' => '微信-关键字列表',
            ),
            2 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'edit',
                'caption' => '微信-关键字列表',
            ),
            3 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'delete',
                'caption' => '微信-关键字列表',
            ),
            4 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'diymenu',
                'caption' => '自定义菜单-列表',
            ),
            5 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'menu_add',
                'caption' => '自定义菜单-添加',
            ),
            6 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'menu_edit',
                'caption' => '自定义菜单-修改',
            ),
            7 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'menu_delete',
                'caption' => '自定义菜单-修改',
            ),
            8 =>
            array(
                'folder' => 'adminpanel',
                'controller' => 'WechatSite',
                'method' => 'class_send',
                'caption' => '自定义菜单-生成',
            ),
        ),
    ),
);

/* End of file aci.php */
/* Location: ./application/config/aci.php */
