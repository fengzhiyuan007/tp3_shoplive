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


<style>
	.ibutton { padding: 3px 15px; *padding: 0 15px; *height: 24px;  font-size: 12px; text-align: center; text-shadow: #CF510B 0 1px 0; border:1px solid #ec5c0d; border-radius: 2px; background: #FC750A; background-image: -webkit-linear-gradient(top, #fc8746, #ec5d0e); color:#FFF; cursor: pointer; display: inline-block; }
	/*a  upload */
	.a-upload {
		padding: 4px 10px;
		/*height: 20px;*/
		line-height: 20px;
		position: relative;
		cursor: pointer;
		color: #888;
		background: #fafafa;
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
		display: inline-block;
		*display: inline;
		*zoom: 1
	}

	.a-upload  input {
		position: absolute;
		font-size: 100px;
		right: 0;
		top: 0;
		opacity: 0;
		filter: alpha(opacity=0);
		cursor: pointer
	}

	.a-upload:hover {
		color: #444;
		background: #eee;
		border-color: #ccc;
		text-decoration: none
	}
	*{ margin:0px; padding:0px; font-family:Microsoft Yahei; box-sizing:border-box; -webkit-box-sizing:border-box;}
	.ul_pics{ float:left;}
	.ul_pics li{float:left; margin:0px; padding:0px; margin-left:5px; margin-top:5px; position:relative; list-style-type:none; border:1px solid #eee;}
	.ul_pics li img{width:80px;height:80px;}
	.ul_pics li i{ position:absolute; top:0px; right:-1px; background:red; cursor:pointer; font-style:normal; font-size:10px; width:14px;
		height:14px; text-align:center; line-height:12px; color:#fff;}
	.progress{position:relative;  background:#eee;height:15px;line-height:15px;}
	.bar {background-color: green; display:block; width:0%; height:15px; }
	.percent{ height:15px;  text-align:center;  left:0px; color:#666; line-height:15px; font-size:12px; }
	.table td {
	    text-align: center;
	}
</style>
	<div id="big"></div>
	<div id="big2"></div>
	<form class="form form-horizontal" action="<?php echo U('edit_activity');?>" id="form" method="post">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="title" class="input-text" value="<?php echo ($re['title']); ?>" placeholder="活动标题" id="title" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">封面：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re['img']); ?>');background-size: 220px 160px;" >
					<div class="instructions" onclick="del_image('1')">删除</div>
					<div id="uparea1"></div>
					<input type="hidden" name="con" id="content" value="" />
					<input type="hidden" name="img" id="image_1" value="<?php echo ($re['img']); ?>" />
					<input type="hidden" name="img_width" id="image_width" value="<?php echo ($re['img_width']); ?>" />
					<input type="hidden" name="img_height" id="image_height" value="<?php echo ($re['img_height']); ?>" />
					<div class="instructions" style="top: 135px;color: red;">建议尺寸750*350,图片小于2M</div>
				</div>
			</div>
		</div>
	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">铭牌（非必传）：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="droparea spot" id="image2" style="background-image: url('<?php echo ($re['plate']); ?>');background-size: 220px 160px;" >
					<div class="instructions" onclick="del_image('2')">删除</div>
					<div id="uparea2"></div>
					<input type="hidden" name="plate" id="image_2" value="<?php echo ($re['plate']); ?>" />
					<div class="instructions" style="top: 135px;color: red;">建议尺寸750*350,图片小于2M</div>
				</div>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动种类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
					<select name="type" class="select" onchange="changeMk(this.value)">
						<option value="1" <?php if($re['type'] == 1): ?>selected<?php else: endif; ?>>预播</option>
						<option value="2" <?php if($re['type'] == 2): ?>selected<?php else: endif; ?> disabled="disabled">直播</option>
						<option value="3" <?php if($re['type'] == 3): ?>selected<?php else: endif; ?> disabled="disabled">录播</option>
						<option value="4" <?php if($re['type'] == 4): ?>selected<?php else: endif; ?>>视频</option>
						<option value="5" <?php if($re['type'] == 5): ?>selected<?php else: endif; ?>>图片</option>
						<option value="6" <?php if($re['type'] == 6): ?>selected<?php else: endif; ?>>文章</option>
					</select>
				</span>
			</div>
		</div>

		<div id="tag1" class="row tag cl <?php if($re['type'] == 1): else: ?>hiden<?php endif; ?>">
			<label class="form-label col-xs-4 col-sm-2">预播时间：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text "  id="play_time" style="width:190px" name="play_time" value="<?php echo ($re['play_time']); ?>"  placeholder="预播时间" readonly>
			</div>
		</div>

		<div id="tag4" class="row tag cl <?php if(($re['type'] == 1) OR ($re['type'] == 4)): else: ?>hiden<?php endif; ?>">
		
			<div id="upload" >
				<label class="form-label col-xs-4 col-sm-2">视频：</label>
				<div  class="formControls col-xs-8 col-sm-9">
					<div href="javascript:void(0);" class="a-upload" rel="external nofollow" id="btn">
					<!--<input name="video" value="" id="video" type="file" accept="video/*"><?php echo ($_GET['id']?'点击这里更换视频':'点击这里上传视频'); ?>-->
						<!-- <?php echo ($uid?'点击这里更换视频':'点击这里上传视频'); ?> -->
						<?php if( $re['url'] != '' ): ?>点击这里更换视频<?php else: ?>点击这里上传视频<?php endif; ?>
					</div>
					<input name="url" type="hidden" id="url" value="<?php echo ($re['url']); ?>" />
					<san>建议上传mp4格式，大小不要超过700M</san>
				</div>
			</div>
			<div class="">
				<label class="form-label col-xs-4 col-sm-2"></label>
				<div  class="formControls col-xs-8 col-sm-9">
					<ul id="ul_pics" class="ul_pics clearfix">
					</ul>
				</div>
			</div>
		</div>

		<div id="tag5" class="row tag cl <?php if($re['type'] == 5): else: ?>hiden<?php endif; ?>">
			<div class="" style="margin-bottom: 25px;">
				<label class="form-label col-xs-4 col-sm-2">图片：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<div class="droparea spot" id="image11" style="background-image: url('<?php echo ($re['imgs'][0]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('11')">删除</div>
						<div id="uparea11"></div>
						<input type="hidden" name="imgs[]" id="image_11" value="<?php echo ($re['imgs'][0]); ?>" />
						
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>

					<div class="droparea spot" id="image12" style="background-image: url('<?php echo ($re['imgs'][1]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('12')">删除</div>
						<div id="uparea12"></div>
						<input type="hidden" name="imgs[]" id="image_12" value="<?php echo ($re['imgs'][1]); ?>" />
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>

					<div class="droparea spot" id="image13" style="background-image: url('<?php echo ($re['imgs'][2]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('13')">删除</div>
						<div id="uparea13"></div>
						<input type="hidden" name="imgs[]" id="image_13" value="<?php echo ($re['imgs'][2]); ?>" />						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>

					<div class="droparea spot" id="image14" style="background-image: url('<?php echo ($re['imgs'][3]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('14')">删除</div>
						<div id="uparea14"></div>
						<input type="hidden" name="imgs[]" id="image_14" value="<?php echo ($re['imgs'][3]); ?>" />
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>

					<div class="droparea spot" id="image15" style="background-image: url('<?php echo ($re['imgs'][4]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('15')">删除</div>
						<div id="uparea15"></div>
						<input type="hidden" name="imgs[]" id="image_15" value="<?php echo ($re['imgs'][4]); ?>" />
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>

					<div class="droparea spot" id="image16" style="background-image: url('<?php echo ($re['imgs'][5]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('16')">删除</div>
						<div id="uparea16"></div>
						<input type="hidden" name="imgs[]" id="image_16" value="<?php echo ($re['imgs'][5]); ?>" />
						<div class="instructions" style="top: 135px;color: red;">建议尺寸750*750,图片小于2M</div>
					</div>
				</div>
			</div>
		</div>

		<div id="tag6" class="row tag cl <?php if($re['type'] == 6): else: ?>hiden<?php endif; ?>">
			<div class="" style="margin-bottom: 25px;">
				<label class="form-label col-xs-4 col-sm-2">文章：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<textarea name="detail"  id="content1" style='width:100%;height:300px;'  placeholder="说点什么...最少输入10个字符" ><?php echo ($re['detail']); ?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box" style="width: 23%">
                    <select name="sheng" onchange="area_linke1(this.value)" class="select">
                        <option value="">请选择</option>
                        <?php if(is_array($sheng)): $i = 0; $__LIST__ = $sheng;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l["id"]); ?>" <?php if( $re["sheng"] == $l["name"] ): ?>selected<?php else: endif; ?>><?php echo ($l["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
				</span>
                <span class="select-box" style="width: 23%">
                    <select name="shi" id="shi" onchange="area_linke2(this.value)" class="select">
                            <option value=''>请选择（市）</option>
                            <?php if(is_array($re["shis"])): $i = 0; $__LIST__ = $re["shis"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["city_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
                <span class="select-box" style="width: 23%">
                    <select name="qu" id="qu" class="select">
                        <option value=''>请选择（区/县）</option>
                        <?php if(is_array($re["qus"])): $i = 0; $__LIST__ = $re["qus"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["area_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
            </div>
        </div>
 

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>详细地址：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="address" class="input-text" value="<?php echo ($re['address']); ?>" placeholder="地址" id="address" />
			</div>
		</div>

		

		<div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>标签：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <?php if(is_array($tag)): $k = 0; $__LIST__ = $tag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><input name="tag[]" type="checkbox" <?php if($k > 1): ?>style="margin-top:1px;margin-left:10px;"<?php else: ?>style="margin-top:1px;"<?php endif; ?> <?php if(in_array($vo['name'],$tagids)): ?>checked<?php endif; ?> value="<?php echo ($vo['name']); ?>"><span style="margin-left: 5px;"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户：</label>
			<div  class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width: 55%">
					<select id="user" name="user_id" class="select">
						<?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["user_id"]); ?>" <?php if($re['user_id'] == $vo['user_id']): ?>selected<?php else: endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</span>
				<input type="text"  class="input-text" style="width: 30%" value="" placeholder="用户名"  />
				<button type="button" onclick="searchUser($(this))" class="btn btn-success radius"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品：</label>
			<div  class="formControls col-xs-8 col-sm-9">
				<!-- <input type="text"  class="input-text" style="width: 30%" value="" placeholder="用户名"  /> -->
				<button type="button" onclick="category_edit('商品信息','<?php echo U('goods_list');?>','9','950','510')" class="btn btn-primary radius"  name=""><i class="Hui-iconfont">&#xe600;</i> 添加商品 </button>
			</div>
		</div>
		
		<table style="margin:0 auto;width:83%;" class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
			<tr class="text-c">
				<th width="10%">ID</th>
				<th width="">图片</th>
				<th width="">商品名称</th>
				<th width="">操作</th>
			</tr>
			</thead>
			<tbody id="goods">
			<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
					<td>
						<input type="text" name="goods_id[]" class="input-text" value="<?php echo ($vo["goods_id"]); ?>" readonly placeholder="商品ID" />
					</td>
					<td >
						<img src="<?php echo ($vo["goods_img"]); ?>" style="width:50px; height:50px; border-radius:25px;">
					</td>
					<td><?php echo ($vo["goods_name"]); ?></td>	
					<td>
						<button style="margin-top: 10px" onclick="del_goods(this,<?php echo ($vo["goods_id"]); ?>)" class="btn btn-danger radius"  type="button"><i class="Hui-iconfont">&#xe609;</i></button>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			
			</tbody>
		</table>
		<!-- <?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="row cl">
				<label class="form-label col-xs-4 col-sm-2" style="margin-top: 10px">商品名称：</label>
				<div class="formControls col-xs-8 col-sm-1" style="margin-top: 10px">
					<input type="text" name="goods_id[]" class="input-text" value="<?php echo ($vo["goods_id"]); ?>" readonly placeholder="商品ID" />
				</div>
				<div class="formControls col-xs-8 col-sm-6" style="margin-top: 10px">
					<input type="text" name="" class="input-text" value="<?php echo ($vo["goods_name"]); ?>" disabled="" placeholder="商品名称" />
				</div>
				<button style="margin-top: 10px" onclick="del_goods(this,<?php echo ($vo["goods_id"]); ?>)" class="btn btn-danger radius"  type="button"><i class="Hui-iconfont">&#xe609;</i></button>
			</div><?php endforeach; endif; else: echo "" ;endif; ?> -->
			
		<!--表格-->
		<!-- <table id="goods" style="width:80%;margin: 10px auto;" class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th width="25"><input type="checkbox" name="" value=""></th>
					<th width="40">ID</th>
					<th width="100">图片</th>
					<th width="200">商品名称</th>
					<th width="50">原价</th>
					<th width="50">售价</th>
					<th width="50">库存</th>
					<th width="50">店铺</th>
					<th width="60">状态</th>
					<th width="60">审核状态</th>
					<th width="60">推荐</th>
				</tr>
			</thead>
		</table> -->
		<!--表格-->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>权重：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="number" name="sort" class="input-text" value="<?php echo ($re['sort']); ?>" placeholder="权重" id="sort" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="summary"  oninput="textCounter(this,200)" onPropertyChange="textCounter(this,200)" style="width:100%;height:80px;" value="<?php echo ($re['summary']); ?>" placeholder="请填写视频简介"><?php echo ($re['summary']); ?></textarea>
				&nbsp;<span class="important">*</span>限定200字
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="submit btn btn-primary radius"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
				<input type="hidden" class="input-text" value="<?php echo ($re["a_id"]); ?>" placeholder=""  name="a_id">
			</div>
		</div>
	</form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/admin/plupload/js/moxie.js"></script>
<!--<script type="text/javascript" src="/assets/js/plupload/js/plupload.dev.js"></script>-->
<script type="text/javascript" src="https://cdn.staticfile.org/plupload/2.1.5/plupload.min.js"></script>
<script type="text/javascript" src="/Public/admin/plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="/Public/admin/qiniu-js-sdk/dist/qiniu.js"></script>
<script type="text/javascript">
var goodsstr = "<?php echo ($re['goods_id']); ?>";
console.log(goodsstr);
function quchong(str){
	var ret = [];
	var re = str.split(',');
	str.replace(/[^,]+/g, function($0, $1){
	    (str.indexOf($0) == $1) && ret.push($0);
	})
	return ret.toString()+',';
}
/*字符串转数组*/
function toarr(strs){
	var rets = [];
	var res = strs.split(',');
	strs.replace(/[^,]+/g, function($0, $1){
	    (strs.indexOf($0) == $1) && rets.push($0);
	})
	return rets;
}
/*字符串转数组*/

function del_goods(obj,id){
	$(obj).parent().parent().remove();

	r1 = toarr(goodsstr);

	r1.remove(id);

	goodsstr = r1.join(',');
	console.log(goodsstr);


}

/*删除数组某个元素*/
Array.prototype.indexOf = function (val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};

Array.prototype.remove = function (val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};
/*删除数组某个元素*/



(function(){
	var url = window.location.href;
	var str = url.split('/')[7];
	console.log(str);
	if(str == undefined){
		$('#tag4').show();
		$('#tag1').show();
	}
})()


	function category_edit(title,url,id,w,h){
        // layer_show(title,url,w,h);
        if (title == null || title == '') {
			title=false;
		};
		if (url == null || url == '') {
			url="404.html";
		};
		if (w == null || w == '') {
			w=800;
		};
		if (h == null || h == '') {
			h=($(window).height() - 50);
		};
        layer.open({
			type: 2,
			area: [w+'px', h +'px'],
			fix: false, //不固定
			maxmin: true,
			shade:0.4,
			shadeClose: true,
			title: title,
			content: url,
			btn: ['确定','关闭'],
			yes: function(index){
                //当点击‘确定’按钮的时候，获取弹出层返回的值
                var res = window["layui-layer-iframe" + index].callbackdata();
                //打印返回的值，看是否有我们想返回的值。
                
                goodsstr += ','+res['kids']+',';
                goodsstr = quchong(goodsstr);
                console.log(goodsstr);

                $.post("<?php echo U('add_goods');?>", {kid:goodsstr}, function(v){

                	good = JSON.parse(v);
                	// console.log(good);
                	$('#goods').html('');
                	for(var j = 0,len = good.length; j < len; j++){
					    console.log(good[j]);
					    $('#goods').prepend('<tr class="text-c">\
					<td>\
						<input type="text" name="goods_id[]" class="input-text" value="'+good[j]['goods_id']+'" readonly placeholder="商品ID" />\
					</td>\
					<td >\
						<img src="'+good[j]['goods_img']+'" style="width:50px; height:50px; border-radius:25px;">\
					</td>\
					<td>'+good[j]['goods_name']+'</td>\
					<td>\
						<button style="margin-top: 10px" onclick="del_goods(this,'+good[j]['goods_id']+')" class="btn btn-danger radius"  type="button"><i class="Hui-iconfont">&#xe609;</i></button>\
					</td>\
				</tr>');
					}
					//good[j]['goods_id']
                	// $('#goods').html(good);
                	

				});

                //最后关闭弹出层
                layer.close(index);
            },
            cancel: function(){
                //右上角关闭回调
            }
		});
    }

	UE.getEditor('content1');

	function changeMk(v){
		if(v==1){
			$('.tag').hide();
			$('#tag4').show();
			$('#tag1').show();
		}else{
			$('.tag').hide();
			$('#tag'+v).show();
		}
		
	}

	function searchUser(v){
        var name = $(v).prev('input').val();
        var url  = "<?php echo U('Home/searchUser');?>";
        $.post(url,{name:name},function(data){
			console.log(data);
        	
            $('#user').html(data);
        })
    }

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
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_1').val(),
						clickFn : function(url, title, width, height, border, align) {
							console.log(url);
							console.log(width);
							console.log(height);

							// 图片地址
var img_url = url;

// 创建对象
var img = new Image();

// 改变图片的src
img.src = img_url;

// 打印
// alert('width:'+img.width+',height:'+img.height);

							$('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_1').val(url);
							K('#image_width').val(img.width);
							K('#image_height').val(img.height);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

			K('#uparea2').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_2').val(),
						clickFn : function(url, title, width, height, border, align) {
							console.log(url);
							$('#image2').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_2').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});


			K('#uparea11').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_11').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            console.log(url);
                            $('#image11').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_11').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea12').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_12').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image12').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_12').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea13').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_13').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image13').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_13').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea14').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_14').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image14').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_14').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea15').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_15').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image15').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_15').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#uparea16').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_16').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image16').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_16').val(url);
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

		$("#uparea2").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_2').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_2').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea2").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea11").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_11').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_11').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea11").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea12").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_12').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_12').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea12").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea13").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_13').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_13').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea13").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea14").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_14').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_14').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea14").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea15").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_15').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_15').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea15").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea16").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_16').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_16').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea16").mouseout(function(){
			$("#big").hide();
		});

//		$("#video").change(function(){
//			var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
//			var formData = new FormData();
//			formData.append("video", $('#video')[0].files[0]);
//			$.ajax({
//				url: "<?php echo U('Tools/upload_video');?>" ,
//				type: 'POST',
//				data: formData,
//				async: true,
//				cache: false,
//				contentType: false,
//				processData: false,
//				dataType:"JSON",
//				success: function (data) {
//				    console.log(data);
//					layer.close(index);
//					if(data['status'] == 'ok'){
//						$('#url').val(data['url']);
//						$('.url').html('上传成功！');
//					}else{
//						$('.url').html(data['info']);
//					}
//				},
//				error: function (data) {
//					console.log(data);
//				}
//			});
//		});

		$(".preview").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var data = $(this).attr('data');
			console.log(data);
			var img = $('#preview_'+data).val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + img + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$(".preview").mouseout(function(){
			$("#big").hide();
		});

		$(".pic3").mouseover(function(e){
			$("#big2").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			$("#big2").html('<img src="'+this.src+'" width=380 height=300>');
			$("#big2").show();        //show：显示
		});
		$(".pic3").mouseout(function(){
			$("#big2").hide();
		});
	function area_linke1(value){
		$.post("<?php echo U('Business/get_area');?>", {value:value,type:1}, function(v){

			$("#shi").html(v);

		});
	}
	function area_linke2(value){
		$.post("<?php echo U('Business/get_area');?>", {value:value,type:2}, function(v){

			$("#qu").html(v);

		});
	}

    function textCounter(field, maxlimit) {
        var num = $(field).val();
        if(num.length > maxlimit){
            $(field).val(num.substring(0,maxlimit));
        }
    }

    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',    //上传模式,依次退化
        browse_button: 'btn',       //上传选择的点选按钮，**必需**
        uptoken_url: "<?php echo U('Index/get_qiniu_token');?>",            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        // uptoken : '', //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
        // unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
        // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
        //domain: 'http://msplay.qqyswh.com',   //bucket 域名，下载资源时用到，**必需**
        domain: 'http://dspxplay.tstmobile.com',   //bucket 域名，下载资源时用到，**必需**
        get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
        container: 'upload',           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '1000mb',           //最大文件体积限制
        flash_swf_url: '/Public/admin/plupload/js/Moxie.swf',  //引入flash,相对路径
        silverlight_xap_url: "/Public/admin/plupload/js/Moxie.xap",
        max_retries: 3,                   //上传失败最大重试次数
        dragdrop: true,                   //开启可拖曳上传
        drop_element: 'upload',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        unique_names: true,
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        filters: {
            mime_types : [
                {title : "Image files", extensions: "mp4,3gp,mp3,flv,avi,m3u8"}
            ]
        },
        init: {
            'FilesAdded': function(up, files) {
                //do something
                if ($("#ul_pics").children("li").length > 0) {
                    alert("您上传的内容太多了！");
                    uploader.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span></div><div class='percent'>上传中 0%</div></li>";
                    });
                    $("#ul_pics").append(li);
                    uploader.start();
                }
            },
            'BeforeUpload': function(up, file) {
                //do something
            },
            'UploadProgress': function(up, file) {
                //可以在这里控制上传进度的显示
                //可参考七牛的例子
                var percent = file.percent;
                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                $("#" + file.id).find(".percent").text("上传中 "+percent + "%");
            },
            'UploadComplete': function() {
                //do something
            },
            'FileUploaded': function(up, file, info) {
                var str = $.parseJSON(info.response);
                console.log(str);
                console.log(str.key);
                $('#url').val(str.key);
                //每个文件上传成功后,处理相关的事情
                //其中 info 是文件上传成功后，服务端返回的json，形式如
                //{
                //  "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //  "key": "gogopher.jpg"
                //}
//                var domain = up.getOption('domain');
//                var res = eval('(' + info + ')');
//                var sourceLink = domain + res.key;//获取上传文件的链接地址
                //do something
            },
            'Error': function(up, err, errTip) {
                alert(errTip);
            },
            'Key': function(up, file) {
                //当save_key和unique_names设为false时，该方法将被调用
                var key = "";
                $.ajax({
                    url: '/qiniu-token/get-key/',
                    type: 'GET',
                    async: false,//这里应设置为同步的方式
                    success: function(data) {
                        var ext = Qiniu.getFileExtension(file.name);
                        key = data + '.' + ext;
                    },
                    cache: false
                });
                return key;
            }
        }
    });


    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            elem: '#play_time',
            event: 'click', //触发事件
            format: 'YYYY-MM-DD hh:mm:ss', //日期格式
            istime: true, //是否开启时间选择
            isclear: true, //是否显示清空
            istoday: true, //是否显示今天
            issure: true, //是否显示确认
            festival: true,//是否显示节日
            min: '1900-01-01 00:00:00', //最小日期
            max: '2099-12-31 23:59:59', //最大日期
            choose: function(datas){
                $("#play_time").attr("value",datas);
                // end.min = datas; //开始日选好后，重置结束日的最小日期
                // end.start = datas //将结束日的初始值设定为开始日
            }
        };
        // var end = {
        //     elem: '#end_time',
        //     event: 'click', //触发事件
        //     format: 'YYYY-MM-DD hh:mm:ss', //日期格式
        //     istime: true, //是否开启时间选择
        //     isclear: true, //是否显示清空
        //     istoday: true, //是否显示今天
        //     issure: true, //是否显示确认
        //     festival: true,//是否显示节日
        //     min: '1900-01-01 00:00:00', //最小日期
        //     max: '2099-12-31 23:59:59', //最大日期
        //     choose: function(datas){
        //         $("#end_time").attr("value",datas);
        //         start.max = datas; //结束日选好后，重置开始日的最大日期
        //     }
        // };
        document.getElementById('play_time').onclick = function(){
            start.elem = this;
            laydate(start);
        }
        // document.getElementById('end_time').onclick = function(){
        //     end.elem = this
        //     laydate(end);
        // }
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