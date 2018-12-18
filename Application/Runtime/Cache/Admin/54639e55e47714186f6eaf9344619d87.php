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
     <!-- <div class="text-c">
         <a href="<?php echo U('Home/edit_xieyi');?>"><u>测试</u></a>   
       </div> -->  
    <div class="cl pd-5 bg-1 bk-gray">
        <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="40">ID</th>
                <th width="150">名称</th>
                <th width="200">地址</th>
                <th width="100">状态</th>
                <th width="100">更新时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td><input name="checkbox" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
                    <td><?php echo ($vo["id"]); ?></td>
                    <td><a href="<?php echo U('Home/edit_xieyi',['id'=>$vo['id']]);?>"><u><?php echo ($vo["title"]); ?></u></a></td>
                    <td>
                        <a target="_blank" href="<?php echo U('App/Merchant/agreement',['id'=>$vo['id']]);?>">
                        <u><?php echo U('App/Merchant/agreement',['id'=>$vo['id']]);?></u></a>
                    </td>

                    <td class="td-status">
                        <a href="javascript:void(0)" onclick="change_tuijian(<?php echo ($vo['id']); ?>,this)">
                            <u style="cursor:pointer" class="text-primary">
                                <?php if($vo['state'] == 1): ?><span class="label label-success radius">显示</span>
                                <?php else: ?>
                                <span class="label label-defaunt radius">隐藏</span><?php endif; ?>
                            </u>
                        </a>
                    </td>
                    <td><?php echo ($vo['uptime'] ?: $vo['intime']); ?></td>

                    <td class="td-manage">
                        <a style="text-decoration:none" class="ml-5"  href="<?php echo U('Home/edit_xieyi',['id'=>$vo['id']]);?>" title="编辑">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pages"><?php echo ($show); ?></div>

    </div>
    
</div>
<!--<script src="/assets/js/ZeroClipboard.js"></script>-->
<script type="text/javascript">
    function change_tuijian(v,s){
        var url = "<?php echo U('home/state_xieyi');?>";
        $.post(url,{id:v},function(data){
            console.log(data);
            if(data.data == 1){
                $(s).find("u").html('<span class="label label-defaunt radius">隐藏</span>');
            }else{
                $(s).find("u").html('<span class="label label-success radius">显示</span>');

            }
        },'json');
    }



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

    function del(kid){
        kid = kid ? kid : getChecked();
        kid = kid.toString();
        if(kid == ''){
            layer.msg('你没有选择任何选项！', {offset: 95,shift: 6});
            return false;
        }
        if(!confirm('删除后无法恢复，确定删除？'))
            return false;
        $.post("<?php echo U('Home/del_xieyi');?>", {ids:kid}, function(data){
            if( data.status == 'ok' ){
                popup.success(data.info);
                setTimeout(function(){
                    popup.close("asyncbox_success");
                },2000);
                window.location.href = data.url;
            }else{
                popup.error(data.info);
                setTimeout(function(){
                    popup.close("asyncbox_error");
                },2000);
            }
        },'json');
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