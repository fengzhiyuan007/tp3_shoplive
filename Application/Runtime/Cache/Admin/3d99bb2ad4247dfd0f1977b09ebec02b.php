<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>BLUSECMS</title>

<meta name="GENERATOR" content="MCBN">


<link rel="stylesheet" type="text/css" href="/Public/admin/css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/H-ui.min.css" />

<link rel="stylesheet" type="text/css" href="/Public/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/common/mypage.css" /><!-- 分页样式css -->

<script type="text/javascript" src="/Public/admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/common/js/zczy-UI.js"></script>
<script type="text/javascript" src="/Public/admin/js/common.js"></script>
<script type="text/javascript" src="/Public/common/kindeditor/kindeditor.js"></script>

	<link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
	<script type="text/javascript" src="/Public/layui/layui.js"></script>

	<script type="text/javascript" src="/Public/admin/layer/layer.js"></script>

	<script src="/Public/admin/player/sewise.player.min.js"></script>


<link href="/Public/home/css/qikoo.css" type="text/css" rel="stylesheet" />
<link href="/Public/home/css/store.css" type="text/css" rel="stylesheet" />

<!--升级后台框架-->
<link href="/Public/h-ui/css/H-ui.min.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/css/H-ui.admin.css" type="text/css" rel="stylesheet" />
<link href="/Public/Hui-iconfont/1.0.7/iconfont.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/skin/default/skin.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/css/style.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="/Public/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/h-ui.admin/js/H-ui.admin.js"></script>

<!--升级后台框架-->

<script type="text/javascript" src="/Public/home/js/qikoo.js"></script>

<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    var editor = new UE.ui.Editor();
    $(document).keydown(function(event){
          switch(event.keyCode){
             case 13:return false; 
             }
      });
</script>

</head>
<body>
	

	<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
		<TBODY>
			<TR>
				<TD vAlign=top background="/Public/admin/images/mail_leftbg.gif"
					width="17"><IMG
					src="/Public/admin/images/left-top-right.gif" width="17"
					height="29"></TD>
				<TD vAlign="top" background="/Public/admin/images/content-bg.gif">
					<TABLE id="table2" class="left_topbg" border="0" cellSpacing="0"
						cellPadding="0" width="100%" height="31">
						<TBODY>
							<TR>
								<TD height="31">
									<DIV class="titlebt">

										<?php if($pagetitle == ''): ?>系统基本信息 <?php else: ?>
										<?php echo ($pagetitle); endif; ?>

									</DIV>
								</TD>
							</TR>
						</TBODY>
					</TABLE>
				</TD>
				<TD vAlign="top"
					background="/Public/admin/images/mail_rightbg.gif" width="16">
					<IMG src="/Public/admin/images/nav-right-bg.gif" width="16"
					height="29">
				</TD>
			</TR>
			<TR>
				<TD vAlign="center"
					background="/Public/admin/images/mail_leftbg.gif">&nbsp;</TD>
				<TD align="left" vAlign="top" bgColor="#f7f8f9">

<style>
    .ctextarea {
        /*height: 100px;*/
        resize: none;
        font-size: 14px;
        padding: 4px;
    }
</style>
<body>
<div class="page-container">
    <div id="big"></div>
    <div id="big2"></div>
    <form class="form form-horizontal" id="form" method="post">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="class_name" class="input-text" value="<?php echo ($re['class_name']); ?>" placeholder="子分类名" id="class_name" />
            </div>
        </div>
        <!-- <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>字体颜色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="class_color" class="input-text" value="<?php echo ($re['class_color']); ?>" placeholder="分类颜色" id="class_color" />
                <sapn>省略＃的颜色编码!</sapn>
            </div>
        </div> -->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re['class_img']); ?>');background-size: 220px 160px;" >
                    <div class="instructions" onclick="del_image('1')">删除</div>
                    <div id="uparea1"></div>
                    <input type="hidden" name="class_img" id="image_1" value="<?php echo ($re['class_img']); ?>" />
                    <input type="hidden" name="class_imgs" id="image_11" value="<?php echo ($re['class_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">建议尺寸750*350,图片小于2M</div>
                </div>
            </div>
        </div>
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>分类类型：</label>-->
            <!--<div class="formControls col-xs-8 col-sm-9" style="display: inline-block">-->
                <!--<select name="class_type" class="select input-text">-->
                    <!--<option value="home" {if condition="$re['class_type'] eq 'home' "}selected{/if}>首页分类</option>-->
                    <!--<option value="class"{if condition="$re['class_type'] eq 'class'"}selected{/if}>普通分类</option>-->
                <!--</select>-->
            <!--</div>-->
        <!--</div>-->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">简介：</label>
            <div class="formControls col-xs-4 col-sm-9">
                <textarea name="class_desc" cols="" rows="" style="height: 40px;" class="textarea"  placeholder="说点什么...最少输入3个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,100)"><?php echo ($re["class_desc"]); ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">banner图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="droparea spot" id="image2" style="background-image: url('<?php echo ($re['template_img']); ?>');background-size: 220px 160px;" >
                    <div class="instructions" onclick="del_image('2')">删除</div>
                    <div id="uparea2"></div>
                    <input type="hidden" name="template_img" id="image_2" value="<?php echo ($re['template_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">建议尺寸750*350,图片小于2M</div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>权重排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="sort" class="input-text" value="<?php echo ($re['sort']); ?>" placeholder="权重排序" id="sprt" />
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="hidden" name="parent_id" id="parent_id" value="<?php echo ($_GET['cate_id']); ?>" />
                <input type="hidden" name="class_uuid" id="class_uuid" value="<?php echo ($re["class_uuid"]); ?>" />
                <input type="hidden" class="input-text" value="<?php echo ($re['class_id']); ?>" placeholder=""  name="class_id">
                <button type="submit" class="submit btn btn-primary radius"  type="button"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                <!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    

        KindEditor.ready(function(K) {
            K.create('#image_1');
            var editor = K.editor({
                allowFileManager : true,
                uploadJson:"<?php echo U('Common/upload');?>"
                //sdl:false
            });
            K('#uparea1').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_1').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_1').val(url);
                            K('#image_11').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea2').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_2').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image2').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_2').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

        });

        // $(".submit").click(function(){
        //     commonAjaxSubmit('','form');
        //     return false;
        // });

        $("#uparea1").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_1').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_1').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea1").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea2").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_2').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_2').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea2").mouseout(function(){
            $("#big").hide();
        });


        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
   
    function area_linke1(value){
        $.post("<?php echo U('get_area');?>", {value:value,type:1}, function(v){
            $("#shi").html(v);
        });
    }
    function area_linke2(value) {
        $.post("<?php echo U('get_area');?>", {value: value, type: 2}, function (v) {
            $("#qu").html(v);
        });
    }

</script>
<!--/请在上方写此页面业务相关的脚本-->
    
    
    
    
    </TD><TD background="/Public/admin/images/mail_rightbg.gif">&nbsp;</TD>
</TR>
<TR>
    <TD vAlign="bottom" background="/Public/admin/images/mail_leftbg.gif">
    <IMG src="/Public/admin/images/buttom_left2.gif" width="17" height="17"></TD>
    <TD background="/Public/admin/images/buttom_bgs.gif">
    <IMG src="/Public/admin/images/buttom_bgs.gif" width="17" height="17"></TD>
    <TD vAlign="bottom" background="/Public/admin/images/mail_rightbg.gif">
    <IMG src="/Public/admin/images/buttom_right2.gif" width="16" height="17">
    </TD>
</TR>

</TBODY>
</TABLE>
</body>
</html>