<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<META content=text/html;charset=utf-8 http-equiv=Content-Type>
<TITLE>后台</TITLE>


<SCRIPT language="javascript">
function logout(){
	if (confirm("确定要退出管理面板吗？"))
	top.location = "<?php echo U('Tourist/logout');?>";
	return false;
}
function showsubmenu(sid) {
	var whichEl = eval("submenu" + sid);
	var menuTitle = eval("menuTitle" + sid);
	if (whichEl.style.display == "none"){
		eval("submenu" + sid + ".style.display=\"\";");
	}else{
		eval("submenu" + sid + ".style.display=\"none\";");
	}
}
function showsubmenu(sid) {
	var whichEl = eval("submenu" + sid);
	var menuTitle = eval("menuTitle" + sid);
	if (whichEl.style.display == "none"){
		eval("submenu" + sid + ".style.display=\"\";");
	}else{
		eval("submenu" + sid + ".style.display=\"none\";");
	}
}
function chpass(){
	window.parent.window.document.getElementById('main').contentWindow.chpasswd();
}
</SCRIPT>
<link rel="stylesheet" type="text/css" href="/Public/admin/css/header.css" />
<STYLE media=screen>IMG {
	BORDER-RIGHT-WIDTH: 0px; BORDER-TOP-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px
}
</STYLE>

<META name="GENERATOR" content="MCBN">
</HEAD>
<BODY leftMargin="0" topMargin="0">
	<TABLE class="admin_topbg" border="0" cellSpacing="0" cellPadding="0" width="100%" height="40">
	  <TBODY>
		  <TR>
		     <TD height=40 width="61%">
		    	<h2><font color="white"><?php echo ($title); ?>后台</font></h2>
		    </A></TD>
		    <TD vAlign=top width="39%">
		      <TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
		        <TBODY>
		        <TR>
		          <TD height=38 align="right" class=admin_txt>&nbsp;&nbsp; 用户 ：<B><?php echo ($_SESSION["user"]["name"]); ?></B> 您好！
		            
		           <a href="/cleancache.php" target="main"><IMG style="margin-top:5px;position: relative ;top:8px;" border="0" alt="安全退"出 src="/Public/admin/images/clearcache_bnt.jpg"></a>
				    <A onClick="logout();" href="javascript:void(0);"><IMG style="margin-top:5px;position: relative ;top:8px;" border="0" alt="安全退"出 src="/Public/admin/images/tuichu_bnt.jpg"></A>
				  </TD>
		          </TR>
		        <TR>
		        <TD width="3%">&nbsp;</TD>
			</TR></TBODY></TABLE></TD></TR>
		</TBODY>
	</TABLE>

	
<!-- <header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="javascript:;"><?php echo ($title); ?>后台</a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="javascript:;"><?php echo ($title); ?>后台</a>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                   
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo ($_SESSION["user"]["name"]); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                         
                            <li><a onClick="logout();" href="javascript:void(0);">切换账户</a></li>
                            <li><a onClick="logout();" href="javascript:void(0);">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header> -->

</BODY>
</HTML>