<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<META content="text/html; charset=utf-8" http-equiv=Content-Type />
<TITLE>后台管理中心</TITLE>

<script type="text/javascript" src="/Public/admin/js/jquery.js"></script>
<STYLE>
BODY {
	BACKGROUND-COLOR: #E6EDF2;
	MARGIN: 0px;
	FONT: 12px Arial, Helvetica, sans-serif;
	COLOR: #000;
	overflow-x : hidden;   
}

#container {
	WIDTH: 182px;
	margin-left: 1px;
}

H1 {
	LINE-HEIGHT: 20px;
	MARGIN: 0px;
	WIDTH: 182px;
	HEIGHT: 30px;
	FONT-SIZE: 12px;
	CURSOR: pointer
}

H1 A {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bgS.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 30px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	HEIGHT: 30px;
	COLOR: #000;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px;
	moz-outline-style: none
}

.content {
	WIDTH: 182px;
	overflow: hidden;
}

.MM UL {
	PADDING-BOTTOM: 0px;
	LIST-STYLE-TYPE: none;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	PADDING-TOP: 0px
}

.MM LI {
	LINE-HEIGHT: 26px;
	LIST-STYLE-TYPE: none;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	DISPLAY: block;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #333333;
	FONT-SIZE: 12px;
	TEXT-DECORATION: none
}

.MM {
	PADDING-BOTTOM: 0px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	BOTTOM: 0px;
	PADDING-RIGHT: 0px;
	TOP: 0px;
	RIGHT: 0px;
	PADDING-TOP: 0px;
	LEFT: 0px
}

.MM A:link {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bg1.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 26px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #333333;
	FONT-SIZE: 12px;
	OVERFLOW: hidden;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px
}

.MM A:visited {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bg1.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 26px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #333333;
	FONT-SIZE: 12px;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px
}

.MM A:active {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bg1.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 26px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #333333;
	FONT-SIZE: 12px;
	OVERFLOW: hidden;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px
}

.MM A:hover {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bg2.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 26px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #cc0000;
	FONT-SIZE: 12px;
	FONT-WEIGHT: bold;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px
}

.MM A.on {
	BACKGROUND-IMAGE: url(/Public/admin/images/menu_bg2.gif);
	TEXT-ALIGN: center;
	PADDING-BOTTOM: 0px;
	LINE-HEIGHT: 26px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	WIDTH: 182px;
	PADDING-RIGHT: 0px;
	DISPLAY: block;
	BACKGROUND-REPEAT: no-repeat;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	HEIGHT: 26px;
	COLOR: #cc0000;
	FONT-SIZE: 12px;
	FONT-WEIGHT: bold;
	TEXT-DECORATION: none;
	PADDING-TOP: 0px
}
</STYLE>

</head>
<body>
	<div id="container">
		<div class="menu_mcbn">
			<H1 class="type">
				<A href="javascript:void(0)">店铺信息</A>
			</H1>
			<DIV class="content">
				<TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
					<TR>
						<TD><IMG src="/Public/admin/images/menu_topline.gif"
							width="182" height="5"></TD>
					</TR>
				</TABLE>
				<UL class=MM>
					<LI><A href="<?php echo U('Index/main');?>" target="main">信息概览</A></LI>
					<LI><A href="<?php echo U('Index/info');?>" target="main">销售概览</A></LI>
					<LI><A href="<?php echo U('Index/account');?>" target="main">账户信息</A></LI>
					<LI><A href="<?php echo U('Index/merchant');?>" target="main">店铺信息</A></LI>
					<LI><A href="<?php echo U('Index/merchant_video');?>" target="main">导购视频</A></LI>
					<LI><A href="<?php echo U('Index/give_gift');?>" target="main">直播收益</A></LI>
					<LI><A href="<?php echo U('Index/goods_settlement');?>" target="main">结算记录</A></LI>
				</UL>
			</DIV>
		</div>
		
		<div class="menu_mcbn">
			<H1 class="type">
				<A href="javascript:void(0)">商品信息</A>
			</H1>
			<DIV class="content">
				<TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
					<TR>
						<TD><IMG src="/Public/admin/images/menu_topline.gif"
							width="182" height="5"></TD>
					</TR>
				</TABLE>
				<UL class=MM>
					<LI><A href="<?php echo U('Goods/goods_list');?>" target="main">商品列表</A></LI>
					<LI><A href="<?php echo U('Goods/is_del_goods');?>" target="main">已删除商品</A></LI>
					<LI><A href="<?php echo U('Goods/postage');?>" target="main">邮费模版</A></LI>
					
				</UL>
			</DIV>
		</div>
			
		<div class="menu_mcbn">
			<H1 class="type">
				<A href="javascript:void(0)">商户订单信息</A>
			</H1>
			<DIV class="content">
				<TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
					<TR>
						<TD><IMG src="/Public/admin/images/menu_topline.gif"
							width="182" height="5"></TD>
					</TR>
				</TABLE>
				<UL class=MM>
					<LI><A href="<?php echo U('Horder/index');?>" target="main">今日新增</A></LI>
					<LI><A href="<?php echo U('Horder/to_be_pay');?>" target="main">待支付</A></LI>
					<LI><A href="<?php echo U('Horder/to_be_drawer');?>" target="main">待发货</A></LI>
					<LI><A href="<?php echo U('Horder/to_be_accept');?>" target="main">待收货</A></LI>
					<LI><A href="<?php echo U('Horder/to_be_check');?>" target="main">待评价</A></LI>
					<LI><A href="<?php echo U('Horder/complete');?>" target="main">已完成</A></LI>
					<LI><A href="<?php echo U('Horder/to_be_returns');?>" target="main">已退款</A></LI>
					<LI><A href="<?php echo U('Horder/cancel_order');?>" target="main">已取消</A></LI>
					<LI><A href="<?php echo U('Horder/is_del_order');?>" target="main">已删除</A></LI>
					<LI><A href="<?php echo U('Horder/refund');?>" target="main">售后订单</A></LI>
					<LI><A href="<?php echo U('Horder/to_all_order');?>" target="main">全部订单</A></LI>
					
					
				</UL>
			</DIV>
		</div>

		<div class="menu_mcbn">
			<H1 class="type">
				<A href="javascript:void(0)">财务管理</A>
			</H1>
			<DIV class="content">
				<TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
					<TR>
						<TD><IMG src="/Public/admin/images/menu_topline.gif"
							width="182" height="5"></TD>
					</TR>
				</TABLE>
				<UL class=MM>
					<LI><A href="<?php echo U('Caiwu/withdraw');?>" target="main">提现管理</A></LI>
					
				</UL>
			</DIV>
		</div>

	</div>

	<script>
		var con_height_min = "5px";
		$(".type").click(function() {
			var con = $(this).parent().find(".content");
			if (con.css("height") == con_height_min) {
				con.animate({
					height : (con.find(".MM").find("li").length * 28+5) + "px"
				});
			} else {
				con.animate({
					height : con_height_min
				});
			}

		});
	</script>
</BODY>
</HTML>