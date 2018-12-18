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

<script type="text/javascript" src="/Public/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/Public/zTree/js/jquery.ztree.excheck.js"></script>

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


<div class="page-container">
    <div id="big"></div>
    <div id="big2"></div>
    <form class="form form-horizontal" id="form" method="post">
        <div class="row cl" style="text-align: center">
            <span style="font-size: 20px;">商户入驻提交信息如下</span>
        </div>
        
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>店铺名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo ($re['merchants_name']?$re['merchants_name']:''); ?>"  id="merchants_name" name="merchants_name" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>联系人姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="contact_name" class="input-text" value="<?php echo ($re['contact_name']?$re['contact_name']:''); ?>"  id="contact_name" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>联系电话：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo ($re['contact_mobile']?$re['contact_mobile']:''); ?>"  id="contact_mobile" name="contact_mobile" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>公司名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="company_name" class="input-text" value="<?php echo ($re['company_name']?$re['company_name']:''); ?>"  id="company_name" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>公司电话：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo ($re['company_mobile']?$re['company_mobile']:''); ?>"  id="company_mobile" name="company_mobile" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>平台对商户抽成比：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" readonly min="0" max="100" step="0.01" class="input-text" value="<?php echo ($re['merchants_per']?$re['merchants_per']:''); ?>"  id="merchants_per" name="merchants_per" />&nbsp;&nbsp;%
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>商户对主播分成比：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" type="number" min="0" max="100" step="0.01" class="input-text" value="<?php echo ($re['goods_per']?$re['goods_per']:''); ?>"  id="goods_per" name="goods_per" />&nbsp;&nbsp;%
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box" style="width: 33%">
                    <select name="sheng" onchange="area_linke1(this.value)" class="select">
                        <option value="">请选择</option>
                        <?php if(is_array($sheng)): $i = 0; $__LIST__ = $sheng;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l["id"]); ?>" <?php if( $re["merchants_province"] == $l["name"] ): ?>selected<?php else: endif; ?>><?php echo ($l["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
				</span>
                <span class="select-box" style="width: 33%">
                    <select name="shi" id="shi" onchange="area_linke2(this.value)" class="select">
                            <option value=''>请选择（市）</option>
                            <?php if(is_array($re["shi"])): $i = 0; $__LIST__ = $re["shi"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["city_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
                <span class="select-box" style="width: 33%">
                    <select name="qu" id="qu" class="select">
                        <option value=''>请选择（区/县）</option>
                        <?php if(is_array($re["qu"])): $i = 0; $__LIST__ = $re["qu"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["area_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>店铺地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo ($re['merchants_address']?$re['merchants_address']:''); ?>"  id="merchants_address" name="merchants_address" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>店铺图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re["merchants_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">店铺图片</div>
                    <div id="uparea1"></div>
        <input type="hidden" name="content" id="content" value="" />

                    <input type="hidden" name="merchants_img" id="image_1" value="<?php echo ($re['merchants_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>法人照片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="droparea spot" id="image2" style="background-image: url('<?php echo ($re["legal_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">法人照片</div>
                    <div id="uparea2"></div>
                    <input type="hidden" name="legal_img" id="image_2" value="<?php echo ($re['legal_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
                <div class="droparea spot" id="image3" style="background-image: url('<?php echo ($re["legal_face_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">正面照</div>
                    <div id="uparea3"></div>
                    <input type="hidden" name="legal_face_img" id="image_3" value="<?php echo ($re['legal_face_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
                <div class="droparea spot" id="image4" style="background-image: url('<?php echo ($re["legal_opposite_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">反面照</div>
                    <div id="uparea4"></div>
                    <input type="hidden" name="legal_opposite_img" id="image_4" value="<?php echo ($re['legal_opposite_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
                <div class="droparea spot" id="image5" style="background-image: url('<?php echo ($re["legal_hand_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">手持照</div>
                    <div id="uparea5"></div>
                    <input type="hidden" name="legal_hand_img" id="image_5" value="<?php echo ($re['legal_hand_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>营业执照：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="droparea spot" id="image6" style="background-image: url('<?php echo ($re["business_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">营业执照三证合一</div>
                    <div id="uparea6"></div>
                    <input type="hidden" name="business_img" id="image_6" value="<?php echo ($re['business_img']); ?>" />
                    <div class="instructions" style="top: 135px;color: red;">图片小于2M</div>
                </div>
                
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">店铺简介：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="merchants_content" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"><?php echo ($re["merchants_content"]); ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="hidden">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商家直播收益(%)：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" readonly value="<?php echo ($re['dashang_scale']?$re['dashang_scale']:''); ?>" placeholder="默认平台设置商家直播收益比<?php echo ($re['sell_scale']); ?>%" id="tv_dashang_scale" name="dashang_scale" style="width: 50%;background: #cccccc"/>&nbsp;%
                </div>
            </div>
            
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>平台销售提成(%)：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" readonly  value="<?php echo ($re['sell_scale']?$re['sell_scale']:''); ?>" placeholder="默认平台设置商家销售提成比<?php echo ($re['sell_scale']); ?>%" id="sell_scale" name="sell_scale" style="width: 50%;background: #cccccc"/>&nbsp;%
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
            <div class="formControls co(l-xs-8 col-sm-9">
                <?php if(is_array($parent_class)): $k = 0; $__LIST__ = $parent_class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><input name="goods_class[]" type="checkbox" <?php if($k > 1): ?>style="margin-top:1px;margin-left:10px;"<?php else: ?>style="margin-top:1px;"<?php endif; ?> <?php if(in_array($vo['class_id'],$merchant_class)): ?>checked<?php endif; ?> value="<?php echo ($vo['class_id']); ?>"><span style="margin-left: 5px;"><?php echo ($vo["class_name"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>支付状态：</label>
            <div class="formControls col-xs-8 col-sm-9" style="display: inline-block">
                <select name="" class="select input-text"  disabled>
                    <option value="0" <?php if( $re['pay_state'] == 0 ): ?>selected<?php endif; ?>>未支付</option>
                    <option value="1" <?php if( $re['pay_state'] == 1 ): ?>selected<?php endif; ?>>已支付</option>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>审核状态：</label>
            <div class="formControls col-xs-8 col-sm-9" style="display: inline-block">
                <select name="" class="select input-text"  disabled>
                    <option value="1" <?php if( $re['apply_state'] == 1 ): ?>selected<?php endif; ?>>审核中</option>
                    <option value="2" <?php if( $re['apply_state'] == 2 ): ?>selected<?php endif; ?>>审核通过</option>
                    <option value="3" <?php if( $re['apply_state'] == 3 ): ?>selected<?php endif; ?>>拒绝</option>
                </select>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button  class="submit btn btn-primary radius"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                <!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                <input type="hidden" class="input-text" value="<?php echo ($re["merchants_id"]); ?>" placeholder=""  name="merchants_id">
            </div>
        </div>
        <div class="row cl">
            <div class="formControls col-xs-8 col-sm-9" style="display: inline-block">
                注：重新提交后系统将重新审核店铺资质，请谨慎操作！
            </div>
        </div>
    </form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
        var  content ;
        KindEditor.ready(function(K) {
            content = K.create('#content',{
                allowFileManager : true,
                uploadJson:"<?php echo U('Common/upload');?>"
            });
        });

        KindEditor.ready(function(K) {
            K.create();
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
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea2').click(function() {
                console.log(1);
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

            K('#uparea3').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_3').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image3').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_3').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea4').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_4').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image4').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_4').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea5').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_5').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image5').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_5').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#uparea6').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_6').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image6').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_6').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea7').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_7').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image7').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_7').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea8').click(function() {
                console.log(1);
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_8').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image8').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_8').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

        });


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

        $("#uparea3").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_3').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_3').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea3").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea4").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_2').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_4').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea4").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea5").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_5').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_5').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea5").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea6").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_6').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_6').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea6").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea7").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_7').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_7').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea7").mouseout(function(){
            $("#big").hide();
        });

        $("#uparea8").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_8').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_8').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea8").mouseout(function(){
            $("#big").hide();
        });


        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    function area_linke1(value){
        $.post("<?php echo U('Index/get_area');?>", {value:value,type:1}, function(v){
            $("#shi").html(v);
        });
    }
    function area_linke2(value) {
        $.post("<?php echo U('Index/get_area');?>", {value: value, type: 2}, function (v) {
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