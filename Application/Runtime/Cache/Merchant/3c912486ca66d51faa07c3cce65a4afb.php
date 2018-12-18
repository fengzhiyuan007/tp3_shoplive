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

<link href="/Public/admin/css/amazeui.css" type="text/css" rel="stylesheet" />
<link href="/Public/admin/css/admin.css" type="text/css" rel="stylesheet" />

<style type="text/css">
    ul{
        margin: 0 0 0 0;
    }
</style>
<div class="am-cf admin-main">
    <div class=" admin-content">
        <div style="overflow-x: hidden">
            <div class="admin-index">
                <dl data-am-scrollspy="{animation: 'slide-right', delay: 100}">
                    <a href="<?php echo U('merchant/horder/to_be_pay');?>">
                        <dt style="background-color: #42cac0"><i class="Hui-iconfont">&#xe620;</i></dt>
                        <dd style="color: #333"><?php echo ((isset($wait_pay_count) && ($wait_pay_count !== ""))?($wait_pay_count):'0'); ?></dd>
                        <dd class="f12" style="color: #333">待支付</dd>
                    </a>
                </dl>
                <dl data-am-scrollspy="{animation: 'slide-right', delay: 600}">
                    <a href="<?php echo U('horder/to_be_drawer');?>">
                        <!--<dt style="background-color: #f8d347"><img style="height: 90px;width: 120px" src="/static/Img/shouyi.png"></dt>-->
                        <dt style="background-color: #f8d347"><i class="Hui-iconfont">&#xe620;</i></dt>
                        <dd style="color: #333"><?php echo ((isset($wait_send_count) && ($wait_send_count !== ""))?($wait_send_count):'0'); ?></dd>
                        <dd class="f12" style="color: #333">待发货</dd>
                    </a>
                </dl>
                <dl data-am-scrollspy="{animation: 'slide-right', delay: 300}">
                    <a href="<?php echo U('horder/to_be_accept');?>">
                        <!--<dt style="background-color: #ff6c60"><img style="height: 90px;width: 120px" src="/static/Img/shangjia.png"></dt>-->
                        <dt style="background-color: #ff6c60"><i class="Hui-iconfont">&#xe627;</i></dt>
                        <dd style="color: #333"><?php echo ((isset($wait_receive_count) && ($wait_receive_count !== ""))?($wait_receive_count):'0'); ?></dd>
                        <dd class="f12" style="color: #333">待收货</dd>
                    </a>
                </dl>
                <dl data-am-scrollspy="{animation: 'slide-right', delay: 900}">
                    <a href="<?php echo U('horder/to_be_check');?>">
                    <!--<dt style="background-color: #57c8f2"><img style="height: 90px;width: 120px" src="/static/Img/shouyi.png"></dt>-->
                    <dt style="background-color: #57c8f2"><i class="Hui-iconfont">&#xe628;</i></dt>
                    <dd style="color: #333"><?php echo ((isset($wait_assessment_count) && ($wait_assessment_count !== ""))?($wait_assessment_count):'0'); ?></dd>
                    <dd class="f12" style="color: #333">待评价</dd>
                    </a>
                </dl>
            </div>
            <div class="admin-biaoge">
                <div class="hidden">
                    <div class="xinxitj hidden" style=""><h3>商家信息</h3></div>
                    <table class="am-table">
                        <thead>
                        <tr>
                            <th>店铺名称</th>
                            <th>联系方式</th>
                            <th>订单金额:单位(¥)</th>
                            <th>结算金额:单位(¥)</th>
                            <th>提现金额:单位(¥)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo ($merchants["merchants_name"]); ?></td>
                            <td><?php echo ($merchants["contact_mobile"]); ?></td>
                            <td><?php echo ((isset($order_count2) && ($order_count2 !== ""))?($order_count2):'0'); ?></td>
                            <td><?php echo ((isset($order_count3) && ($order_count3 !== ""))?($order_count3):'0'); ?></td>
                            <td><?php echo ((isset($total_withdraw) && ($total_withdraw !== ""))?($total_withdraw):'0'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="xinxitj" style=""><h3>直播信息</h3></div>
                <table class="am-table">
                    <thead>
                    <tr>
                        <th>直播次数</th>
                        <th>粉丝数</th>
                        <th>关注数</th>
                        <th>收益额:单位(钻石)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo ((isset($live_count) && ($live_count !== ""))?($live_count):'0'); ?></td>
                        <td><?php echo ((isset($fans_count) && ($fans_count !== ""))?($fans_count):'0'); ?></td>
                        <td><?php echo ((isset($follow_count) && ($follow_count !== ""))?($follow_count):'0'); ?></td>
                        <td><?php echo ((isset($merchant["get_money"]) && ($merchant["get_money"] !== ""))?($merchant["get_money"]):'0'); ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="xinxitj" style=""><h3>商户订单信息</h3></div>
                <table class="am-table">
                    <thead>
                    <tr>
                        <th>总订单数</th>
                        <th>未支付数</th>
                        <th>退款总数</th>
                        <th>结算总数</th>
                        <th>售后总数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo ((isset($order_count1) && ($order_count1 !== ""))?($order_count1):'0'); ?></td>
                        <td><?php echo ((isset($order_count4) && ($order_count4 !== ""))?($order_count4):'0'); ?></td>
                        <td><?php echo ((isset($order_count5) && ($order_count5 !== ""))?($order_count5):'0'); ?></td>
                        <td><?php echo ((isset($order_count6) && ($order_count6 !== ""))?($order_count6):'0'); ?></td>
                        <td><?php echo ((isset($order_count7) && ($order_count7 !== ""))?($order_count7):'0'); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="shuju">
                <!-- <div class="hd" style="margin-bottom: 10px;"><h3>商家直播收益</h3></div>
                <div class="shujuone">
                    <dl>
                        <dt>钻石总收益:&nbsp;<?php echo ((isset($total_income) && ($total_income !== ""))?($total_income):'0'); ?>钻石</dt>
                        
                        <dt>可提现钻石:&nbsp;<?php echo ((isset($merchant['get_money']) && ($merchant['get_money'] !== ""))?($merchant['get_money']):'0'); ?>钻石
                            <a href="<?php echo U('caiwu/to_withdraw_ticket');?>">
                                <button type="submit" class="submit btn btn-primary radius"  name="">去提现</button>
                            </a>
                        </dt>
                        <dt>预估可提现金额:&nbsp;<?php echo ((isset($cash_money) && ($cash_money !== ""))?($cash_money):'0'); ?>元</dt>
                    </dl>
                    <ul style="margin-top: 5px;">
                        <h2>￥<?php echo ((isset($total_withdraw1) && ($total_withdraw1 !== ""))?($total_withdraw1):'0'); ?></h2>
                        <li>已提现金额</li>
                    </ul>
                </div> -->
                <div class="hd" style="margin-top: 10px"><h3>商城订单收益</h3></div>
                <div class="shujutow">
                    <dl>
                        <dt>销售总额：  <?php echo ((isset($order_count2) && ($order_count2 !== ""))?($order_count2):'0'); ?>元</dt>
                        <dt>结算总额：   <?php echo ((isset($order_count3) && ($order_count3 !== ""))?($order_count3):'0'); ?>元</dt>
                        <dt>可提现金额：  <?php echo ((isset($can) && ($can !== ""))?($can):'0'); ?>元
                            <a href="<?php echo U('caiwu/to_withdraw_money');?>">
                                <button type="submit" class="submit btn btn-primary radius"  name="">去提现</button>
                            </a>
                        </dt>
                        <dt>
                            <span>正在提现：<?php echo ((isset($total_withdraw3) && ($total_withdraw3 !== ""))?($total_withdraw3):'0'); ?></span>
                            <!-- <span style="margin-left: 10px;">冻结中：<?php echo ((isset($total_withdraw4) && ($total_withdraw4 !== ""))?($total_withdraw4):'0'); ?></span> -->
                        </dt>
                    </dl>
                    <ul style="margin-top: 5px;">
                        <h2>￥<?php echo ((isset($total_withdraw2) && ($total_withdraw2 !== ""))?($total_withdraw2):'0'); ?>元</h2>
                        <li>已提现金额</li>
                    </ul>
                </div>
            </div>
                <!--<script type="text/javascript">jQuery(".slideTxtBox").slide();</script>-->
            
        </div>
    </div>
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