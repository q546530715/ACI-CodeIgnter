<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<style>
    .table-width-npy{
        width:20%
    }
</style>
<div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='icon-edit icon-large'></i>
        <?php echo $is_edit ? "编辑" : "添加" ?>自定义菜单
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'wechatsite', 'diymenu', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
            </div>
        </div>
    </div>
    <form method="post" id="form_list">
        <input type="hidden" name="formhash" value="<?php echo $formhash; ?>">
        <table class="table table-hover">
            <tr>
                <td class="table-width-npy">父级菜单:</td>
                <td>
                    <div class="col-sm-4">
                        <select class="form-control" name="pid">


                            <?php if ($menu_info['pid'] > 0): ?>
                                <option value="<?php echo $menu_info['pid']; ?>">保持默认级别</option>                              <?php else: ?>
                                <option value="0">保持默认级别</option>
                            <?php endif; ?>

                            <?php
                            foreach ($parent_menu as $val): if ($menu_info['pid'] == $val['id']):continue;
                                endif;
                                ?>
                                <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>                     
                            <?php endforeach; ?>



                        </select>
                        不选则为默认顶级菜单
                    </div>
                </td>
            </tr>
            <tr>
                <td>主菜单名称：</td>
                <td> <div class="col-sm-4"><input type="text" name="title" value="<?php echo $menu_info['title']; ?>" class="form-control"  placeholder="请输入菜单名称"> </div></td>
            </tr>
            <tr>
                <td>关联关键词：</td>
                <td> <div class="col-sm-4"><input type="text" name="keyword" value="<?php echo $menu_info['keyword']; ?>" class="form-control"> </div></td>
            </tr>
            <tr>
                <td>外链接url：</td>
                <td> <div class="col-sm-4"><input type="text" name="url" value="<?php echo $menu_info['url']; ?>" class="form-control"  placeholder="填写格式:http://www.baidu.com">如无特殊需要，这里请不要填写</div></td>
                
            </tr>
            <tr>
                <td>显示：</td>
                <td>
                    <div class="col-sm-4">
                        <?php if ($menu_info['is_show'] == 0): ?>

                            <label class="radio-inline">
                                <input type="radio" name="is_show" id="is_lock1" value="1"  > 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_show" id="is_lock2" value="0" checked="checked" > 否
                            </label>
                        <?php else: ?>
                            <label class="radio-inline">
                                <input type="radio" name="is_show" id="is_lock1" value="1" checked="checked" > 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_show" id="is_lock2" value="0" > 否
                            </label>
                        <?php endif; ?>

                    </div>
                </td>
            </tr>
            <tr>
                <td>排序：</td>
                <td>
                    <div class="col-sm-4"><input type="text" name="sort"  value="<?php echo $menu_info['sort']; ?>"  class="form-control"> </div>
                </td>
            </tr>
            <tr>
                <td></td><td class="text-left"><input type="submit" class="btn btn-info btn-sm" value="提交"></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>