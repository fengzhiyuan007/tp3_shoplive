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

    <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                <i class="Hui-iconfont">&#xe6e2;</i>
                批量删除</a>
            <a class="btn btn-primary radius"  href="<?php echo U('Home/add_dress_nature',['pid'=>$dress['dress_id']]);?>">
                <i class="Hui-iconfont">&#xe600;</i> 添加属性
            </a>
        </span>
        <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="150">标题</th>
                <th width="150">图片</th>
                <th width="150">布局数量</th>
                <th width="150">排序</th>
                <th width="60">发布状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                <td><input name="checkbox" type="checkbox" value="<?php echo ($vo["dress_id"]); ?>"></td>
                <td><a href="<?php echo U('Home/edit_dress_nature',['id'=>$vo.dress_id,'pid'=>$vo.pid]);?>"><u><?php echo ($vo["title"]); ?></u></a></td>
                <td><a href="javascript:;"><img width="100" class="picture-thumb" src="<?php echo ($vo["img"]); ?>"></a></td>
                <td><?php echo ($vo["layout"]); ?></td>
                <td>
                    <a href="javascript:void(0)" onclick="plus(<?php echo ($vo['dress_id']); ?>)" title="上移">
                        <i class="Hui-iconfont">&#xe679;</i>
                    </a>
                    <a href="javascript:void(0)" onclick="minus(<?php echo ($vo['dress_id']); ?>)" title="下移">
                        <i class="Hui-iconfont">&#xe674</i>
                    </a>
                </td>
                <td class="td-status">
                    <?php if($vo['status'] == 1): ?><span class="label label-defaunt radius">已下架</span>
                        <?php else: ?>
                        <span class="label label-success radius">已发布</span><?php endif; ?>
                </span></td>
                <td class="td-manage">
                    <?php if($vo['status'] == 1): ?><a style="text-decoration:none" onClick="picture_start(this,<?php echo ($vo["dress_id"]); ?>)" href="javascript:;" title="发布">
                        <i class="Hui-iconfont">&#xe603;</i>
                    </a>
                    <?php else: ?>
                    <a style="text-decoration:none" onClick="picture_stop(this,<?php echo ($vo["dress_id"]); ?>)" href="javascript:;" title="下架">
                        <i class="Hui-iconfont">&#xe6de;</i>
                    </a><?php endif; ?>
                   
                    <a style="text-decoration:none" class="ml-5"  href="<?php echo U('Home/edit_dress_nature',['id'=>$vo['dress_id'],'pid'=>$vo['pid']]);?>" title="编辑">
                        <i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,<?php echo ($vo["dress_id"]); ?>)" href="javascript:;" title="删除">
                        <i class="Hui-iconfont">&#xe6e2;</i>
                    </a>
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
        $.post("<?php echo U('Home/del_dress');?>", {ids:kid}, function(data){
            if( data.status == 'ok' ){
                console.log(data);
                layer.msg(data.data.info,{icon:1,time:1000},function(){
                    window.location.href = data.data.url;
                });
            }else{
                layer.msg(data.data,{icon:1,time:1000});
            }
        },'json');
    })
    }
    /*图片-添加*/
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-查看*/
    function picture_show(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-审核*/
    function picture_shenhe(obj,id){
        layer.confirm('审核文章？', {
                    btn: ['通过','不通过'],
                    shade: false
                },
                function(){
                    $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布', {icon:6,time:1000});
                },
                function(){
                    $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                    $(obj).remove();
                    layer.msg('未通过', {icon:5,time:1000});
                });
    }
    /*图片-下架*/
    function picture_stop(obj,id){
        layer.confirm('确认要下架吗？',function(index){
            $.post("<?php echo U('Home/change_dress_status');?>",{id:id},function(data){
                if(data.data.info==1){
                    $(obj).parent().parent().find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_start(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                    $(obj).parent().parent().find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
                    $(obj).remove();
                    layer.msg('已下架!',{icon: 5,time:1000});
                }
            },'json')
        });
    }

    function plus(v){
        $.post("<?php echo U('Home/plus_dress_sort');?>",{id:v},function(data){
            if(data['status'] == 'ok'){
                layer.msg(data.data,{icon:1,time:2000},function(){
                    window.location.href = window.location.href;

                })
            }else{
                layer.msg(data.error,{icon:5,time:2000})
            }
        },'json');
    }

    function minus(v){
        $.post("<?php echo U('Home/minus_dress_sort');?>",{id:v},function(data){
            console.log(data);
            if(data['status'] == 'ok'){
                layer.msg(data.data,{icon:1,time:2000},function(){
                    window.location.href = window.location.href;

                })
            }else{
                layer.msg(data.error,{icon:5,time:2000})
            }
        },'json');
    }

    /*图片-发布*/
    function picture_start(obj,id){
        layer.confirm('确认要发布吗？',function(index){
            $.post("<?php echo U('Home/change_dress_status');?>",{id:id},function(data){
                if(data.data.info==2){
                    $(obj).parent().parent().find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                    $(obj).parent().parent().find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布!',{icon: 6,time:1000});
                }
            },'json')
        });
    }
    /*图片-申请上线*/
    function picture_shenqing(obj,id){
        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
        $(obj).parents("tr").find(".td-manage").html("");
        layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
    }
    /*图片-编辑*/
    function picture_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-删除*/
    function picture_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('Home/del_dress');?>", {ids:id}, function(data){
                console.log(data);
                if( data.status == 'ok' ){
                    $(obj).parent().parent().remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg(data.error,{icon:5,time:1000});
                }
            },'json');
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