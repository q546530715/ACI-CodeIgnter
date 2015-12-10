<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-th-list'></i> 关键字列表
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'WechatSite', 'add', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-plus"></span> 添加'); ?>
            </div>
            <div class='badge'><?php echo count($data_list) ?></div>
        </div>
    </div>

    <form method="post" id="form_list">
        <input type="hidden" name="formhash" value="<?php echo $formhash; ?>">
        <?php if ($data_list): ?>
            <div class='panel-body '>
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>关键字</th>
                            <th>使用描述</th>
                            <th>消息类型</th>
                            <th>统计次数</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data_list as $k => $v):
                            if ($v['type'] == 1):
                                $type = '文字';
                            elseif ($v['type'] == 2):
                                $type = '图文';
                            endif;
                            ?>
                            <tr>
                                <?php if ($v['id'] == 1 || $v['id'] == 2): ?>

                                    <td><strong> <span style="color:red">不允许删除</span></strong></td>
                                    <td><?php echo $folder_name;?></td>  
                                <?php else: ?>
                                    <td><input type="checkbox" name="pid[]" value="<?php echo $v['id'] ?>"/></td>                         
                                    <td></td>  
                                <?php endif; ?>

                                <td><?php echo $v['keyword'] ?></td>
                                <td><?php echo $v['name'] ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $v['count'] ?></td>
                                <td>
                                    <?php aci_ui_a($folder_name, 'WechatSite', 'edit', $v['id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

            <div class="panel-footer">
                <div class="pull-left">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="reverseBtn"><span
                                class="glyphicon glyphicon-ok"></span> 反选
                        </button>

                        <?php aci_ui_button($folder_name, 'user', 'delete', ' class="btn btn-default" id="deleteBtn" ', '<span class="glyphicon glyphicon-remove"></span> 删除勾选') ?>
                    </div>
                </div>
                <div class="pull-right">
                    <?php echo $pages; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning" role="alert"> 暂无数据显示... 您可以进行新增操作</div>
        <?php endif; ?>
    </form>
</div>
</div>



<script language="javascript" type="text/javascript">
    var folder_name = "<?php echo $folder_name ?>";
    require(['<?php echo SITE_URL ?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL ?>scripts/<?php echo $folder_name ?>/<?php echo $controller_name ?>/index.js']);
    });
</script>

