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
            <input type="text" class="input-text" style="width:200px" placeholder="搜索标题" value="<?php echo ($_REQUEST["title"]); ?>" name="title">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <span style="float:right;padding:0px 10px 10px 0" >
            <a href="<?php echo U('Home/insert_text');?>" class="check_auth btn btn-primary radius" >
            <i class="Hui-iconfont">&#xe600;</i>添加图文信息
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
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="40">ID</th>
                <th width="150">名称</th>
                <th width="200">跳转值</th>
                <th width="100">创建时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td><input name="checkbox" type="checkbox" value="<?php echo ($vo["text_id"]); ?>"></td>
                    <td><?php echo ($vo["text_id"]); ?></td>
                    <td><a href="<?php echo U('Home/edit_text',['id'=>$vo['text_id']]);?>"><u><?php echo ($vo["title"]); ?></u></a></td>
                    <td>
                        <a title="预览" href="<?php echo U('App/home/text',['id'=>$vo['text_id']]);?>" target="_blank"  class="ml-5" style="text-decoration:none">
                            <u><?php echo U('App/home/text',['id'=>$vo['text_id']]);?></u>
                        </a>
                    </td>
                    <td><?php echo ($vo['create_time']); ?></td>
                    <td class="td-manage">
                        <a style="text-decoration:none" class="ml-5"  href="<?php echo U('Home/edit_text',['id'=>$vo['text_id']]);?>" title="编辑">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="预览" href="<?php echo U('App/home/text',['id'=>$vo['text_id']]);?>" target="_blank"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
                        <a title="删除" href="javascript:;" onclick="del(this,'<?php echo ($vo["text_id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="pages"><?php echo ($show); ?></div>
</div>
<!--<script src="/assets/js/ZeroClipboard.js"></script>-->
<script type="text/javascript">
    $(function() {
        $("#selall").toggle(function() {
            $("input[name='ids']").each(function() {
                $(this).attr("checked", true);
            });
        },function(){
            $("input[name='ids']").each(function() {
                $(this).attr("checked", false);
            });
        });

    });

    /*用户-删除*/
    function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post("<?php echo U('Home/del_text');?>", {ids:id}, function(data){
                if( data.status == 'ok' ){
                    $(obj).parent().parent().remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg(data.info,{icon:5,time:1000});
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
            $.post("<?php echo U('Home/del_text');?>", {ids:kid}, function(data){
                if( data.status == 'ok' ){
                    layer.msg(data.data.info,{icon:1,time:1000},function(){
                        window.location.href = data.data.url;
                    });
                }else{
                    layer.msg(data.data,{icon:5,time:1000});
                }
            },'json');
        })
    }
    function getChecked() {
        var gids = new Array();
        $.each($('input:checked'), function(i, n){
            gids.push( $(n).val() );
        });
        return gids;
    }

    function send_notice(id,v){
        var url = $(v).attr('data-action');
        var id = id;
        $.post(url,{id:id},function(data){
            console.log(data);
            if( data.status == 'ok' ){
                popup.success(data.info);
                setTimeout(function(){
                    popup.close("asyncbox_success");
                },2000);
                window.location.href = window.location.href;
            }else{
                popup.error(data.info);
                setTimeout(function(){
                    popup.close("asyncbox_error");
                },2000);
            }
        },'json');
        return false;
    }

    function change_istop(id,v){
        var id = id;
        $.post("<?php echo U('Home/change_notice_top');?>",{id:id},function(data){
            if(data['status'] == 'ok'){
                $(v).html(data['info']);
            }else{
                alert(data['info']);
            }
        },'json');
        return false;
    }

    function change_state(id,v){
        var id = id;
        $.post("<?php echo U('Home/change_notice_state');?>",{id:id},function(data){
            if(data['status'] == 'ok'){
                $(v).html(data['info']);
            }else{
                alert(data['info']);
            }
        },'json');
        return false;
    }
    function send(id,v){
        var id = id;
        $.post("<?php echo U('Home/send_notice');?>",{id:id},function(data){
            if(data['status'] == 'ok'){
                $(v).html(data['info']);
            }else{
                alert(data['info']);
            }
        },'json');
        return false;
    }

    function copy(v)
    {
        var Url2=document.getElementById("copy"+v);
        Url2.select(); // 选择对象
        document.execCommand("Copy");  // 执行浏览器复制命令
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