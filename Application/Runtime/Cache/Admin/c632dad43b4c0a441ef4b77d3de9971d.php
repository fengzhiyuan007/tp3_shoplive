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

<script type="text/javascript">
function edit(id){
	location.href="/Admin/Live/edit/id/"+id;
}
//进入到下级
function xj(id){
	location.href="/Admin/Live/index2/id/"+id;
}

window.onload=function(){
    var key =  $("#nums_sj").val();
    if (key==1){
        $(".sj").html('⬆');
    }else {
        $(".sj").html('⬇');
    }
}

function getnums(){

    var sj_id = $("#nums_sj").val();

    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var live_status = $("#live_status").val();
    var username = $("#username").val();
    window.location.href="/Admin/Live/index?nums="+num+"&start="+start+"&end="+end+"&username="+username+"&live_status="+live_status+"&sj_id="+sj_id;
}
function sendname() {
    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var live_status = $("#live_status").val();
    var username = $("#username").val();
    window.location.href="/Admin/Live/index?nums="+num+"&start="+start+"&end="+end+"&username="+username+"&live_status="+live_status;
}
function zrs_sj() {
    var sj_id = $("#nums_sj").val();
    if (sj_id==1){
        $("#nums_sj").attr("value",'2');
        $(".sj").html('⬆');
    }else {
        $("#nums_sj").attr("value",'1');
        $(".sj").html('⬇');
    }
}
</script>

<form action="javascript:;" method="post">
<div class="tools"> 
<!--<div class="add"><span><a href="/Admin/Live/toadd">添加</a></span></div>
<div class="del"><span><span><a href="javascript:;">
<input name="dele" type="submit" value="删除" onclick="del();" class="wr"   style="border:none; background-color:#F2F7FD; color:#2D52A5;margin-top:3px;" /></a></span></div>
-->
    <span style="float:left;padding-top:8px;">每页显示
        <select id="nus" onchange="getnums();">
          <?php if(is_array($nums)): $i = 0; $__LIST__ = $nums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l); ?>" <?php if( $l == $nus ): ?>selected<?php else: endif; ?>><?php echo ($l); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select> 条
    </span>

    <span style="float:right;padding-right:50px;padding-top:5px;">
       状态: <select name="live_status" id="live_status" onchange="sendname()">
            <option value="">请选择</option>
            <option value="1" <?php if( $live_status == 1 ): ?>selected<?php else: endif; ?>>直播中</option>
            <option value="2" <?php if( $live_status == 2 ): ?>selected<?php else: endif; ?>>已结束</option>
        </select>
   &nbsp;&nbsp;直播日期： <input type="text" class="laydate-icon" name="start_time" id="start" size="12" value="<?php echo ($start); ?>" readonly> - <input type="text" class="laydate-icon" name="end_time" id="end" size="12" value="<?php echo ($end); ?>" readonly>
        关键词: <input type="text" name="username" id="username" value="<?php echo ($username); ?>" placeholder="标题、ID" size="30">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="button" value="搜索" id="button" onclick="sendname()">
</span>

</div>

<div class="content">
<input type="hidden" id="nums_sj" value="<?php echo ($sj_id); ?>">
<!-----------------------------------------内容开始--------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabBox">
<tr class="tabTitleMain">
    <!--<td width="" align="center">
    <input type="checkbox" name="checkbox11" id="checkbox11"  onclick="return checkAll(this,'chois[]')"  value="0">全选</td>-->
    <td width="" align="center">id</td>
    <!--<td width="" align="center">头像</td>-->
    <td width="" align="center">直播状态</td>
    <td width="" align="center">标题</td>
    <td width="" align="center">ID</td>
    <td width="" align="center">封面</td>
    <td width="" align="center">开始时间</td>
    <td width="" align="center">结束时间</td>
    <td width="" align="center">总人数<!--&nbsp;<a href="javascript:;" onclick="getnums()"><span class="sj">⬇</span></a>--></td>
    <td width="" align="center">观看人数</td>
    <td width="" align="center">收礼</td>
    <td width="" align="center">操作</td>
</tr>


<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><tr class="tabTextMain" id="f_<?php echo ($l["id"]); ?>" onmouseout="this.style.background='#FFFFFF';" onmouseover="this.style.background='#fbf435';">
  <!--<td align="center"><input type="checkbox" class="deleteids" value="<?php echo ($l["live_id"]); ?>" name="chois[]"/><?php echo ($i); ?></td>-->
    <td align="center" class="onerow"><?php echo ($l["live_id"]); ?></td>
    <!--<td align="center" class="onerow"><img src="<?php echo ($l["img"]); ?>" style="width: 50px;height: 50px;border-radius:50%"></td>-->
    <td align="center" class="onerow"><?php if( $l["live_status"] == 1 ): ?>正在直播<?php else: ?>直播结束<?php endif; ?></td>
    <td align="center" class="onerow"  title="<?php echo ($l["title"]); ?>"><p style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;width:100px; margin-bottom:0; text-align: center;"><?php echo ($l["title"]); ?></p></td>
    <td align="center" class="onerow"><?php echo ($l["id"]); ?></td>
    <td align="center" class="onerow"><img src="<?php echo ($l["play_img"]); ?>" style="width: 50px;height: 50px;border-radius:50%"></td>
    <td align="center" class="onerow"><?php echo (date("Y-m-d H:i:s",$l["start_time"])); ?></td>
    <td align="center" class="onerow"><?php if( $l["end_time"] == 0 ): else: echo (date("Y-m-d H:i:s",$l["end_time"])); endif; ?></td>
    <td align="center" class="onerow"><?php echo ($l["nums"]); ?></td>
    <td align="center" class="onerow"><?php echo ($l["watch_nums"]); ?></td>
    <td align="center" class="onerow"><?php echo ($l["gift_count"]); ?></td>
  <td align="center">
      <?php if( $l["live_status"] == 1 ): ?><a href="javascript:;" onclick="offline(<?php echo ($l["live_id"]); ?>);" style="color: #0a83cd">强制下线</a>
         | <a href="javascript:;" onclick="sel(<?php echo ($l["live_id"]); ?>);" >播放</a><br/>

           <?php if( $l["is_hot"] == 1 ): ?><a href="javascript:;" onclick="tichu(<?php echo ($l["live_id"]); ?>)">踢出热门</a><?php else: ?><a href="javascript:;" onclick="huifu(<?php echo ($l["live_id"]); ?>)">恢复热门</a><?php endif; ?>
          | <?php if( $l["is_tuijian"] == 1 ): ?><a href="javascript:;" onclick="tuijian(<?php echo ($l["live_id"]); ?>)">推荐</a><?php else: ?><a href="javascript:;" onclick="quxiao(<?php echo ($l["live_id"]); ?>)">取消推荐(位置:<?php echo ($l["location"]); ?>)</a><?php endif; else: ?>已结束<?php endif; ?>
      | <a href="<?php echo U('report',array('id'=>$l['live_id']));?>">举报列表</a>
      <!--|&nbsp;&nbsp;-->
                  <!--<a href="javascript:;"  onclick="del(<?php echo ($l["user_id"]); ?>);">删除</a>-->
               
               </td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table> 
</form>
<div class="pages"><?php echo ($show); ?></div>
<!-----------------------------------------内容结束--------------------------------------------------->
</div>

<script type="text/javascript">
    window.onload=function(){
        layer.config({
            extend: 'extend/layer.ext.js'
        });
    }
    function tuijian(live_id) {
        //prompt层
        layer.prompt({title: '输入推荐位置，并确认', formType: 3},function(val, index){
            $.post("<?php echo U('tuijian');?>", {live_id:live_id,val:val}, function(v){
                if( v == 1 ){
                    alert('推荐成功!');
                    location.reload("<?php echo U('index');?>");
                }else{
                    alert('推荐失败!');
                }
            });
            layer.close(index);
        });
    }
    function quxiao(live_id) {
        if(!confirm('确定取消推荐？'))
            return false;
        $.post("<?php echo U('quxiao');?>", {ids:live_id}, function(v){
            if( v == 1 ){
                alert('成功！');
                location.reload("<?php echo U('index');?>");
            }else{
                alert('失败！');
            }
        });
    }
    function offline(id) {
        if(!confirm('确定强制下线？'))
            return false;
        $.post("<?php echo U('offline');?>", {id:id}, function(v){
            if( v == 1 ){
                alert('已强制下线！');
                location.reload("<?php echo U('index');?>");
            }else{
                alert('强制下线失败！');
            }
        });
    }
    function tichu(id){
        if(!confirm('确定踢出？'))
            return false;
        $.post("<?php echo U('tichu');?>", {ids:id}, function(v){
            if( v == 1 ){
                alert('踢出成功！');
                location.reload("<?php echo U('index');?>");
            }else{
                alert('失败！');
            }
        });
    }
    function huifu(id){
        if(!confirm('确定恢复？'))
            return false;
        $.post("<?php echo U('huifu');?>", {ids:id}, function(v){
            if( v == 1 ){
                alert('恢复成功！');
                location.reload("<?php echo U('index');?>");
            }else{
                alert('失败！');
            }
        });
    }
function checkAll(e,chois)
{
	var aa=document.getElementsByName(chois);
	for(var i=0;i<aa.length;i++)
	{  
		aa[i].checked=e.checked;
	}
}
//function tips(itemName){
//    var f=false;
//    var aa=document.getElementsByName(itemName);
//	for(var i=0;i<aa.length;i++){
// 		if(aa[i].checked==true){
//  	 		f=true;
// 		}
//	}
//	if(f==false){
//		alert("请选择要删除的选项");
//		return false;
//	}else{
//  return  confirm("一旦删除不可修复，确定删除吗？");
//}
//return true;
//}

function del(kid){
    kid = kid ? kid : getChecked();
    kid = kid.toString();
    if(kid == ''){
        alert("请选择要删除的选项");
        return false;
    }
    if(!confirm('确定删除？'))
        return false;
    $.post("<?php echo U('del');?>", {ids:kid}, function(v){
        if( v == 1 ){
            alert('删除成功！');
            location.reload("<?php echo U('index');?>");
        }else{
            alert('删除失败！');
        }
    });
}
function getChecked() {
    var gids = new Array();
    $.each($('input:checked'), function(i, n){
        gids.push( $(n).val() );
    });
    return gids;
}


    function sel(id) {
        layer.open({
            type: 2,
            title: false,
            area: ['1020px', '587px'],
            shade: 0.1,
            closeBtn: 1,
            shadeClose: false,
            content: "/Admin/Live/play_live?id="+id,
        });
    }
</script>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            elem: '#start',
            format: 'YYYY-MM-DD',
            //min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16', //最大日期
            istime: false,
            istoday: false,
            choose: function(datas){
                $("#start").attr("value",datas);
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end',
            format: 'YYYY-MM-DD',
            //min: laydate.now(),
            max: '2099-06-16',
            istime: false,
            istoday: false,
            choose: function(datas){
                $("#end").attr("value",datas);
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        document.getElementById('start').onclick = function(){
            start.elem = this;
            laydate(start);
        }
        document.getElementById('end').onclick = function(){
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