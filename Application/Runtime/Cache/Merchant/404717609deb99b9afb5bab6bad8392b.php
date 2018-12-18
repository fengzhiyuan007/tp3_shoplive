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
    .ctextarea {
        /*height: 100px;*/
        resize: none;
        font-size: 14px;
        padding: 4px;
    }
</style>
<body>
<div class="page-container">
    <div id="big"></div>
    <div id="big2"></div>
    <form class="form form-horizontal" id="form" method="post">
        
        <div class="cl pd-5 bg-1 bk-gray mt-5">
        <div><b>快递物流信息</b></div>
        <div class="mt-5">
            <form data-action="<?php echo U('edit_kuaidi',['id'=>$re['id']]);?>"  method="post" class="ajax-form form form-horizontal mt-5" id="form-article-add">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">物流公司：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 60%">
                    <select name="logistics_name" id="logistics_name"  class="select" onchange="getExpressNode(this.value)">
                        <option value="">请选择快递</option>
                        <?php if(is_array($express_node)): $i = 0; $__LIST__ = $express_node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["express"]); ?>" <?php if($re['logistics_name'] == $vo['express']): ?>selected<?php endif; ?>><?php echo ($vo["express"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    </span>
                        <input type="text" value="" name="" id="express" placeholder="物流公司" style="width: 21%" class="input-text">
                        <button type="button" onclick="getExpress($('#express').val())" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">企业标志：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" value="<?php echo ($re['logistics_pinyin']); ?>" name="logistics_pinyin" id="logistics_pinyin" placeholder="物流公司标志" readonly class="input-text" style="width:90%">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">物流单号：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" value="<?php echo ($re['logistics_no']); ?>" name="logistics_no" id="logistics_no" placeholder="物流快递单号" class="input-text" style="width:90%">
                    </div>
                </div>
                
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <button  class="submit btn btn-primary radius blue_btn"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                        <input type="hidden" value="<?php echo ($re['order_no']); ?>" name="order_no" id="order_no"  class="input-text" style="width:90%">
                        <!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
                        <button  class="btn btn-default radius view_kuaidi" type="button">&nbsp;&nbsp;查看快递&nbsp;&nbsp;</button>
                    </div>
                </div>
            </form>
        </div>
  </form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    

        $(".view_kuaidi").click(function(){
            var kuaidi_name = $('#logistics_name').val();
            var kuaidi = $('#logistics_no').val();
            var url = document.URL;
            var url = 'http://m.kuaidi100.com/index_all.html?type='+kuaidi_name+'&postid='+kuaidi+'&callbackurl=';
            layer_show('查看快递',url,'','510');
            return false;
            if(kuaidi.length < 5){
                layer.msg("物流单号不能小于5个字符",{icon:5,time:1000})
                return false;
            }else{
                var url = 'http://m.kuaidi100.com/index_all.html?type='+kuaidi_name+'&postid='+kuaidi+'&callbackurl=';
                layer_show('查看快递',url,'','510');
            }
        });

        

        


        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

    function down(v,e){
        window.location.href = "system.php?m=Admin&c=Horder&a=down_diy&order_no="+v+"&url="+e;
    }
    function getExpressNode(v){
        var url = "<?php echo U('getExpressNode');?>";
        $.get(url,{express:v},function(data){
            $("#logistics_pinyin").val(data);
        });
    }
    function getExpress(v){
        var url = "<?php echo U('getExpress');?>";
        $.get(url,{express:v},function(data){
            console.log(data);
            $("#logistics_name").html(data);
        });
    }

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
    
    
    
    
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