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
	location.href="/Admin/Goods/edit/id/"+id;
}
//进入到下级
function xj(id){
	location.href="/Admin/Goods/index2/id/"+id;
}
function getnums(){
    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var name = $("#name").val();
    window.location.href="/Admin/Goods/seed?nums="+num+"&start="+start+"&end="+end+"&name="+name;
}
function sendname() {
    var num = $("#nus").val();
    var start = $("#start").val();
    var end = $("#end").val();
    var name = $("#name").val();
    window.location.href="/Admin/Goods/seed?nums="+num+"&start="+start+"&end="+end+"&name="+name;
}
</script>
<form action="" method="get">
<div class="tools"> 
<!-- <div class="add"><span><a href="/Admin/Goods/toadd_seller">添加</a></span></div> -->
<div class="del"><span><span><a href="javascript:;">
<input name="dele" type="submit" value="删除" onclick="datadel()" class="wr"   style="border:none; background-color:#F2F7FD; color:#2D52A5;margin-top:3px;" /></a></span></div>

    <!-- <span style="float:left;padding-top:8px;">每页显示
        <select id="nus" onchange="getnums();">
          <?php if(is_array($nums)): $i = 0; $__LIST__ = $nums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l); ?>" <?php if( $l == $nus ): ?>selected<?php else: endif; ?>><?php echo ($l); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select> 条
    </span> -->

    <span style="float:right;padding-top:4px;" >
        <a href="javascript:;;" class="btn btn-primary radius" onclick="category_edit('添加分类（Seed）','<?php echo U('edit_seed_class',['cate_id'=>$parent['class_id']]);?>','4','','510')" >
            <i class="Hui-iconfont">&#xe600;</i>添加分类名
        </a>
        <a class="btn btn-success radius r" style="float:right;padding-top:4px;" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </span>

    <span style="float:right;padding-right:50px;padding-top:5px;">
   <!--&nbsp;&nbsp;注册日期： <input type="text" class="laydate-icon" name="start_time" id="start" size="12" value="<?php echo ($start); ?>" readonly> - <input type="text" class="laydate-icon" name="end_time" id="end" size="12" value="<?php echo ($end); ?>" readonly>-->
        关键词: <input type="text" name="name" id="name" value="<?php echo ($name); ?>" placeholder="输入分类名称" size="30">
        <input type="hidden" name="uuid" value="<?php echo ($_GET['uuid']); ?>">

&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="button" value="搜索" id="button" >
</span>
</form>



</div>
<form action="javascript:;" method="post">

<div class="content">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabBox">
<tr class="tabTitleMain">
    <td width="" align="center">
    <input type="checkbox" name="checkbox11" id="checkbox11"  onclick="return checkAll(this,'chois[]')"  value="0">全选</td>
    
    <td width="" align="center">名称</td>
    <!-- <td width="" align="center">颜色</td> -->
    <td width="" align="center">简介</td>
    <td width="" align="center">图片</td>
    <td width="" align="center">发布状态</td>
    <td width="" align="center">是否推荐</td>
    <td width="" align="center">操作</td>
</tr>


<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><tr class="tabTextMain" id="f_<?php echo ($l["class_id"]); ?>" onmouseout="this.style.background='#FFFFFF';" onmouseover="this.style.background='#fbf435';">
  <td align="center"><input type="checkbox" class="deleteids" value="<?php echo ($l["class_id"]); ?>" name="chois[]"/><?php echo ($i); ?></td>

    <!-- <td align="center" class="onerow"><?php echo ($l["merchants_id"]); ?></td> -->
    <td align="center" class="onerow"><?php echo ($l["class_name"]); ?></td>
    <!-- <td align="center" class="onerow"><?php echo ($l["class_color"]); ?></td> -->
    <td align="center" class="onerow"><?php echo ($l["class_desc"]); ?></td>
    <td align="center" class="onerow"><img src="<?php echo ($l["class_img"]); ?>" style="width:50px; height:50px; border-radius:25px;"></td>

    <td align="center" class="onerow td-status">
        <?php if($l['class_state'] == 0): ?><span class="label label-defaunt radius">已下架</span>
        <?php else: ?>
            <span class="label label-success radius">已发布</span><?php endif; ?>
    </td>
    <td align="center" class="onerow">
        <?php if($l['is_recommend'] == 0): ?><u><a href="javascript:;;" onClick="change_recommend(this,<?php echo ($l["class_id"]); ?>)"><span class="label label-defaunt radius">设为推荐</span></a></u>
        <?php else: ?>
            <u><a href="javascript:;;" onClick="change_recommend(this,<?php echo ($l["class_id"]); ?>)"><span class="label label-success radius">取消推荐</span></a></u><?php endif; ?>

    </td>            

  <td align="center" class="td-manage">
        <?php if($l['class_state'] == 0): ?><a style="text-decoration:none" onClick="picture_start(this,<?php echo ($l["class_id"]); ?>)" href="javascript:;" title="发布">
            <i class="Hui-iconfont">&#xe603;</i>
        </a>
        <?php else: ?>
        <a style="text-decoration:none" onClick="picture_stop(this,<?php echo ($l["class_id"]); ?>)" href="javascript:;" title="下架">
            <i class="Hui-iconfont">&#xe6de;</i>
        </a><?php endif; ?>
        <!-- <a style="text-decoration:none" class="ml-5"  href="<?php echo U('seed',['uuid'=>$l['class_uuid']]);?>" title="下级分类">
            <i class="Hui-iconfont">&#xe681;</i>
        </a> -->
        <a style="text-decoration:none" class="ml-5"  href="javascript:;;" onclick="category_edit('编辑分类（First）','<?php echo U('edit_seed_class',['id'=>$l['class_id'],'cate_id'=>$parent['class_id']]);?>','4','','510')" title="编辑">
            <i class="Hui-iconfont">&#xe6df;</i>
        </a>
        <a style="text-decoration:none" class="ml-5" onClick="del(this,<?php echo ($l["class_id"]); ?>)" href="javascript:;" title="删除">
            <i class="Hui-iconfont">&#xe6e2;</i>
        </a>
   
   </td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table> 
</form>
<div class="pages"><?php echo ($show); ?></div>

</div>

<script type="text/javascript">
/*
设为推荐
 */
function change_recommend(obj,id){
    layer.confirm('确认要操作吗？',function(index){
        $.post("<?php echo U('change_class_recommend');?>",{id:id},function(data){
            console.log(data);
            if(data.data==1){
                $(obj).parent().parent().html('<u><a href="javascript:;;" onClick="change_recommend(this,'+id+')"><span class="label label-success radius">取消推荐</span></a></u>');
                layer.msg('操作成功!',{icon: 6,time:1000});
            }else if(data.data == 0){
                $(obj).parent().parent().html('<u><a href="javascript:;;" onClick="change_recommend(this,'+id+')"><span class="label label-defaunt radius">设为推荐</span></a></u>');
                layer.msg('操作成功!',{icon: 6,time:1000});
            }
        },'json')
    });
}
/*图片-发布*/
    function picture_start(obj,id){
        layer.confirm('确认要发布吗？',function(index){
            $.post("<?php echo U('change_class_status');?>",{id:id},function(data){
                console.log(data);
                if(data.data==1){
                    $(obj).parent().parent().find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                    $(obj).parent().parent().find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布!',{icon: 6,time:1000});
                }
            },'json')
        });
    }

/*图片-下架*/
    function picture_stop(obj,id){
        layer.confirm('确认要下架吗？',function(index){
            $.post("<?php echo U('change_class_status');?>",{id:id},function(data){
                console.log(data);
                if(data.data==0){
                    $(obj).parent().parent().find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_start(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                    $(obj).parent().parent().find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
                    $(obj).remove();
                    layer.msg('已下架!',{icon: 5,time:1000});
                }
            },'json')
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
//
function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('del_class');?>", {ids:id}, function(data){
                    console.log(data);

                if( data == 'success' ){
                    $(obj).parent().parent() .remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg('删除失败!',{icon:1,time:1000});
                }
        },'json');
        });
    }

function datadel(kid){
        kid = kid ? kid : getChecked();
        kid = kid.toString();
        if(kid == ''){
            layer.msg('你没有选择任何选项！', {offset: 95,shift: 6});
            return false;
        }
        layer.confirm('确认要删除吗？',function(index){
        $.post("<?php echo U('del_class');?>", {ids:kid}, function(data){
            if( data == 'success' ){
                layer.msg('已删除!',{icon:1,time:1000},function(){
                    //关闭后的操作
                    location.reload("<?php echo U('seed');?>");
                });
            }else{
                layer.msg('删除失败!',{icon:5,time:1000});
            }
        },'json');
    })
    }
// function del(kid){
//     kid = kid ? kid : getChecked();
//     kid = kid.toString();
//     if(kid == ''){
//         alert("请选择要删除的选项");
//         return false;
//     }
//     if(!confirm('确定删除？'))
//         return false;
//     $.post("<?php echo U('del_class');?>", {ids:kid}, function(v){
//         if( v == 1 ){
//             alert('删除成功！');
//             location.reload("<?php echo U('index');?>");
//         }else{
//             alert('删除失败！');
//         }
//     });
// }
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

    function category_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
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