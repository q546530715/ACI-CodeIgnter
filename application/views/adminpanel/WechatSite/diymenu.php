<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<h3 class="page-header">

    <?php aci_ui_a($folder_name, 'wechatsite', 'menu_add', '', ' class="btn btn-info btn-sm pull-right"', '<span class="glyphicon glyphicon-plus"></span> 添加新菜单') ?>
    自定义菜单生成 
</h3>

<div class="alert alert-info alert-dismissible" role="alert">
    <strong>友情提示</strong> 1级菜单最多只能开启3个，2级子菜单最多开启5个!
</div>
<div class="panel panel-default">
    <div class="table-responsive">
        <form method="post" id="form_list">

            <table class="table table-hover">
                <thead>
                    <tr class="text-center">

                        <th>显示顺序</th>
                        <th>主菜单名称</th>
                        <th>关联关键词</th>
                        <th>是否显示</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <style>
                    .board{
                        background: url("../images/bg_repno.gif") no-repeat scroll 0 0 transparent;
                        padding-left:55px;
                    }
                    td{
                        height:50px;
                        line-height:50px;
                        vertical-align: middle;
                    }
                </style>
                <tbody>
                    <?php foreach ($menudata as $v): ?>
                        <tr class="success">
                            <td><?php echo $v['sort']; ?></td>
                            <td><b><?php echo $v['title']; ?></b></td>
                            <td><?php echo $v['keyword']; ?></td>
                            <td><?php echo $v['is_show']; ?></td>
                            <td><?php aci_ui_a($folder_name, 'wechatsite', 'menu_edit', $v['id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?>

                                <a href="<?php echo base_url("$folder_name/wechatsite/menu_delete/$v[id]/$formhash") ?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> 删除 </a></td>
                        </tr>
                        <?php if (!empty($v['Submenu'])): foreach ($v['Submenu'] as $v): ?>
                                <tr>
                                    <td><?php echo $v['sort']; ?></td>
                                    <td  style="padding-left:30px;"> |---  <?php echo $v['title']; ?></td>
                                    <td><?php echo $v['keyword']; ?></td>
                                    <td><?php echo $v['is_show']; ?></td>
                                    <td><?php aci_ui_a($folder_name, 'wechatsite', 'menu_edit', $v['id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?>
                                        <a href="<?php echo base_url("$folder_name/wechatsite/menu_delete/$v[id]/$formhash") ?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> 删除</a></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </form>
    </div>
    <div class="panel-footer">
        <div class=" text-center" >
            <div class="btn-group">
                <?php aci_ui_a($folder_name, 'wechatsite', 'class_send', '', ' class="btn btn-warning btn-sm pull-right"', '<span class="glyphicon glyphicon-ok"></span> 生成新菜单') ?>
            </div>
        </div>

    </div>
</div>
