<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<form class="form-horizontal" method="post" action="<?php echo current_url() ?>" >
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            <?php echo $is_edit ? "编辑" : "添加" ?>文章
            <div class='panel-tools'>

                <div class='btn-group'>
                    <?php aci_ui_a($folder_name, 'news', 'nlist', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
                </div>
            </div>
        </div>
        <div class='panel-body'>
            <fieldset>
                <legend>基本信息</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章标题</label>
                    <div class="col-sm-4">
                        <input type="text" name="news_title"  id="news_title"  class="form-control validate[required]"  placeholder="请输入文章标题" value="<?php echo $data_info['news_title'];?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label  class="col-sm-2 control-label">公众号链接</label>
                    <div class="col-sm-4">
                        <input name="public_url" type="text" class="form-control validate[equals[password]]" value="<?php echo $data_info['public_url'];?>" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章内容</label>
                    <div class="col-sm-4">
                        <textarea name="news_content"><?php echo $data_info['news_content'];?></textarea>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label  class="col-sm-2 control-label">阅读原文链接</label>
                    <div class="col-sm-4">
                        <input name="news_original_url" type="text" class="form-control validate[equals[password]]" value="<?php echo $data_info['news_original_url'];?> "/>
                    </div>
                </div>
                
            </fieldset>
            
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <div class='form-actions'>
                <?php aci_ui_button($folder_name, 'news', 'add', ' type="submit" class="btn btn-primary " ', '保存') ?>
            </div>
        </div>

</form>
