<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<form class="form-horizontal" method="post" action="<?php echo current_url() ?>" >
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            <?php echo $is_edit ? "编辑" : "添加" ?>关键字
            <div class='panel-tools'>

                <div class='btn-group'>
                    <?php aci_ui_a($folder_name, 'wechatsite', 'keywords', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
                </div>
            </div>
        </div>
        <div class='panel-body'>
            <fieldset>
                <legend>基本信息</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label" ><b style="color:red">关键字</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="keyword"  class="form-control validate[required]"  placeholder="请输入响应关键字" value="<?php echo $data_info['keyword']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-2 control-label">关键字描述</label>
                    <div class="col-sm-4">
                        <input name="name" type="text" class="form-control validate[equals[password]]" value="<?php echo $data_info['name']; ?>" />
                    </div>
                </div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">消息类型</label>

                    <div class="col-sm-5">
                        <?php if ($data_info['type'] == 2): ?>   
                            <label class=" control-label">
                                <input type="radio" name="type" value="1"  onClick="show(this)"  />文字</label>&nbsp;&nbsp;
                            <label class="control-label"><input type="radio" checked="checked" name="type"value="2" onClick="show(this)"  />图文</label>

                        <?php else: ?>

                            <label class=" control-label">
                                <input type="radio" name="type" value="1" checked="checked" onClick="show(this)"  />文字</label>&nbsp;&nbsp;
                            <label class="control-label"><input type="radio"  name="type"value="2" onClick="show(this)"  />图文</label>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="form-group" id="contents" >
                    <label class="col-sm-2 control-label">回复内容</label>
                    <div class="col-sm-6">
                        <textarea name="contents" rows="6" cols="43"><?php echo $data_info['contents']; ?></textarea>
                    </div>
                </div>

                <div class="form-group" id="news_title" style="display:none">
                    <label  class="col-sm-2 control-label">图文标题</label>
                    <div class="col-sm-4">
                        <input name="news_title" type="text"  class="form-control validate[equals[password]]" value="<?php echo $data_info['news_title']; ?>" />
                    </div>
                </div>

                <div class="form-group" id="news_desc" style="display:none">
                    <label class="col-sm-2 control-label">图文描述</label>
                    <div class="col-sm-6">
                        <textarea name="news_desc" rows="6" cols="43"><?php echo $data_info['news_desc']; ?></textarea>
                    </div>
                </div>

                <div class="form-group" id="news_url" style="display:none;">
                    <label  class="col-sm-2 control-label">图文链接</label>
                    <div class="col-sm-4">
                        <input name="news_url" type="text" class="form-control validate[equals[password]]" value="<?php echo $data_info['news_url']; ?>" />
                    </div>
                </div>


                <div class="form-group" id="news_imgurl" style="display:none">
                    <label class="col-sm-2 control-label">图文图片</label>
                    <div class="col-sm-9">
                        <img  width="100" id="thumb_SRC" border="1" src="<?php echo $this->method_config['upload']['thumb']['upload_url'] ?><?php echo $data_info['thumb'] ?>"/>
                        <input type="hidden" id="thumb" name="thumb" value="<?php echo $data_info['thumb'] ?>" /> 
                        <?php aci_ui_a('', '', '', '', ' class="btn btn-default btn-sm uploadThumb_a"', '选择图片 ...') ?><span class="help-block">只支持图片上传.</span>
                    </div>
                </div>


            </fieldset>


            <input type="hidden" name="formhash" value="<?php echo $formhash; ?>">
            <div class='form-actions'>
                <?php aci_ui_button($folder_name, 'news', 'add', ' type="submit" class="btn btn-primary " ', '保存') ?>
            </div>
        </div>
</form>


<script language="javascript" type="text/javascript">



    function show(obj) {
        if (obj.value == '1') {
            document.getElementById('contents').style.display = "";
            document.getElementById('news_imgurl').style.display = "none";
            document.getElementById('news_title').style.display = "none";
            document.getElementById('news_desc').style.display = "none";
            document.getElementById('news_url').style.display = "none";
        } else {
            document.getElementById('contents').style.display = "none";
            document.getElementById('news_imgurl').style.display = "block";
            document.getElementById('news_title').style.display = "";
            document.getElementById('news_desc').style.display = "";
            document.getElementById('news_url').style.display = "";
        }
    }
<?php if ($data_info['type'] == 2): ?>
        show(2);
<?php endif; ?>

    var edit = <?php echo $is_edit ? "true" : "false" ?>;
    var folder_name = "<?php echo $folder_name ?>";
    function getThumb(v, s, w, h) {
        $("#thumb").val(v);
        $("#thumb_SRC").attr("src", "<?php echo $this->method_config['upload']['thumb']['upload_url'] ?>" + v);
        $("#dialog").dialog("close");
    }

    require(['<?php echo SITE_URL ?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL ?>scripts/<?php echo $folder_name ?>/<?php echo $controller_name ?>/edit.js']);
    });
</script>
