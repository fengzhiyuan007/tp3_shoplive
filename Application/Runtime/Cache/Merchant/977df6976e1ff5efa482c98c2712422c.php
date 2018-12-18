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

<style>
    table {
        display: table;
        border-collapse: separate;
        border-spacing: 2px;
        border-color: grey;
    }
    .appIndex .ai_profile {
        margin: 24px 32px;
        color: #a6aeb3;
    }
    .highcharts-button path{
        display: none;
    }
    /*text[text-anchor='end']{*/
    /*display: none;*/
    /*}*/
    text[x='690']{
        display: none;
    }
</style>
<link href="/Public/admin/css/pingxx.css" type="text/css" rel="stylesheet" />
<div class="page-container">
    <!--<p>登录次数：<?php echo ((isset($merchant_info['login_times']) && ($merchant_info['login_times'] !== ""))?($merchant_info['login_times']):0); ?> </p>-->
    <!--<p>登录IP：<?php echo ($merchant_info['last_login_ip']); ?>  登录时间：<?php echo ($merchant_info['last_login_date']); ?></p>-->
    <div id="app_profile_table">    <div class="ai_profile">
        <table>
            <thead>
            <tr>
                <th></th>
                <th>今日交易额</th>
                <th>发起订单</th>
                <th>成功订单</th>
                <th>订单转化率</th>
                <th>平均客单价</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>所选时间段</td>
                <td class="text-black"><span><?php echo ((isset($today_actual_price) && ($today_actual_price !== ""))?($today_actual_price):'0'); ?></span> 元</td>
                <td class="text-black"><span><?php echo ((isset($today_total) && ($today_total !== ""))?($today_total):'0'); ?></span> 笔</td>
                <td class="text-black"><span><?php echo ((isset($today_actual) && ($today_actual !== ""))?($today_actual):'0'); ?></span> 笔</td>
                <td class="text-black"><span><?php echo ((isset($today_ratio) && ($today_ratio !== ""))?($today_ratio):'0'); ?></span></td>
                <td class="text-black"><span><?php echo ((isset($today_average) && ($today_average !== ""))?($today_average):'0'); ?> 元</span></td>
            </tr>
            </tbody>
            <tbody>            <tr>
                <td>
                    <div data-toggle="tooltip" data-placement="top" data-html="true" title="" data-original-title="指标对应的历史成交量最高值">历史峰值<a href="javascript:;;" title="指标对应的日历史成交量最高值"><i class="Hui-iconfont">&#xe6cd;</i></a>
                    </div>
                </td>
                <td><em><?php echo ((isset($summit_actual_price) && ($summit_actual_price !== ""))?($summit_actual_price):'0'); ?></em> 元</td>
                <td><em><?php echo ((isset($summit_total) && ($summit_total !== ""))?($summit_total):'0'); ?></em> 笔</td>
                <td><em><?php echo ((isset($summit_actual) && ($summit_actual !== ""))?($summit_actual):'0'); ?></em> 笔</td>
                <td><em><?php echo ((isset($summit_ratio) && ($summit_ratio !== ""))?($summit_ratio):'0'); ?></em></td>
                <td><em><?php echo ((isset($summit_average) && ($summit_average !== ""))?($summit_average):'0'); ?> 元</em></td>
            </tr>
            </tbody>
        </table>
    </div></div>
    <!--<div class="text-l mt-20">-->
    <!--<input type="text" class="input-text" name="start_time" value="<?php echo ($month); ?>" id="start_time" placeholder="日期时间"  style="width:250px">-->
    <!--<button type="submit" style="padding: 5px;"  class="btn btn-success radius" onclick="code($('#start_time').val())"><i class="Hui-iconfont">&#xe665;</i> 搜索月份</button>-->
    <!--</div>-->
    <div class="cl mt-20 pd-5 bg-1 bk-gray">
        <div id="container" style="min-width:700px;height:300px"></div>
    </div>
    <div class="text-l mt-20">
        <input type="text" class="input-text" name="start_time" value="<?php echo ($month); ?>" id="start_time" placeholder="日期时间"  style="width:250px">
        <button type="submit" style="padding: 5px;"  class="btn btn-success radius" onclick="code($('#start_time').val())"><i class="Hui-iconfont">&#xe665;</i> 搜索月份</button>
    </div>
    <div class="cl mt-20 pd-5 bg-1 bk-gray">
        <div id="charts2" style="min-width:700px;height:300px"></div>
    </div>
    <!--<table class="table table-border table-bordered table-bg mt-20">-->
    <!--<thead>-->
    <!--<tr>-->
    <!--<th colspan="2" scope="col">服务器信息</th>-->
    <!--</tr>-->
    <!--</thead>-->
    <!--<tbody>-->
    <!--{volist name="server_info" id="vo" key="k"}-->
    <!--<tr>-->
    <!--<td><?php echo ($key); ?></td>-->
    <!--<td><?php echo ($vo); ?></td>-->
    <!--</tr>-->
    <!--{/volist}-->
    <!--</tbody>-->
    <!--</table>-->
</div>
<script type="text/javascript" src="/Public/layui/lay/dest/layui.all.js"></script>
<script type="text/javascript" src="/Public/Highcharts/4.1.7/js/highcharts.js"></script>
<script type="text/javascript" src="/Public/Highcharts/4.1.7/js/modules/exporting.js"></script>

<script>
    //    var url = "<?php echo U('Index/day_code');?>";
    //    function code(e) {
    //        $.get(url, {code: e}, function (data) {
    //            console.log(data);
    //            if (data['status'] = 'ok') {
    //                var a = data.data.a;
    //                var b = data.data.b;
    //                $('#container').highcharts({
    //                    chart: {
    //                        type: 'column'
    //                    },
    //                    credits:{
    //                        'enabled':'false'
    //                    },
    //                    title: {
    //                        text: "店铺今日成交金额统计",
    //                        x: -20 //center
    //                    },
    //                    subtitle: {
    //                        text: '',
    //                        x: -20
    //                    },
    //                    xAxis: {
    //                        categories: b
    //                    },
    //                    yAxis: {
    //                        title: {
    //                            text: '金额(元)'
    //                        },
    ////                        labels : {
    ////                            formatter : function () {
    ////                                var strVal = this.value + '';
    ////                                if (strVal.indexOf('.') == -1) {
    ////                                    return strVal + '.00';
    ////                                } else {
    ////                                    var arr = strVal.split('.');
    ////                                    if (arr[1].length == 2) {
    ////                                        return strVal;
    ////                                    } else {
    ////                                        return strVal + '0';
    ////                                    }
    ////                                }
    ////                            }
    ////                        },
    //                        allowDecimals: 'true',        //控制数轴是否显示小数。
    //                        min: 0,                                //控制数轴的最小值
    //                        plotLines: [{
    //                            value: 0,
    //                            width: 3,
    //                            color: '#808080'
    //                        }]
    //                    },
    //                    tooltip: {
    //                        valueSuffix: '金额'
    //                    },
    //                    legend: {
    //                        layout: 'vertical',
    //                        align: 'right',
    //                        verticalAlign: 'middle',
    //                        borderWidth: 0
    //                    }, series: [{
    //                        name: '交易金额',
    //                        data: a
    //                    }]
    //                });
    //            }
    //        }, 'json');
    //    }
    //
    //    code();

    var subtitle = {
        text: ''
    };
    var yAxis = {
        title: {
            text: '金额（元）'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    };

    var tooltip = {
        valueSuffix: '元'
    }

    var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    };

    var url = "<?php echo U('Index/day_code');?>";
    $.get(url, function (data) {
        console.log(data);
        var a = data.data.a;
        var b = data.data.b;
        var title = {
            text: '店铺今日成交金额统计'
        };
        var chart = {
            type: 'column'
        };
        var xAxis = {
            categories: b
        };
        var series = [
            {
                name: '金额',
                //data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 453.8, 0, 0, 0, 0, 0, 0, 0]
                data: a
            },
        ];
        var json = {};
        json.title = title;
        json.subtitle = subtitle;
        json.xAxis = xAxis;
        json.yAxis = yAxis;
        json.tooltip = tooltip;
        json.legend = legend;
        json.series = series;
        json.chart = chart;

        $('#container').highcharts(json);
    },'json');

    function code(e) {
        console.log(e);
        var url2 = "<?php echo U('Index/month_code');?>";
        $.get(url2,{code:e}, function (data) {
            console.log(data);
            var a = data.data.a;
            var b = data.data.b;
            var title = {
                text: '店铺月成交金额统计',
                //x: -20 //center
            };
            var chart = {
                type: ''
            };
            var xAxis = {
                categories: b
            };
            var series = [
                {
                    name: '金额',
                    //data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 453.8, 0, 0, 0, 0, 0, 0, 0]
                    data: a
                },
            ];
            var json = {};
            json.title = title;
            json.subtitle = subtitle;
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.tooltip = tooltip;
            json.legend = legend;
            json.series = series;
            json.chart = chart;
            console.log(json);
            $('#charts2').highcharts(json);
        }, 'json');
    }

    code();
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            elem: '#start_time',
            event: 'click', //触发事件
            format: 'YYYY-MM', //日期格式
            istime: false, //是否开启时间选择
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
//        var end = {
//            elem: '#end_time',
//            event: 'click', //触发事件
//            format: 'YYYY-MM', //日期格式
//            istime: false, //是否开启时间选择
//            isclear: true, //是否显示清空
//            istoday: true, //是否显示今天
//            issure: true, //是否显示确认
//            festival: true,//是否显示节日
//            min: '1900-01-01 00:00:00', //最小日期
//            max: '2099-12-31 23:59:59', //最大日期
//            choose: function(datas){
//                $("#end_time").attr("value",datas);
//                start.max = datas; //结束日选好后，重置开始日的最大日期
//            }
//        };
        document.getElementById('start_time').onclick = function(){
            start.elem = this;
            laydate(start);
        }
//        document.getElementById('end_time').onclick = function(){
//            end.elem = this
//            laydate(end);
//        }
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