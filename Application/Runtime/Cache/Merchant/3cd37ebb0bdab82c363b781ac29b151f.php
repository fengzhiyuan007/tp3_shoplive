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


<div class="page-container">
	<div class="text-l">
		<form class="search"  method="get">
			<input type="text" class="input-text" style="width:200px" placeholder="搜索商品名称、编号" value="<?php echo ($_REQUEST["name"]); ?>" name="name">
			<span class="select-box" style="width:150px">
			<select name="goods_state"  class="select select-box inlin" style="width:120px" id="goods_state">
				<option value="">商品状态</option>
				<option value="1" <?php if( $_REQUEST["goods_state"] == 1): ?>selected<?php else: endif; ?>>上架状态</option>
				<option value="2" <?php if( $_REQUEST["goods_state"] == 2): ?>selected<?php else: endif; ?>>下架状态</option>
			</select>
			</span>
			<span class="select-box" style="width:150px">
				<select name="parent_class" id="parent_class" onchange="change_class(this.value)" class="select">
					<option value="">一级分类</option>
					<?php if(is_array($parent_class)): $i = 0; $__LIST__ = $parent_class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['class_id']); ?>" <?php if($_REQUEST["parent_class"] == $vo['class_id']): ?>selected<?php endif; ?>><?php echo ($vo['class_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</span>
			<span class="select-box" style="width:150px">
			<select name="seed_class" id="seed_class" class="select">
				<option value="">二级分类</option>
				<?php if($re['seed_class'] != '' ): if(is_array($seed_class)): foreach($seed_class as $key=>$v): ?><option value="<?php echo ($v["class_id"]); ?>" <?php if( $_REQUEST["seed_class"] == $v['class_id']): ?>selected<?php endif; ?>><?php echo ($v["class_name"]); ?></option><?php endforeach; endif; endif; ?>
			</select>
			</span>
			<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜商品</button>
			
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="recovery_goods()" class="btn btn-primary radius">
				<i class="Hui-iconfont">&#xe615;</i> 批量恢复
			</a>
		</span>
		<!--<span class="l">-->
			<!--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">-->
				<!--<i class="Hui-iconfont">&#xe6e2;</i> 彻底删除-->
			<!--</a>-->
		<!--</span>-->
		<span class="r">共有数据：<strong><?php echo ((isset($count) && ($count !== ""))?($count):0); ?></strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="100">图片</th>
				<!-- <th width="100">二维码</th> -->
				<th width="200">商品名称</th>
				<!--<th width="70">编码</th>-->
				<th width="50">原价</th>
				<th width="50">售价</th>
				<!--<th width="50">总销量</th>-->
				<th width="50">库存</th>
				<th width="60">排序</th>
				<th width="60">置顶</th>
				<th width="60">状态</th>
				<!--<th width="60">推荐</th>-->
				<th width="120">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
					<td><input type="checkbox" value="<?php echo ($vo["goods_id"]); ?>" name="checkbox"></td>
					<td><?php echo ($vo["goods_id"]); ?></td>
					<td><img src="<?php echo ($vo["goods_img"]); ?>" style="width:50px; height:50px; border-radius:25px;"></td>
					<!-- <td><img src="<?php echo ($vo["goods_qrcode"]); ?>" onclick="view_play_img('<?php echo U('Goods/goods_qrcode',['goods_id'=>$vo.goods_id]);?>')" style="width:50px; height:50px; border-radius:25px;"></td> -->
					<td><a href="<?php echo U('Goods/edit_goods',['goods_uuid'=>$vo['goods_uuid']]);?>"><u style="cursor:pointer" class="text-primary" ><?php echo ($vo["goods_name"]); ?></u></a></td>
					<!--<td><?php echo ($vo['goods_num']); ?></td>-->
					<td><?php echo ($vo['goods_origin_price']); ?></td>
					<td><?php echo ($vo['goods_now_price']); ?></td>
					<!--<td><?php echo ($vo['total_sales']); ?></td>-->
					<td><?php echo ($vo['goods_stock']); ?></td>
					<td>
						<a href="javascript:void(0)" onclick="plus(<?php echo ($vo['goods_id']); ?>)" title="上移">
							<i class="Hui-iconfont">&#xe679;</i>
						</a>
						<a href="javascript:void(0)" onclick="minus(<?php echo ($vo['goods_id']); ?>)" title="下移">
							<i class="Hui-iconfont">&#xe674</i>
						</a>
					</td>
					<td>
						<a href="javascript:void(0)" style="display: block" onclick="go_top(<?php echo ($vo['goods_id']); ?>)" title="置顶"><i class="Hui-iconfont">&#xe699;</i></a>
						<a href="javascript:void(0)" style="display: block" onclick="go_after(<?php echo ($vo['goods_id']); ?>)" title="置后"><i class="Hui-iconfont">&#xe698;</i></a>
					</td>
					<td class="td-status">
						<?php if($vo['goods_state'] == 2): ?><span class="label label-defaunt radius">已下架</span>
							<?php else: ?>
							<span class="label label-success radius">已发布</span><?php endif; ?>
					</td>
					
					<td class="td-manage">
						
						<a title="恢复" href="javascript:;" onclick="recovery_goods(this,'<?php echo ($vo["goods_id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
        <div class="pages"><?php echo ($show); ?></div>
		
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
			$.post("<?php echo U('Goods/del_goods');?>", {ids:kid}, function(data){
				if( data.status == 'ok' ){
					layer.msg(data.data.info,{icon:1,time:1000});
					window.location.href = data.url;
				}else{
					layer.msg(data.error,{icon:5,time:1000});
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
			$.post("<?php echo U('Goods/change_goods_status');?>",{id:id},function(data){
				if(data.data == 2){
					$(obj).parent().prepend('<a style="text-decoration:none"  onClick="member_start(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
					$(obj).parent().siblings('.td-status').html('<span class="label label-defaunt radius">已下架</span>');
					$(obj).remove();
					layer.msg('已下架!',{icon: 5,time:1000});
				}
			},'json')
		});
	}

	/*用户-启用*/
	function member_start(obj,id){
		layer.confirm('确认要上架吗？',function(index){
			$.post("<?php echo U('Goods/change_goods_status');?>",{id:id},function(data){
				if(data.data == 1){
					$(obj).parent().prepend('<a style="text-decoration:none" class="ml-5" onClick="member_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
					$(obj).parent().siblings('.td-status').html('<span class="label label-success radius">已发布</span>');
					$(obj).remove();
					layer.msg('已发布!',{icon: 6,time:1000});
				}
			},'json');

		});
	}
	/*用户-编辑*/
	function member_edit(title,url,id,w,h){
		layer_show(title,url,w,h);
	}
	/*密码-修改*/
	function change_password(title,url,id,w,h){
		layer_show(title,url,w,h);
	}
	/*用户-删除*/
function del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.post("<?php echo U('Goods/del_goods');?>", {ids:id}, function(data){
			if( data.status == 'ok' ){
				$(obj).parent().parent().remove();
				layer.msg('已删除!',{icon:1,time:1000});
			}else{
				layer.msg(data.error,{icon:5,time:1000});
			}
		},'json');
	});
}

	/*商品-复制*/
function copy(id,v){
	var id = id;
	$.post("<?php echo U('Goods/copy_goods');?>",{id:id},function(data){
		if(data['status'] == 'ok'){
			layer.msg('复制商品成功',{icon:1,time:1500});
			window.location.href = window.location.href;
		}else{
			alert(data['info']);
		}
	},'json');
	return false;
}

function plus(v){
    var name = "<?php echo ($_REQUEST["name"]); ?>";
    var goods_state = "<?php echo ($_REQUEST["goods_state"]); ?>";
    var class_id = "<?php echo ($_REQUEST["class_id"]); ?>";
	$.post("<?php echo U('Goods/plus_goods_sort');?>",{goods_id:v,name:name,goods_state:goods_state,class_id:class_id},function(data){
		if(data['status'] == 'ok'){
			layer.msg(data.data,{icon:1,time:2000},function(v){
				window.location.href = window.location.href;
			})
		}else{
			layer.msg(data.error,{icon:5,time:2000})
		}
	},'json');
}

function minus(v){
    var name = "<?php echo ($_REQUEST["name"]); ?>";
    var goods_state = "<?php echo ($_REQUEST["goods_state"]); ?>";
    var class_id = "<?php echo ($_REQUEST["class_id"]); ?>";
	$.post("<?php echo U('Goods/minus_goods_sort');?>",{goods_id:v,name:name,goods_state:goods_state,class_id:class_id},function(data){
		if(data['status'] == 'ok'){
			layer.msg(data.data,{icon:1,time:2000},function(v){
				window.location.href = window.location.href;
			})
		}else{
			layer.msg(data.error,{icon:5,time:2000})
		}
	},'json');
}

function go_top(v){
	$.post("<?php echo U('Goods/top');?>",{goods_id:v},function(data){
		if(data['status'] == 'ok'){
			layer.msg(data.data,{icon:1,time:1000},function(v){
				window.location.href = window.location.href;
			})
		}else{
			layer.msg(data.error,{icon:5,time:1000})
		}
	},'json');
};

function go_after(v){
	$.post("<?php echo U('Goods/after');?>",{goods_id:v},function(data){
		if(data['status'] == 'ok'){
			layer.msg(data.data,{icon:1,time:1000},function(v){
				window.location.href = window.location.href;
			})
		}else{
			layer.msg(data.error,{icon:5,time:1000})
		}
	},'json');
};

function recovery_goods(obj,kid){
    kid = kid ? kid : getChecked();
    kid = kid.toString();
    if(kid == ''){
        layer.msg('你没有选择任何选项！', {offset: 95,shift: 6});
        return false;
    }
    layer.confirm('确认要恢复选中商品吗？',function(index){
        $.post("<?php echo U('Goods/recovery_goods');?>", {ids:kid}, function(data){
            if( data.status == 'ok' ){
                layer.msg(data.data.info,{icon:1,time:1000},function(v){
                	  location.replace(location.href)
                });
            }else{
                layer.msg(data.error,{icon:5,time:1000});
            }
        },'json');
    })
}
function change_category(e){
	if(!e || e==''){
		return false;
	}
	var url = "<?php echo U('Goods/get_son_category');?>";
	$.post(url,{first:e},function(data){
		$("#second_category").html(data);
	})
};

function change_tuijian(v,s){
    var url = "<?php echo U('Goods/change_goods_tuijian');?>";
    $.post(url,{id:v},function(data){
        if(data.info == 1){
            $(s).find("u").html('<span class="label label-defaunt radius">未推荐</span>');
		}else{
            $(s).find("u").html('<span class="label label-success radius">已推荐</span>');
		}
	},'json');
}

function change_class(e){
    if(!e || e==''){
        return false;
    }
    console.log(e);
    var url = "<?php echo U('Goods/get_seed_class');?>";
    $.post(url,{parent:e},function(data){
        $("#seed_class").html(data);
    })
}

function view_play_img(v){
    layer.open({
        type: 2,
        title: false,
        area: ['500px', '500px'],
        shade: 0.1,
        closeBtn: 1,
        shadeClose: false,
        content: v,
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