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

<?php echo W("Easyui");?>
<div class="content">
<!-----------------------------------------内容开始--------------------------------------------------->
<div class="infoBox">
<form name="form" action="/Admin/Member/doupdate"  method="post" >
<input type="hidden" name="id" value="<?php echo ($user["id"]); ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="basic">
 <tr>
                  <td width="18%" class="infoBoxTd">用户名</td>
		  		  <td colspan="2"><input type="text" id="username"  name="username" value="<?php echo ($user["username"]); ?>" size="60">*</td>
                </tr>
               <tr>
                 <td width="18%" class="infoBoxTd">密码</td>
                  <td colspan="2"><input type="password" id="pwd" name="password" value="" size="61">不填写不修改</td>
                </tr>
               <tr>
                 <td width="18%" class="infoBoxTd">再次输入密码</td>
                  <td colspan="2"><input type="password" id="pwd2" name="pwd2" value="" size="61">不填写不修改</td>
                </tr>
               <tr>
                  <td width="18%" class="infoBoxTd">姓名</td>
                 <td colspan="2"><input type="text" id="name" name="name" value="<?php echo ($user["name"]); ?>" size="60">*</td>
                </tr>
                <tr>
                  <td width="18%" class="infoBoxTd">状态</td>
                  <td align="left" >是<input type="radio" id="yes" name="status" value="1" checked="checked" />
					否<input type="radio" name="status" id="no" value="0" /></td>
                </tr>
				<tr>
                  <td width="18%" class="infoBoxTd">角色</td>
                  <td align="left" >
                  	<select name="role" id="roleid">
                  			<?php if(is_array($rlist)): $i = 0; $__LIST__ = $rlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><option value="<?php echo ($r["id"]); ?>"><?php echo ($r["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                  		</select>
                  </td>
                </tr>
</table>
			<script type="text/javascript">
			var roleid = "<?php echo ($user["roleid"]); ?>";
			if(roleid!=""){
				$("#roleid").val(roleid);
			}
			
			</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="infoBoxTd">&nbsp;</td>
<td align="left"><input type="submit" name="submit" value="保存" class="formInput01" /></td>
</tr>
</table>
</form>
</div>
<!-----------------------------------------内容结束--------------------------------------------------->
</div>
    
    
    
    
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