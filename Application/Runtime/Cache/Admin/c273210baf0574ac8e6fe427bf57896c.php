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
	location.href="/Admin/Business/edit/id/"+id;
}
//进入到下级
function xj(id){
	location.href="/Admin/Business/index2/id/"+id;
}
function getnums(){
    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var name = $("#name").val();
    var is_all = $("#is_all").val();
    window.location.href="/Admin/Business/seller?nums="+num+"&start="+start+"&end="+end+"&name="+name+"&is_all="+is_all;
}
function sendname() {
    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var name = $("#name").val();
    window.location.href="/Admin/Business/seller?nums="+num+"&start="+start+"&end="+end+"&name="+name;
}
</script>

<form action="javascript:;" method="post">
<div class="tools"> 
<div class="add"><span><a href="/Admin/Business/toadd_seller">添加</a></span></div>
<div class="del"><span><span><a href="javascript:;">
<input name="dele" type="submit" value="删除" onclick="del();" class="wr"   style="border:none; background-color:#F2F7FD; color:#2D52A5;margin-top:3px;" /></a></span></div>

    <span style="float:left;padding-top:8px;">每页显示
        <select id="nus" onchange="getnums();">
          <?php if(is_array($nums)): $i = 0; $__LIST__ = $nums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l); ?>" <?php if( $l == $nus ): ?>selected<?php else: endif; ?>><?php echo ($l); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select> 条
    </span>

    <span style="float:right;padding-right:50px;padding-top:5px;">
   <!--&nbsp;&nbsp;注册日期： <input type="text" class="laydate-icon" name="start_time" id="start" size="12" value="<?php echo ($start); ?>" readonly> - <input type="text" class="laydate-icon" name="end_time" id="end" size="12" value="<?php echo ($end); ?>" readonly>-->
   店铺类型:<select name="is_all" id="is_all" onchange="getnums()">
            <option value="" <?php if( $is_all == '' ): ?>selected<?php endif; ?>>全部</option>
            <option value="1" <?php if( $is_all == 1 ): ?>selected<?php endif; ?>>总仓</option>
            <option value="0" <?php if( ($is_all == 0) AND ($is_all != '')): ?>selected<?php endif; ?>>普通商铺</option>
        </select>
        关键词: <input type="text" name="name" id="name" value="<?php echo ($name); ?>" placeholder="输入商户名，店铺名称，商户账号" size="30">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="button" value="搜索" id="button" onclick="sendname()">
</span>

</div>

<div class="content">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabBox">
<tr class="tabTitleMain">
    <td width="8%" align="center">
    <input type="checkbox" name="checkbox11" id="checkbox11"  onclick="return checkAll(this,'chois[]')"  value="0">全选</td>
    
    <td width="" align="center">ID</td>
    <td width="" align="center">商家姓名</td>
    <td width="" align="center">店铺名称</td>
    <td width="" align="center">店铺图片</td>
    <td width="" align="center">商户账号</td>

    <td width="" align="center">审核状态</td>
    <td width="" align="center">店铺类型</td>
    <td width="" align="center">申请时间</td>
    <td width="" align="center">操作</td>

</tr>


<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><tr class="tabTextMain" id="f_<?php echo ($l["merchants_id"]); ?>" onmouseout="this.style.background='#FFFFFF';" onmouseover="this.style.background='#fbf435';">
  <td align="center"><input type="checkbox" class="deleteids" value="<?php echo ($l["merchants_id"]); ?>" name="chois[]"/><?php echo ($i); ?></td>

    <td align="center" class="onerow"><?php echo ($l["merchants_id"]); ?></td>
    <td align="center" class="onerow"><?php echo ($l["contact_name"]); ?></td>
    <td align="center" class="onerow"><?php echo ($l["merchants_name"]); ?></td>
    <td align="center" class="onerow"><img src="<?php echo ($l["merchants_img"]); ?>" style="width:50px; height:50px; border-radius:25px;"></td>

    <td align="center" class="onerow"><?php echo ($l["phone"]); ?></td>
    <td align="center" class="onerow">
            <?php switch($l["apply_state"]): case "1": ?>审核中<?php break;?>
                <?php case "2": ?>审核通过<?php break;?>
                <?php case "3": ?>拒绝<?php break; endswitch;?></td>
    <td align="center" class="onerow">
        <?php if( $l["is_all"] == 1 ): ?>总仓<?php else: ?>普通商铺<?php endif; ?>
    </td>
    
    <td align="center" class="onerow"><?php echo ($l["create_time"]); ?></td>


  <td align="center">
                  <a href="<?php echo U('update_seller',array('mid'=>$l['member_id']));?>">编辑</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a href="javascript:;"  onclick="del(<?php echo ($l["merchants_id"]); ?>);">删除</a>
               
               </td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table> 
</form>
<div class="pages"><?php echo ($show); ?></div>

</div>

<script type="text/javascript">
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
    $.post("<?php echo U('del_true');?>", {ids:kid}, function(v){
        if( v == 1 ){
            alert('删除成功！');
            location.reload("<?php echo U('seller');?>");
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