<?php if (!defined('THINK_PATH')) exit(); $uid = I('get.uid'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
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

<link rel="stylesheet" href="/Public/zTree/css/demo.css" type="text/css">

<div class="page-container">
	<div id="big"></div>
	<div id="big2"></div>
	<form class="form form-horizontal" id="form" method="post">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模块标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="title" class="input-text" value="<?php echo ($re["title"]); ?>" placeholder="模块标题" id="title" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">图片：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re["img"]); ?>');background-size: 220px 160px;" >
					<div class="instructions" onclick="del_image('1')">删除</div>
					<div id="uparea1"></div>
					<input type="hidden" name="con" id="content" value="" />
					<input type="hidden" name="img" id="image_1" value="<?php echo ($re["img"]); ?>" />
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>跳转属性：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="type" class="select" onchange="changeMk(this.value)">
					<option value="1" <?php if($re['type'] == 1): ?>selected<?php else: endif; ?>>无跳转</option>
					<option value="2" <?php if($re['type'] == 2): ?>selected<?php else: endif; ?>>WEB链接</option>
					<option value="3" <?php if($re['type'] == 3): ?>selected<?php else: endif; ?>>分类页</option>
					<option value="4" <?php if($re['type'] == 4): ?>selected<?php else: endif; ?>>商家</option>
					<option value="5" <?php if($re['type'] == 5): ?>selected<?php else: endif; ?>>商品</option>
					<option value="6" <?php if($re['type'] == 6): ?>selected<?php else: endif; ?>>优惠券</option>
					<option value="8" <?php if($re['type'] == 8): ?>selected<?php else: endif; ?>>用户</option>
				</select>
				</span> </div>
		</div>
		<div id="tag2" class="row tag cl <?php if($re['type'] == 2): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>跳转值：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($re['jump']); ?>" placeholder="跳转WEB页"  name="url" />
			</div>
		</div>
		<!-- <div id="tag3" class="row tag cl <?php if($re['type'] == 3): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="" class="input-text select" id="citySel" value="<?php echo ($class["class_name"]); ?>" onclick="checkMenu();" placeholder="选择分类"  />
				<input type="hidden" name="class_uuid" class="input-text select" id="class" value="<?php echo ($class["class_uuid"]); ?>"   />
				<div id="menuContent" class="menuContent" style="display:none; position:relative;">
					<ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; max-height: 200px;"></ul>
				</div>
			</div>
		</div> -->
		<div id="tag3" class="row tag cl <?php if($re['type'] == 3): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="" class="input-text select" id="citySel" value="<?php echo ($class["class_name"]); ?>" onclick="checkMenu();" placeholder="选择分类" readonly />
				<input type="hidden" name="class_uuid" class="input-text select" id="class" value="<?php echo ($class["class_uuid"]); ?>"   />
				<div id="menuContent" class="menuContent" style="display:none; position:relative;">
					<!-- <ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; max-height: 200px;"></ul> -->
					<span class="select-box">
							<?php if(is_array($parent)): $i = 0; $__LIST__ = $parent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><b><input type="radio" name="class_id" data="<?php echo ($vo["class_name"]); ?>" value="<?php echo ($vo["class_id"]); ?>"><?php echo ($vo["class_name"]); ?></b><br/>
								<?php if($vo['seed'] != '' ): ?><span class="select-box">
											<?php if(is_array($vo["seed"])): $i = 0; $__LIST__ = $vo["seed"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>&nbsp;&nbsp;<input type="radio" name="class_id" data="<?php echo ($v["class_name"]); ?>" value="<?php echo ($v["class_id"]); ?>"><?php echo ($v["class_name"]); endforeach; endif; else: echo "" ;endif; ?>
											
									</span>
								<?php else: endif; endforeach; endif; else: echo "" ;endif; ?>
					</span>
				</div>
			</div>
		</div>
		<div id="tag4" class="row tag cl <?php if($re['type'] == 4): else: ?>hiden<?php endif; ?>">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商家：</label>
		<div class="formControls col-xs-8 col-sm-9">
						<span class="select-box" style="width: 55%">
							<select id="merchant" name="merchant" class="select">
								<?php if(is_array($merchants)): $i = 0; $__LIST__ = $merchants;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["member_id"]); ?>" <?php if(($re['type'] == 4) AND ($re['jump'] == $vo['member_id'])): ?>selected<?php else: endif; ?>><?php echo ($vo["merchants_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</span>
			<input type="text"  class="input-text" style="width: 30%" value="" placeholder="商家店铺名"  />
			<button type="button" onclick="searchMerchant($(this))" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>
		</div>
		</div>
		<div id="tag5" class="row tag cl <?php if($re['type'] == 5): else: ?>hiden<?php endif; ?>">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品：</label>
		<div  class="formControls col-xs-8 col-sm-9">
						<span class="select-box" style="width: 55%">
							<select id="goods" name="goods" class="select">
								<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["goods_id"]); ?>" <?php if(($re['type'] == 5) AND ($re['jump'] == $vo['goods_id'])): ?>selected<?php else: endif; ?>><?php echo ($vo["goods_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</span>
			<input type="text"  class="input-text" style="width: 30%" value="" placeholder="商品名称"  />
			<button type="button" onclick="searchGoods($(this))" class="btn btn-success radius"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>
		</div>
		</div>
		
		<div id="tag6" class="row tag cl <?php if($re['type'] == 6): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>跳转值：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" readonly value="<?php echo C('IMG_PREFIX') ?>/webh5/coupon.html?uid=&token=" placeholder="优惠券页"  name="coupon" />
			</div>
		</div>

		<div id="tag8" class="row tag cl <?php if($re['type'] == 8): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户：</label>
			<div  class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width: 55%">
					<select id="user" name="user" class="select">
						<?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["user_id"]); ?>" <?php if(($re['type'] == 8) AND ($re['jump'] == $vo['user_id'])): ?>selected<?php else: endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</span>
				<input type="text"  class="input-text" style="width: 30%" value="" placeholder="用户名"  />
				<button type="button" onclick="searchUser($(this))" class="btn btn-success radius"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="submit btn btn-primary radius"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
				<input type="hidden" class="input-text" value="<?php echo ($re["dress_id"]); ?>" placeholder=""  name="dress_id">
				<input type="hidden" class="input-text" value="<?php echo ($_REQUEST["pid"]); ?>" placeholder=""  name="pid">
				<input type="hidden" class="input-text" value="1" placeholder=""  name="layout">
			</div>
		</div>
	</form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
	$('input[type=radio][name=class_id]').change(function() {
		id = $(this).val();
		v = $(this).attr('data');
		// alert(v)
		$.ajax({
            url: "<?php echo U('Home/getClassuuid');?>",
            type: "POST",
            async: false,
            data: {id: id},
            dataType: "json",
            success: function (data) {
                // console.log(data);
                if (data.status == 'ok') {
                    $('#class').val(data.data);
                    $("#citySel").attr("value", v);
                }
            },
            error: function (data) {

            }

        });
	})
		var  content ;
			KindEditor.ready(function(K) {
				content = K.create('#content',{
					allowFileManager : true,
					uploadJson:"<?php echo U('Common/upload');?>"
				});
			});

			KindEditor.ready(function(K) {
				K.create();
				var editor = K.editor({
					allowFileManager : true,
					uploadJson:"<?php echo U('Common/upload');?>"
					//sdl:false
				});
				K('#uparea1').click(function() {
					console.log(1);
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#image_1').val(),
							clickFn : function(url, title, width, height, border, align) {
								console.log(url);
								$('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
								K('#image_1').val(url);
								// K('#getImgUrl').val(url);
								editor.hideDialog();
							}
						});
					});
				});

			});

			

			$("#uparea1").mouseover(function(e){
				$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
				var img = $('#image_1').val();
				if(img.length !== 0) {
					$("#big").html('<img src="' + $('#image_1').val() + '" width=380 height=300>');
					$("#big").show();        //show：显示
				}
			});
			$("#uparea1").mouseout(function(){
				$("#big").hide();
			});



			// $(".submit").click(function(){
			// 	commonAjaxSubmit('','form');
			// 	return false;
			// });

			

		function changeMk(v){
			$('.tag').hide();
			$('#tag'+v).show();
		}

		function searchUser(v){
	        var name = $(v).prev('input').val();
	        var url  = "<?php echo U('Home/searchUser');?>";
	        $.post(url,{name:name},function(data){
				console.log(data);
	        	
	            $('#user').html(data);
	        })
	    }
        function searchMerchant(v){
            var name = $(v).prev('input').val();
            var url  = "<?php echo U('Home/searchMerchant');?>";
            $.post(url,{name:name},function(data){
                $('#merchant').html(data);
            })
        }
        function searchGoods(v){
            var name = $(v).prev('input').val();
            var url  = "<?php echo U('Home/searchGoods');?>";
            $.post(url,{name:name},function(data){
                $('#goods').html(data);
            })
        }

</script>
<script>
    var setting = {
        check: {
            enable: true,
            chkStyle: "radio",
            radioType: "all"
        },
        view: {
            dblClickExpand: true
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            onClick: onClick,
            onCheck: onCheck
        }
    };

    zNodes = new Array();
    function get_zNodes() {
        $.ajax({
            url: "<?php echo U('Home/getClass');?>",
            type: "POST",
            async: false,
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'ok') {
                    var arr = data.data;
                    for (var i = 0; i < arr.length; i++) {
                        var object = new Object();
                        object.id = parseInt(arr[i].class_id);
                        object.pId = 0;
                        object.name = arr[i].class_name;
                        object.class_uuid = arr[i].class_uuid;
                        object.isParent = true;
                        zNodes.push(object);
                        if (arr[i].seed.length > 0) {
                            for (var j = 0; j < arr[i].seed.length; j++) {
                                var object = new Object();
                                object.id = parseInt(arr[i].seed[j].class_id);
                                object.pId = parseInt(arr[i].seed[j].parent_id);
                                object.name = arr[i].seed[j].class_name;
                                object.class_uuid = arr[i].seed[j].class_uuid;
                                object.isParent = false;
                                zNodes.push(object);
                            }
                        }
                    }
                }
            },
            error: function (data) {

            }

        });
    }
    get_zNodes();



    function onClick(e, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.checkNode(treeNode, !treeNode.checked, null, true);
        return false;
    }

    function onCheck(e, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
            nodes = zTree.getCheckedNodes(true),
            v = "";
        class_uuid = '';
        console.log(nodes);
        for (var i=0, l=nodes.length; i<l; i++) {
            console.log(nodes[i]);
            v += nodes[i].name + ",";
            class_uuid = nodes[i].class_uuid + ",";
        }
        if (v.length > 0 ) v = v.substring(0, v.length-1);
        if (class_uuid.length > 0 ) class_uuid = class_uuid.substring(0, class_uuid.length-1);
        var cityObj = $("#citySel");
        cityObj.attr("value", v);
        $('#class').val(class_uuid)
    }

    function checkMenu(){
        if($("#menuContent").is(":hidden")){
            showMenu();    //如果元素为隐藏,则将它显现
        }else{
            hideMenu();     //如果元素为显现,则将其隐藏
        }
    }

    function showMenu() {
//        $("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
        $("#menuContent").slideDown("fast");
        $("body").bind("mousedown", onBodyDown);
    }
    function hideMenu() {
        $("#menuContent").fadeOut("fast");
        $("body").unbind("mousedown", onBodyDown);
    }
    function onBodyDown(event) {
        if (!(event.target.id == "menuBtn" || event.target.id == "citySel" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
            hideMenu();
        }
    }

    $(document).ready(function(){
        console.log(zNodes);
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->