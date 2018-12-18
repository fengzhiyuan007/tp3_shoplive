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
        <div class="row cl" style="padding-left: 320px">
            <span style="font-size: 20px;">账户信息</span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>开户姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="realname" class="input-text" value="<?php echo ($re['realname']?$re['realname']:''); ?>" placeholder="" id="realname" style="width: 50%"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>银行卡账号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="bank_card" class="input-text" value="<?php echo ($re['bank_card']?$re['bank_card']:''); ?>" placeholder="" id="bank_card" style="width: 50%"/>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>开户银行：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="bank_name" class="input-text" value="<?php echo ($re['bank_name']?$re['bank_name']:''); ?>" placeholder="" id="bank_name" style="width: 50%"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>开户信息：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="message" class="input-text" value="<?php echo ($re['message']?$re['message']:''); ?>" placeholder="" id="message" style="width: 50%"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系方式：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="phone" class="input-text" value="<?php echo ($re['phone']?$re['phone']:''); ?>" placeholder="" id="phone" style="width: 50%"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>登陆密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" name="pwd" class="input-text" value="<?php echo ($re['pwd']?$re['pwd']:''); ?>" placeholder="" id="pwd" style="width: 50%"/>
            </div>
        </div>
        <div class="val_icon row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>验证码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="verify_code" id="verify_code" placeholder="验证码" maxlength="6" class="login_txtbx input-text" style="width:25%;">
                <button type="button" class="hqcode" style="margin-left:35px;height:30px;width: 110px;cursor: pointer;vertical-align: middle;">获取验证码</button>
            </div>
        </div>  
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button  class="submit btn btn-primary radius"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                <input type="hidden" class="input-text" value="<?php echo ($re["member_id?$re"]["member_id:''"]); ?>" placeholder=""  name="mid">
            </div>
        </div>
    </form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
        $(".hqcode").click(function(){
            settime($(this));
        });
        var countdown=60;
        var isajax=0;
        function settime(obj) {
            console.log(countdown);
            check=/^13[0-9]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}|^17[0-9]\d{8}$/;
            if (check.test($("#phone").val())) {
                if (countdown == 0) {
                    obj.removeAttr("disabled");
                    obj.text("重新发送");
                    isajax = 0;
                    countdown = 60;
                    obj.css("background-color",'#50b5a2');
                    return;
                } else {
                    if(countdown<60){
                        countdown--;
                        obj.attr("disabled", true);
                        obj.text("获取验证码(" + countdown + ")");
                        obj.css("background-color",'#a1aba9');
                    }else{
                        console.log(countdown);
                        if (isajax == 0) {
                            $.ajax({
                                url: "<?php echo U('Index/sendSMS');?>",
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    mobile: $("#phone").val()
                                },
                                success: function (data) {
                                    if (data['status'] == 'error') {
                                        layer.msg(data.data, {icon: 5, time: 1000});
                                    } else {
                                        obj.attr("disabled", true);
                                        countdown--;
                                        obj.text("获取验证码(" + countdown + ")");
                                        obj.css("background-color", '#a1aba9');
                                        isajax = 1;
                                        console.log(countdown);
                                    }
                                },
                                error: function (data) {
                                    layer.msg('发送失败', {icon: 5, time: 1000});
                                }
                            });
                        }
                    }
                    setTimeout(function () {
                        if(countdown<60) {
                            settime(obj);
                        }
                    }, 1000)
                }
            } else
            {
                layer.msg('手机输入有误',{icon:5,time:1000});
            }
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