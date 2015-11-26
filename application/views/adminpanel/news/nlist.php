<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<h3 class="page-header">

    <?php aci_ui_a($folder_name, 'news', 'add', '', ' class="btn btn-info btn-sm pull-right "', '<span class="glyphicon glyphicon-plus"></span> 添加') ?>

    内容管理系统 
</h3>
<div class="alert alert-success alert-dismissible" role="alert">
    <strong>友情提示</strong> 删除后不可恢复,操作之前请谨慎处理.
</div>
<div class="panel panel-default">
    <div class="table-responsive">
        <form method="post" id="form_list">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>文章标题</th>
                        <th>拇指赞</th>
                        <th>发布时间</th>
                         <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $k => $v): ?>
                        <tr>
                            <td><input type="checkbox" name="pid[]" value="<?php echo $v['news_id']; ?>"/></td>
                            <td><?php echo $v['news_title']; ?></td>
                            <td><?php echo $v['news_thumb']; ?></td>
                            <td><?php echo date('Y-m-d', $v['news_time']); ?></td>
                            <td><?php aci_ui_a($folder_name, 'news', 'edit', $v['news_id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
    <div class="panel-footer">
        <div class="pull-left">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="reverseBtn"><span
                        class="glyphicon glyphicon-ok"></span> 反选
                </button>
                <?php aci_ui_button($folder_name, 'news', 'delete', ' class="btn btn-default" id="deleteBtn" ', '<span class="glyphicon glyphicon-remove"></span> 删除勾选') ?>
            </div>
        </div>
        <div class="pull-right">
        </div>
    </div>


</div>

 <script language="javascript" type="text/javascript">
        require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
            require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
        });
</script>