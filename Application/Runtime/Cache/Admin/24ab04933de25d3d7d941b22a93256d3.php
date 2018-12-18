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

<div class="page-container">
    <div class="text-l">
        <form class="search"  method="get">
            <input name="p" value="" hidden>
            <span class="select-box" style="width:150px">
            <select name="order_state"  class="select select-box inlin" id="state" style="width:120px">
                <option value="">请选择状态</option>
                <option value="wait_pay" <?php if($_REQUEST["order_state"] == 'wait_pay'): ?>selected<?php endif; ?>>待支付</option>
                <option value="wait_send" <?php if($_REQUEST["order_state"] == 'wait_send'): ?>selected<?php endif; ?>>待发货</option>
                <option value="wait_receive" <?php if($_REQUEST["order_state"] == 'wait_receive'): ?>selected<?php endif; ?>>待收货</option>
                <option value="wait_assessment" <?php if($_REQUEST["order_state"] == 'wait_assessment'): ?>selected<?php endif; ?>>待评价</option>
                <option value="end" <?php if($_REQUEST["order_state"] == 'end'): ?>selected<?php endif; ?>>已完成</option>
                <option value="cancel" <?php if($_REQUEST["order_state"] == 'cancel'): ?>selected<?php endif; ?>>已取消</option>
                <option value="returns" <?php if($_REQUEST["order_state"] == 'returns'): ?>selected<?php endif; ?>>已退款</option>
            </select>
            </span>
            <input type="text" class="input-text" style="width:200px" name="order_no" value="<?php echo ($_REQUEST["order_no"]); ?>" id="order_no" placeholder="订单号/收件人电话">
            <input type="text" class="input-text "  id="start_time" style="width:180px" name="start_time" value="<?php echo urldecode(I('start_time')) ?>"  placeholder="开始时间" readonly>
            <input type="text" class="input-text "  id="end_time" style="width:180px" name="end_time" value="<?php echo urldecode(I('end_time')) ?>"  placeholder="结束时间" readonly>
            <button type="submit" class="btn btn-success radius"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <br/>
            <div class="mt-5">
             <span class="select-box" style="width:250px">
                <select name="merchants_id"  class="select select-box inlin" id="merchants_id" style="width:220px">
                    <option value="">请选择店铺</option>
                    <?php if(is_array($merchant)): $i = 0; $__LIST__ = $merchant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["member_id"]); ?>" <?php if($_REQUEST["merchants_id"] == $vo['member_id']): ?>selected<?php endif; ?>><?php echo ($vo["merchants_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </span>
                <input type="text" class="input-text "  id="merchant_name" style="width:180px"  value=""  placeholder="店铺关键字">
                <button type="button" onclick="searchMerchant($('#merchant_name').val())" class="btn btn-default radius" id="" name="">搜店铺</button>
                <span style="float:right;padding:0px 10px 10px 0" >
                <a href="javascript:void(0)" title="导出Excl"  onclick="xiazai()" class="btn btn-default radius" >
                    <i class="Hui-iconfont">&#xe644;</i>导出
                </a>
            </span>
            </div>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="recovery()" class="btn btn-primary radius">
				<i class="Hui-iconfont">&#xe615;</i> 批量恢复
			</a>
		</span>
        <span class="r">共有数据：<strong><?php echo ((isset($count) && ($count !== ""))?($count):0); ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="120">订单号</th>
                <th width="70">订单收件人</th>
                <th width="70">收件人电话</th>
                <th width="50">总金额</th>
                <th width="50">实付金额</th>
                <!--<th width="50">成本价</th>-->
                <th width="50">商家店铺</th>
                <th width="60">订单状态</th>
                <th width="60">结算状态</th>
                <th width="120">下单时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                <td><input type="checkbox" value="<?php echo ($vo["order_merchants_id"]); ?>" name="checkbox"></td>
                <td><?php echo ($vo["order_no"]); ?></td>
                <td><?php echo ($vo["address_name"]); ?></td>
                <td><?php echo ($vo["address_mobile"]); ?></td>
                <td><?php echo ($vo['order_total_price']); ?></td>
                <td><?php echo ($vo['order_actual_price']); ?></td>
                <!--<td><?php echo ($vo['cost']); ?></td>-->
                <td><?php echo ($vo['merchants_name']); ?></td>
                <td>
                    <?php switch($vo['order_state']): case "wait_pay": ?>待付款<?php break;?>
                        <?php case "wait_send": ?>待发货<?php break;?>
                        <?php case "wait_receive": ?>待收货<?php break;?>
                        <?php case "wait_assessment": ?>待评价<?php break;?>
                        <?php case "end": ?>已结束<?php break;?>
                        <?php case "wait_group": ?>等待团购<?php break;?>
                        <?php case "cancel": ?>已取消<?php break;?>
                        <?php case "returns": ?>已退款<?php break; endswitch;?>
                </td>
                <td>
                    <?php if($vo["settlement_state"] == '1'): ?>已结算<?php else: ?>未结算<?php endif; ?>
                </td>
                <td><?php echo ($vo["create_time"]); ?></td>
                <td class="td-manage">
                    <a title="订单详情" class="check_lock" data="<?php echo ($vo["order_no"]); ?>" href="<?php echo U('order_view',array('id'=>$vo['order_no']));?>"   style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                    <a title="订单删除" href="javascript:;" onclick="del(this,<?php echo ($vo["order_merchants_id"]); ?>);" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pages"><?php echo ($show); ?></div>
    </div>
</div>
<script type="text/javascript">
    function getChecked() {
        var gids = new Array();
        $.each($('input[name="checkbox"]:checked'), function(i, n){
            gids.push( $(n).val() );
        });
        return gids;
    }
    function datadel(kid){
        kid = kid ? kid : getChecked();
        kid = kid.toString();
        if(kid == ''){
            layer.msg('你没有选择任何选项！', {offset: 95,shift: 6});
            return false;
        }
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('del_order_true');?>", {ids:kid}, function(data){
                if( data.status == 'ok' ){
                    layer.msg(data.data.info,{icon:1,time:1000});
                    window.location.href = data.data.url;
                }else{
                    layer.msg(data.info,{icon:1,time:1000});
                }
            },'json');
        })
    }
    /*用户-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*用户-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }


    /*用户-删除*/
    function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('del_order_true');?>", {ids:id}, function(data){
                if( data.status == 'ok' ){
                    $(obj).parent().parent().remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg(data.data,{icon:5,time:1000});
                }
            },'json');
        });
    }
    function xiazai(){
        var download = 'download';
        var url = window.location.href;
        var a = url.split("/ids")[0];
        var b = url.split("/ids")[1];
        if(a.split("?")[1]){
            window.location.href=a+"&act="+download+b;
        }else{
            window.location.href=a+"/act/"+download+b;
        }
    }
    function getnums(){
        var num = $("#nus").val();
        window.location.href="/Admin/horder/is_del_order/ids/483&num="+num;
    }

    function lock(v) {
        $.post("<?php echo U('lock_order');?>", {id: v}, function (data) {
            console.log(data);
            if (data['status'] == 'ok') {
                alert(data.info);
                window.location.href = window.location.href;
            } else {
                alert(data.info);
            }
        }, 'json');
    }

    function settlement(v,id){
        var url = "<?php echo U('settlement');?>";
        $.post(url, {order_merchant_id: id}, function (data) {
            console.log(data);
            if (data['status'] == 'ok') {
                layer.msg(data.data,{icon:1,time:1000});
                setTimeout(function(){
                    window.location.href = window.location.href;
                },1000);
            } else {
                layer.msg(data.data,{icon:5,time:1000});
            }
        }, 'json');
    }

    function searchMerchant(v){
        var url = "<?php echo U('searchMerchant');?>";
        $.post(url, {name: v}, function (data) {
            $('#merchants_id').html(data);
        });
    }
    function recovery(obj,kid){
        kid = kid ? kid : getChecked();
        kid = kid.toString();
        if(kid == ''){
            layer.msg('你没有选择任何选项！', {offset: 95,shift: 6});
            return false;
        }
        layer.confirm('确认要恢复选中订单吗？',function(index){
            $.post("<?php echo U('recovery_order');?>", {ids:kid}, function(data){
                if( data.status == 'ok' ){
                    layer.msg(data.data.info,{icon:1,time:1000});
                    window.location.href = data.data.url;
                }else{
                    layer.msg(data.data,{icon:5,time:1000});
                }
            },'json');
        })
    }

</script>
<!-- <script type="text/javascript" src="/static/layui/lay/dest/layui.all.js"></script> -->
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            elem: '#start_time',
            event: 'click', //触发事件
            format: 'YYYY-MM-DD hh:mm:ss', //日期格式
            istime: true, //是否开启时间选择
            isclear: true, //是否显示清空
            istoday: true, //是否显示今天
            issure: true, //是否显示确认
            festival: true,//是否显示节日
            min: '1900-01-01 00:00:00', //最小日期
            max: '2099-12-31 23:59:59', //最大日期
            choose: function(datas){
                $("#start_time").attr("value",datas);
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end_time',
            event: 'click', //触发事件
            format: 'YYYY-MM-DD hh:mm:ss', //日期格式
            istime: true, //是否开启时间选择
            isclear: true, //是否显示清空
            istoday: true, //是否显示今天
            issure: true, //是否显示确认
            festival: true,//是否显示节日
            min: '1900-01-01 00:00:00', //最小日期
            max: '2099-12-31 23:59:59', //最大日期
            choose: function(datas){
                $("#end_time").attr("value",datas);
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        document.getElementById('start_time').onclick = function(){
            start.elem = this;
            laydate(start);
        }
        document.getElementById('end_time').onclick = function(){
            end.elem = this
            laydate(end);
        }
    });
</script>
    
    
    
    
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