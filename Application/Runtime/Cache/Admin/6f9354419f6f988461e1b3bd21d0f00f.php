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
    .beizhu_btn { padding: 3px 3px; *padding: 0 3px; *height: 24px;  font-size: 12px; text-align: center; border:1px solid #4898d5; border-radius: 2px; background-color: #2e8ded; color:#fff;cursor: pointer; display: inline-block; }
    .layui-layer-btn {
        text-align: center!important;
        padding: 0 10px 12px;
        pointer-events: auto;
    }
</style>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray">
        <div><b>订单信息</b></div>
    <div class="mt-5">
        <table  class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="100">订单号</th>
                <th width="120">下单会员</th>
                <th width="50">订单总金额</th>
                <th width="50">实收金额</th>
                <th width="50">成本价</th>
                <th width="50">积分抵扣</th>
                <th width="50">优惠券抵扣</th>
                <th width="60">订单状态</th>
                <!--<th width="80">操作</th>-->
            </tr>
            </thead>
            <tbody>
                <tr class="text-c">
                    <td><?php echo ($re["order_no"]); ?></td>
                    <td><?php echo ($re["username"]); ?> --- <?php echo ($re["phone"]); ?></td>
                    <td><?php echo ((isset($re['order_total_price']) && ($re['order_total_price'] !== ""))?($re['order_total_price']):0); ?></td>
                    <td><?php echo ((isset($re['order_actual_price']) && ($re['order_actual_price'] !== ""))?($re['order_actual_price']):0); ?></td>
                    <td><?php echo ((isset($re['cost_price']) && ($re['cost_price'] !== ""))?($re['cost_price']):0); ?></td>
                    <td><?php echo ((isset($re["deduct_integral_price"]) && ($re["deduct_integral_price"] !== ""))?($re["deduct_integral_price"]):0); ?></td>
                    <td><?php echo ((isset($re["deduct_integral_price"]) && ($re["deduct_integral_price"] !== ""))?($re["deduct_integral_price"]):0); ?></td>
                    <td>
                        <?php switch($re['order_state']): case "wait_pay": ?>待付款<?php break;?>
                            <?php case "wait_send": ?>待发货<?php break;?>
                            <?php case "wait_receive": ?>待收货<?php break;?>
                            <?php case "wait_assessment": ?>待评价<?php break;?>
                            <?php case "end": ?>已结束<?php break;?>
                            <?php case "wait_group": ?>等待团购<?php break;?>
                            <?php case "cancel": ?>已取消<?php break;?>
                            <?php case "returns": ?>已退款<?php break; endswitch;?>
                    </td>
                    <!--<td class="td-manage">-->
                        <!--<a title="订单改价" onclick="change_paid('<?php echo ($re["order_no"]); ?>',this)"   style="text-decoration:none"><i class="Hui-iconfont">&#xe60c;</i></a>-->
                    <!--</td>-->
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <div><b>配送信息</b></div>
        <div class="mt-5">
            <table  class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="50">收件人</th>
                    <th width="50">联系方式</th>
                    <th width="50">配送方式</th>
                    <th width="80">配送地址</th>
                    <th width="60">地址邮编</th>
                    <!--<th width="120">配送街道</th>-->
                    <th width="50">快递单号</th>
                    <th width="50">快递公司</th>
                    <!--<th width="50">成本价</th>-->
                    <th width="50">配送类型</th>
                    <th width="80">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-c">
                    <td><?php echo ($re["address_name"]); ?></td>
                    <td><?php echo ($re["address_mobile"]); ?></td>
                    <td>
                        <?php if($re["is_take"] == '1'): ?>自取<?php else: ?>商家配送<?php endif; ?>
                    </td>
                    <td><?php echo ($re["address_province"]); ?>- <?php echo ($re["address_city"]); ?>-<?php echo ($re["address_country"]); ?>-<?php echo ($re["address_detailed"]); ?></td>
                    <!--<td><?php echo ($re["address_road"]); ?></td>-->
                    <td><?php echo ($re["address_zip_code"]); ?></td>
                    <td><?php echo ($re["logistics_no"]); ?></td>
                    <td><?php echo ($re['logistics_name']); ?></td>
                    <td>
                        <?php if($re["is_take"] == '1'): ?>自取<?php else: ?>商家配送<?php endif; ?>
                    </td>
                    <td class="td-manage">
                        <a title="查看" href="javascript:;;" onclick="category_edit('快递信息','<?php echo U('express',['order_no'=>$re['order_no']]);?>','4','','510')"   style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe669;</i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <div><b>商品信息</b></div>
        <div class="mt-5">
            <table style="position: relative" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="70">商品编号</th>
                    <th width="70">商品SKU</th>
                    <th width="120">商品名称</th>
                    <th width="70">商品图片</th>
                    <th width="50">商品价格</th>
                    <th width="50">型号参数</th>
                    <th width="50">购买数量</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                        <td><?php echo ($vo["code"]); ?></td>
                        <td><?php echo ($vo["sku"]); ?></td>
                        <td><?php echo ($vo["goods_name"]); ?></td>
                        <td><img src="<?php echo ($vo["goods_img"]); ?>" style="width:50px; height:50px; border-radius:25px;" /></td>
                        <td><?php echo ($vo['specification_price']); ?></td>
                        <td>
                            <?php echo ($vo["specification_names"]); ?>
                        </td>
                        <td><?php echo ($vo['goods_num']); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(!empty($refund)): ?><div class="cl pd-5 bg-1 bk-gray mt-5">
        <div><b>退换货信息</b></div>
        <div class="mt-5">
            <table style="position: relative" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="50">编号</th>
                    <th width="50">类型</th>
                    <th width="50">退换货商品</th>
                    <th width="50">型号</th>
                    <th width="50">数量</th>
                    <th width="80">退换货原因</th>
                    <th width="80">操作</th>
                </tr>
                <?php if(is_array($refund)): $i = 0; $__LIST__ = $refund;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td><?php echo ($vo["refund_no"]); ?></td>
                    <td>
                        <?php if($vo["refund_type"] == '1'): ?>换货订单<?php else: ?>退货订单<?php endif; ?>
                        
                    </td>
                    <td><?php echo ($vo["goods_name"]); ?></td>
                    <td><?php echo ($vo["specification_names"]); ?></td>
                    <td><?php echo ($vo["refund_count"]); ?></td>
                    <td><?php echo ($vo["refund_reason"]); ?></td>
                    <td>
                        <a title="详情" href="javascript:;;" onclick="category_edit('快递信息','<?php echo U('express',['order_no'=>$re['order_no']]);?>','4','','510')"   style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe623;</i>
                        </a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </thead>
            </table>
        </div>
    </div><?php endif; ?>
    <div class="cl pd-5 bg-1 bk-gray mt-5" >
        <div><b>订单状态编辑</b></div>
        <form   method="post" class="form form-horizontal mt-5">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">会员留言：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <textarea  cols="" rows="" class="textarea" placeholder="买家备注信息"   readonly><?php echo ($re['order_remark']); ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl mt-5">
            <label class="form-label col-xs-4 col-sm-2">备注信息：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <textarea name="custom_remark" cols="" rows="" class="textarea" placeholder="订单备注信息" id="beizhu"><?php echo ($re["custom_remark"]); ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
            <button class="submit btn btn-primary radius beizhu_btn" style="margin-top: 65px; " type="button">提交备注</button>
        </div>
        <div class="row cl" style="margin-bottom: 30px;">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="hidden" name="order_no" value="<?php echo ($re["order_no"]); ?>" />
                <button title="改变订单状态" <?php if($re['order_state'] != 'wait_send'): ?>style='display:none;'<?php endif; ?> class="ibutton submit btn btn-primary radius blue_btn" data='wait_receive' type="button"><i class="Hui-iconfont">&#xe627;</i> 待收货</button>
                <button title="改变订单状态" <?php if($re['order_state'] != 'wait_receive'): ?>style='display:none;'<?php endif; ?> class="ibutton submit btn btn-primary radius blue_btn" data='wait_assessment' type="button"><i class="Hui-iconfont">&#xe627;</i> 待评价</button>
                <button title="改变订单状态" <?php if($re['order_state'] != 'wait_assessment'): ?>style='display:none;'<?php endif; ?> class="ibutton submit btn btn-primary radius blue_btn" data='end' type="button"><i class="Hui-iconfont">&#xe627;</i> 已完成</button>
                <button title="改变订单状态" <?php if($re['order_state'] == 'wait_pay'): ?>class="ibutton submit btn btn-default radius blue_btn"<?php else: ?>style='display:none;'<?php endif; ?> data='cancel' type="button"><i class="Hui-iconfont">&#xe627;</i> 取消订单</button>
            </div>
        </div>
       </form>
    </div>
    <?php if(!empty($log)): ?><div class="cl pd-5 bg-1 bk-gray mt-5" >
        <div><b>订单操作日志记录</b></div>
        <div class="mt-5">
            <table style="position: relative" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="50">操作人</th>
                    <th width="150">操作信息</th>
                    <th width="50">时间</th>
                </tr>
                <?php if(is_array($log)): $i = 0; $__LIST__ = $log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td><?php echo ((isset($vo["name"]) && ($vo["name"] !== ""))?($vo["name"]):总平台); ?></td>
                    <td><?php echo ($vo["title"]); ?></td>
                    <td><?php echo ($vo["intime"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </thead>
            </table>
        </div>
    </div><?php endif; ?>
</div>
<!-- <script type="text/javascript" src="/static/admin/layer/layer.js"></script> -->
<script>
        $('.ibutton').click(function(){
            var obj = $(this);
            var state = obj.attr('data');
            layer.confirm('您是否要改变订单状态\n状态一旦改变将不能回退，请谨慎操作',function(index){
            var state = obj.attr('data');
            $.post("<?php echo U('change_order_status');?>",{order_no:"<?php echo ($re["order_no"]); ?>",state:state},function(data){
                console.log(data);
                if(data['status'] == '1'){
                    layer.msg(data.info,{icon:1,time:1000})
                    window.location.href = window.location.href;
                }else{
                    layer.msg(data.data,{icon:5,time:1000})
                }
            },'json');
            return false;
            });
        });
        $('.ibutton2').click(function(){
            var obj = $(this);
            var state = obj.attr('data');
            layer.confirm('您是否要改变订单状态\n状态一旦改变将不能回退，请谨慎操作',function(index){
            $.post("<?php echo U('change_order_status');?>",{order_no:"<?php echo ($re["order_no"]); ?>",state:state},function(data){
                if(data['status'] == 'ok'){
                    layer.msg(data,{icon:1,time:1000})
                    window.location.href = window.location.href;
                }else{
                    layer.msg(data,{icon:5,time:1000})
                }
            },'json');
            return false;
            });
        });

        $('.beizhu_btn').click(function(){
            var beizhu = $('#beizhu').val();
            $.post("<?php echo U('beizhu');?>",{id:"<?php echo ($re["order_no"]); ?>",beizhu:beizhu},function(data){
                if(data['status'] == 'ok'){
                    layer.msg(data.info,{icon:1,time:1000})
                    //window.location.href = window.location.href;
                }else{
                    layer.msg(data.info,{icon:5,time:1000})
                }
            },'json');
        });

        $(".ajax-form").submit(function(){
            var obj = $(this);
            var url = obj.attr("data-action");
            $.get(url,obj.serializeArray(),function(data){
                if(data['status'] == 'ok'){
                    layer.msg(data.info,{icon:1,time:1000})
                    window.location.href = window.location.href;
                }else{
                    layer.msg(data.info,{icon:5,time:1000})
                }
            },'json');
        })


    function category_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }


    function change_paid(id,v){
        var html = '<form class="form form-horizontal" id="form" method="post">'+
            '<div class="row cl">'+
            '<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>实收金额</label>'+
            '<div class="formControls col-xs-8 col-sm-8">'+
            '<input type="text" name="order_actual_price" class="input-text" value="<?php echo ($re["order_actual_price"]); ?>" placeholder="订单实收金额" id="order_actual_price" />'+
            '</div>'+
            '</div>'+
            '<div class="row cl">'+
            '<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>成本价格</label>'+
            '<div class="formControls col-xs-8 col-sm-8">'+
            '<input type="text" name="cost_price" class="input-text" value="<?php echo ($re["cost_price"]); ?>" placeholder="订单成本价" id="cost_price" />'+
            '</div>'+
            '</div>'+
            '</form>'
        layer.open({
            type: 1,
            title: '修改订单价格',
            closeBtn: 0,
            area: ['550px','220px'],
            skin: '', //没有背景色
            shadeClose: true,
            content: html,
            btn:['保存'],
            yes:function(){
                var order_actual_price = $('#order_actual_price').val();
                var cost_price = $('#cost_price').val();
                $.ajax({
                    url:"<?php echo U('change_paid');?>",
                    type:'post',
                    data:{order_no:id,order_actual_price:order_actual_price,cost_price:cost_price},
                    dataType:'json',
                    success:function(data){
                        if(data['status'] == 'ok'){
                            layer.msg(data.data,{icon:1,time:1000})
                            window.location.href = window.location.href;
                        }else{
                            layer.msg(data.data,{icon:5,time:1000})
                        }
                    }
                })
            }
        });
    }

    //相册层
    function view_img(e) {
        var url = "<?php echo U('get_returns_img');?>";
        $.get(url, {id: e}, function (json) {
            layer.photos({
                photos: json, //格式见API文档手册页
                anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
            });
        },'json');
    }

    function change_returns_state(id,e){
        var url = "<?php echo U('change_returns_state');?>";
        $.post(url,{id:id,status:e},function(data){
            if(data['status'] == 'ok'){
                layer.msg(data.info,{icon:1,time:1000})
                window.location.href = window.location.href;
            }else{
                layer.msg(data.info,{icon:5,time:1000})
            }
        },'json');
    }

    function down(v,e){
        window.location.href = "system.php?m=Admin&c=Horder&a=down_diy&order_no="+v+"&url="+e;
    }
    function getExpressNode(v){
        var url = "<?php echo U('getExpressNode');?>";
        $.get(url,{express:v},function(data){
           $("#kuaidi_node").val(data);
        });
    }
    function getExpress(v){
        var url = "<?php echo U('getExpress');?>";
        $.get(url,{express:v},function(data){
            console.log(data);
            $("#kuaidi_name").html(data);
        });
    }
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