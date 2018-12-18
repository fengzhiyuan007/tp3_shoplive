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
            <input name="p" type="hidden" value="1" />
            <input type="text" class="input-text" style="width:250px" placeholder="搜索关键字" value="<?php echo ($_GET['content']); ?>" name="content">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        	<span style="float:right;padding:0px 10px 10px 0" >
                <a href="<?php echo U('Index/add_video');?>" class="btn btn-primary radius" >
                    <i class="Hui-iconfont">&#xe600;</i>添加视频
                </a>
            </span>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
			<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
            </a>
		</span>
        <span class="r">共有数据：<strong><?php echo ((isset($count) && ($count !== ""))?($count):0); ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width=""><input type="checkbox" name="" value=""></th>
                <!-- <th width="">标题</th> -->
                <th width="50">会员</th>
                <th width="">封面</th>
                <th width="100">简介</th>
                <th width="200">地址</th>
                <th width="">标签</th>
                <!-- <th width="">观看人数</th> -->
                <!-- <th width="">点赞数</th> -->
                <!-- <th width="">状态</th> -->
                <th width="">时间</th>
                <th width="">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td><input type="checkbox" value="<?php echo ($l["id"]); ?>" name="checkbox"></td>
                    <!--<td align="center" class="onerow"><img src="<?php echo ($l["img"]); ?>" style="width: 50px;height: 50px;border-radius:50%"></td>-->
                    <!-- <td><?php echo ($l["title"]); ?></td> -->
                    <td><?php echo ($l["username"]); ?></td>
                    <td><img  src="<?php echo ($l["img_url"]); ?>" style="width: 50px;height: 50px;border-radius:50%"></td>
                    <td><?php echo ($l["content"]); ?></td>
                    <td><?php echo ($l["url"]); ?></td>
                    <td><?php echo ($l["tag"]); ?></td>
                    <!-- <td><?php echo ($l["play_number"]); ?></td> -->
                    <!-- <td><?php echo ($l["zan"]); ?></td> -->
                    <!-- <td>
                        <?php if($l['is_shenhe'] == 2): ?><u><a href="javascript:;;" onClick="change_review(this,<?php echo ($l["video_id"]); ?>)"><span class="label label-success radius">已审核</span></a></u>
                        <?php else: ?>
                        <u><a href="javascript:;;" onClick="change_review(this,<?php echo ($l["video_id"]); ?>)"><span class="label label-defaunt radius">未审核</span></a></u><?php endif; ?>
                    </td> -->
                    <td><?php echo (date("Y-m-d H:i:s",$l["creatime"])); ?></td>
                    <td class="td-manage" style="text-align: center">
                        <a title="编辑" href="<?php echo U('Index/add_video',['id'=>$l['id']]);?>"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="播放" href="javascript:;" onclick="view_url('<?php echo ($l["url"]); ?>')"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e6;</i></a>
                        <a title="删除" href="javascript:;" onclick="del(this,'<?php echo ($l["id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pages"><?php echo ($show); ?></div>
    </div>
    <div id="made"  class="hide">
        <img style="width:100%" id="zhubo" src="">
    </div>
</div>
<script type="text/javascript">
    /*	$(document).ready(function(){
     $('.table-sort').dataTable({
     "aaSorting": [[ 1, "desc" ]],//默认第几个排序
     "bStateSave": true,//状态保存
     "aoColumnDefs": [
     {"orderable":false,"aTargets":[0,7]}// 制定列不参与排序
     ]
     });
     });*/
     function change_review(obj,id){
        layer.confirm('确认要操作吗？',function(index){
            $.post("<?php echo U('change_goods_review');?>",{id:id},function(data){
                console.log(data);
                if(data.data==1){
                    $(obj).parent().parent().html('<u><a href="javascript:;;" onClick="change_review(this,'+id+')"><span class="label label-defaunt radius">未审核</span></a></u>');
                    layer.msg('已下架成功!',{icon: 5,time:1000});
                }else if(data.data == 2){
                    $(obj).parent().parent().html('<u><a href="javascript:;;" onClick="change_review(this,'+id+')"><span class="label label-success radius">已审核</span></a></u>');
                    layer.msg('已审核成功!',{icon: 6,time:1000})
                }
            },'json')
        });
    }

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
            $.post("<?php echo U('Index/del_video');?>", {ids:kid}, function(data){
                console.log(data);
                if( data.status == 'ok' ){
                    layer.msg(data.info,{icon:1,time:1000},function(v){
                        location.replace(location.href);
                    });
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
    /*用户-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要下架吗？',function(index){
            $.post("<?php echo U('Index/change_video_shenhe');?>",{id:id},function(data){
                if(data.info == 1){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none"  onClick="member_start(this,'+id+')" href="javascript:;" title="审核"><i class="Hui-iconfont">&#xe603;</i></a>');
                    $(obj).remove();
                    layer.msg('已下架成功!',{icon: 5,time:1000});
                }
            },'json')
        });
    }

    /*用户-启用*/
    function member_start(obj,id){
        layer.confirm('确认要审核吗？',function(index){
            $.post("<?php echo U('Live/change_video_shenhe');?>",{id:id},function(data){
                if(data.info == 2){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="ml-5" onClick="member_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                    $(obj).remove();
                    layer.msg('已审核成功!',{icon: 6,time:1000});
                }
            },'json');

        });
    }
    /*用户-删除*/
    function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('Index/del_video');?>", {ids:id}, function(data){
                console.log(data);
                if( data.status == 'ok' ){
                    $(obj).parent().parent().remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg(data.info,{icon:5,time:1000});
                }
            },'json');
        });
    }

    function offline(id) {
        layer.confirm('确定强制下线？',function(index){
            $.post("<?php echo U('Live/offline');?>", {id:id}, function(v){
                if( v == 1 ){
                    layer.msg('已强制下线！',{icon:1,time:1000});
                    window.location.href = window.location.href;

                }else{
                    layer.msg('强制下线失败！',{icon:5,time:1000});
                }
            });
        });
    }

    function view_url(v){
        layer.open({
            type: 2,
            title: false,
            area: ['800px', '500px'],
            shade: 0.8,
            closeBtn: 0,
            shadeClose: true,
            content: v
        });
    }


    function view_play_img(v){
        $("#zhubo").attr('src',v);
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '516px',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#made')
        });
    }

    function view_img(v,id){
        var url = "<?php echo U('Live/check_img');?>";
        $.post(url,{img:v},function(data){
            if(data.status == 'ok'){
                $("#zhubo").attr('src',v);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: '384px',
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: $('#zhubo')
                });
            }else{
                layer.msg('该直播已经结束!',{icon:5,time:1000});
                window.location.href = window.location.href;
            }
        },'json');
        return false;
    }

    function sel(id) {
        layer.open({
            type: 2,
            title: false,
            area: ['1020px', '587px'],
            shade: 0.1,
            closeBtn: 1,
            shadeClose: false,
            content: id,
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