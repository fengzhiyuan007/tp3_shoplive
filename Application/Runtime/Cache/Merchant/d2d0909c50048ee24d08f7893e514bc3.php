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

<?php $uid = I('goods_uuid'); ?>
<style>
	.ibutton { padding: 3px 15px; *padding: 0 15px; *height: 24px;  font-size: 12px; text-align: center; text-shadow: #CF510B 0 1px 0; border:1px solid #ec5c0d; border-radius: 2px; background: #FC750A; background-image: -webkit-linear-gradient(top, #fc8746, #ec5d0e); color:#FFF; cursor: pointer; display: inline-block; }
	.hide{display: none}
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
	#big{
		position:absolute;
		left:490px;
		top:0px;
		z-index:999;
		display:none;
	}
	.tab{width:75%}
	.layui-layer-btn {
		text-align: center!important;
		padding: 0 10px 12px;
		pointer-events: auto;
	}
	#menu{overflow:hidden; padding-top:10px}
	#menu #nav {display:block;width:100%;padding:0;margin:0;list-style:none;}
	#menu #nav li {float:left;width:10%;}
	#menu #nav li a {display:block;line-height:27px;text-decoration:none;padding:0 0 0 5px; text-align:center; color:#333;}
	#menu_con{ width:100%;padding-top:50px}
	.selected{background:#C5A069;height:30px; color:#fff;}
	.tabs .tbas td{width:18%;border-bottom:1px dashed;line-height:35px}
	.aa td{border-bottom: 1px dotted #000;padding-top:10px;padding-bottom:10px;width:20% }
	table.Height0,div.Height0{height: 0px;overflow: hidden;}
</style>
<div class="page-content">
	<div id="big"></div>
	<div id="big2"></div>
		<form action="" method="post" class="form form-horizontal mt-20" id="form-article-add">
		<div class="col-xs-12" style="display: block;margin-bottom: 15px;">
			<div class="row cl">
				<div class="submit col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-1">
					<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
				
					<button onClick="javascript:history.back(-1);" class="btn btn-default radius" type="button"><i class="Hui-iconfont">&#xe66b;</i> 取消</button>
				</div>
			</div>
			<div id="tab-system" class="HuiTab mt-20">
			<div class="tabBar cl">
				<span class="current sign" data="1">基础属性</span>
				<span class="sign" data="2">商品图片</span>
				<span class="sign" data="3">商品图文</span>
			</div>
			</div>
			
		</div>
		<input	type="hidden" name="goods_id" value="<?php echo ($re["goods_id"]); ?>" />
		<input	type="hidden" name="goods_uuid" value="<?php echo ($re["goods_uuid"]); ?>" />

		<div class="all tag1">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($re["goods_name"]); ?>" placeholder="商品名称" id="goods_name" name="goods_name">
			</div>
		</div>
		<div class="row cl hide">
			<label class="form-label col-xs-4 col-sm-2">品牌名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select name="brand_id" id="brand"  class="select">
					<option value="0">品牌名</option>
					<?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["brand_id"]); ?>" <?php if($re['brand_id'] == $vo['brand_id']): ?>selected<?php endif; ?>><?php echo ($vo['brand_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产品编码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($re["code"]); ?>" placeholder="产品编码" id="code" name="code">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">商户对主播分成比：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="number" type="number" min="0" max="100" step="0.01" class="input-text" value="<?php echo ($re["goods_per"]); ?>" placeholder="" id="goods_per" name="goods_per">&nbsp;&nbsp;%
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产品标签：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span id="goods_tag">
				<?php if(is_array($re['goods_tag'])): foreach($re['goods_tag'] as $key=>$v): ?><input type="text" class="input-text" value="<?php echo ($v); ?>" style="max-width: 100px;" placeholder="产品标签"  name="goods_tag[]"><?php endforeach; endif; ?>
				</span>
				<button onClick="addGoodsTag()" class="btn btn-default radius" type="button">添加</button>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产品信息：</label>
			<div class="formControls col-xs-8 col-sm-9">
			<span id="goods_base">
				<?php if(is_array($re['goods_nature'])): foreach($re['goods_nature'] as $key=>$v): ?><div class="mt-5">
				<label>名称：</label><input type="text" class="input-text" value="<?php echo ($v['name']); ?>" style="max-width: 200px;margin-right: 50px;" placeholder="产品编码"  name="goods_nature_name[]">
				<label>属性：</label><input type="text" class="input-text" value="<?php echo ($v['value']); ?>" style="max-width: 100px;" placeholder="产品编码"  name="goods_nature_value[]">
				</div><?php endforeach; endif; ?>
			</span>
				<button onClick="addGoodsBase()" class="btn btn-default radius mt-5" type="button">添加</button>
			</div>
		</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>一级栏目：</label>
				<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select name="parent_class" id="parent_class" onchange="change_class(this.value)" class="select">
					<option value="">一级分类</option>
					<?php if(is_array($parent_class)): $i = 0; $__LIST__ = $parent_class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['class_id']); ?>" <?php if($re['parent_class'] == $vo['class_id']): ?>selected<?php endif; ?>><?php echo ($vo['class_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</span> </div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
			<select name="seed_class" id="seed_class" class="select">
				<option value="">二级分类</option>
				<?php if($re['seed_class'] != '' ): if(is_array($seed_class)): foreach($seed_class as $key=>$v): ?><option value="<?php echo ($v["class_id"]); ?>" <?php if( $re['seed_class'] == $v['class_id']): ?>selected<?php endif; ?>><?php echo ($v["class_name"]); ?></option><?php endforeach; endif; endif; ?>
			</select>
			</span> </div>
			</div>
		
		<div class="row cl hide">
			<label class="form-label col-xs-4 col-sm-2">价格计算单位：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="unit" class="select">
					<option value="">请选择</option>
					<option value="1" <?php if($re['unit'] == 1): ?>selected<?php endif; ?>>件</option>
					<option value="2" <?php if($re['unit'] == 2): ?>selected<?php endif; ?>>斤</option>
					<option value="3" <?php if($re['unit'] == 3): ?>selected<?php endif; ?>>KG</option>
					<option value="4" <?php if($re['unit'] == 4): ?>selected<?php endif; ?>>吨</option>
					<option value="5" <?php if($re['unit'] == 5): ?>selected<?php endif; ?>>套</option>
				</select>
				</span> </div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产品原价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="goods_origin_price" id="goods_origin_price" placeholder="产品原价" value="<?php echo ($re["goods_origin_price"]); ?>" class="input-text" style="width:90%">
				元</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产品售价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="goods_now_price" id="goods_now_price" placeholder="产品售价" value="<?php echo ($re["goods_now_price"]); ?>" class="input-text" style="width:90%">
				元</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">成本价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="cost_price" id="cost_price" placeholder="成本价格" value="<?php echo ($re["cost_price"]); ?>" class="input-text" style="width:90%">
				元</div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">推广百分比：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="sale_ratio" id="sale_ratio" placeholder="销售百分比" value="<?php echo ($re["sale_ratio"]); ?>" class="input-text" style="width:90%">
				%</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">库存：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="goods_stock" id="goods_stock" placeholder="产品库存" value="<?php echo ($re["goods_stock"]); ?>" class="input-text" style="width:90%">
				</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">产地：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="goods_address" id="goods_address" placeholder="产品产地" value="<?php echo ($re["goods_address"]); ?>" class="input-text" style="width:90%">
				</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否包邮：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="has_postage" id="has_postage" class="select">
					<option value="1" <?php if($re['has_postage'] == 1): ?>selected<?php endif; ?>>包邮</option>
					<option value="2" <?php if($re['has_postage'] == 2): ?>selected<?php endif; ?>>不包邮</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl" style="margin-bottom: 50px;">
			<label class="form-label col-xs-4 col-sm-2">产品简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="goods_desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"><?php echo ($re["goods_desc"]); ?></textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
			</div>
		</div>
		</div>

		<div class="all Height0 tag2">
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">图片：(300*300)</label>
				<div class="formControls col-xs-8 col-sm-9">
					<div class="droparea spot" id="image7" style="background-image: url('<?php echo ($re['goods_img']); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('7')">删除</div>
						<div   id="uparea7"></div>
						<input type="hidden" name="con" id="content" value="" />
						<input type="hidden" name="goods_img" id="image_7" value="<?php echo ($re['goods_img']); ?>" />
					</div>
					&nbsp;<span class="yz img" id="img" style="color:red"></span>
				</div>
			</div>
			<div class="row cl" style="margin-bottom: 50px;">
				<label class="form-label col-xs-4 col-sm-2">轮播：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re['imgs'][0]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('1')">删除</div>
						<div id="uparea1"></div>
						<input type="hidden" name="imgs[]" id="image_1" value="<?php echo ($re['imgs'][0]); ?>" />
					</div>

					<div class="droparea spot" id="image2" style="background-image: url('<?php echo ($re['imgs'][1]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('2')">删除</div>
						<div id="uparea2"></div>
						<input type="hidden" name="imgs[]" id="image_2" value="<?php echo ($re['imgs'][1]); ?>" />
					</div>

					<div class="droparea spot" id="image3" style="background-image: url('<?php echo ($re['imgs'][2]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('3')">删除</div>
						<div id="uparea3"></div>
						<input type="hidden" name="imgs[]" id="image_3" value="<?php echo ($re['imgs'][2]); ?>" />
					</div>

					<div class="droparea spot" id="image4" style="background-image: url('<?php echo ($re['imgs'][3]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('4')">删除</div>
						<div id="uparea4"></div>
						<input type="hidden" name="imgs[]" id="image_4" value="<?php echo ($re['imgs'][3]); ?>" />
					</div>

					<div class="droparea spot" id="image5" style="background-image: url('<?php echo ($re['imgs'][4]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('4')">删除</div>
						<div id="uparea5"></div>
						<input type="hidden" name="imgs[]" id="image_5" value="<?php echo ($re['imgs'][4]); ?>" />
					</div>

					<div class="droparea spot" id="image6" style="background-image: url('<?php echo ($re['imgs'][5]); ?>');background-size: 220px 160px;" >
						<div class="instructions" onclick="del_image('6')">删除</div>
						<div id="uparea6"></div>
						<input type="hidden" name="imgs[]" id="image_6" value="<?php echo ($re['imgs'][5]); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div style="" class="all Height0 tag3">
			<div class="row cl" style="margin-bottom: 50px;">
				<label class="form-label col-xs-4 col-sm-2">图文详情：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<textarea name="goods_detail"  id="content1" style='width:100%;height:300px;'  placeholder="说点什么...最少输入10个字符" ><?php echo ($re['goods_detail']); ?></textarea>
				</div>
			</div>
			
		</div>

			<div class="tabBar cl">
				<span class="current">商品规格</span>
				<div style="float:right;">
					<div class="formControls col-xs-8 col-sm-1" style="min-width: 120px;">
			<span class="select-box radius">
				<select id="specification" class="select">
					<option value="">请选择</option>
					<?php if(is_array($specification)): foreach($specification as $key=>$v): ?><option value="<?php echo ($v["specification_id"]); ?>"><?php echo ($v["specification_value"]); ?></option><?php endforeach; endif; ?>
				</select>
			</span>
					</div>
					<a onClick="addSpecification($('#specification').val())" href="javascript:;;" class="btn btn-default radius" type="button">添加</a>
					
				</div>
			</div>
			<div style="height:500px;">
				<div id="goods_specification">
					<?php if(is_array($goodsSpecificationBeans)): foreach($goodsSpecificationBeans as $key=>$vo): ?><div class="row cl specification" data="<?php echo ($vo["specification_id"]); ?>" code="<?php echo ($key); ?>">
						<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span><?php echo ($vo["specification_value"]); ?>：</label>
						<div class="formControls col-xs-8 col-sm-9" style="float:left">
							<?php if(is_array($vo["specification"])): $k = 0; $__LIST__ = $vo["specification"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><span style="width: 120px;display: inline-block">
								<input type="checkbox" name="" style="margin-right:5px;" class="specification_son" onclick="checkSpecificationSon($(this))" <?php if(in_array($v['specification_id'],$arr)): ?>checked<?php endif; ?> value="<?php echo ($v["specification_id"]); ?>">
							<span><?php echo ($v["specification_value"]); ?></span>
						</span><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div><?php endforeach; endif; ?>
				</div>
				<div class="cl pd-30 bg-1 bk-gray mt-20">
					<table class="table table-border table-bordered table-bg table-hover table-sort">
						<thead>
						<tr class="text-c">
							<th width="80">规格组合ID</th>
							<th width="120">规格组合名称</th>
							<!--<th width="70">编码</th>-->
							<th width="80">售价</th>
							<th width="80">原价</th>
							<th width="80">成本价</th>
							<!--<th width="80">销售百分比</th>-->
							<th width="80">库存</th>
							<th width="150">图片</th>
						</tr>
						</thead>
						<tbody id="goods_specification_detail">
						<?php if(is_array($goods_specification_relation)): $i = 0; $__LIST__ = $goods_specification_relation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c tr_specification">
							<td><?php echo ($vo["specification_ids"]); ?><input type="hidden"  name="specification_ids[]"  placeholder="规格组合ids" value="<?php echo ($vo["specification_ids"]); ?>" class="input-text" style="width:90%"></td>
							<td><?php echo ($vo["specification_names"]); ?><input type="hidden" name="specification_names[]"  placeholder="规格组合名称" value="<?php echo ($vo["specification_names"]); ?>" class="input-text" style="width:90%"></td>
							<td><input type="text" name="specification_sale_price[]" onblur="checkPrice($(this))" placeholder="规格售价" value="<?php echo ($vo["specification_sale_price"]); ?>" class="input-text tc" style="width:90%"></td>
							<td><input type="text" name="specification_price[]"  onblur="checkPrice($(this))"  placeholder="规格原价" value="<?php echo ($vo["specification_price"]); ?>" class="input-text tc" style="width:90%"></td>
							<td><input type="text" name="specification_cost_price[]"  onblur="checkPrice($(this))"  placeholder="规格成本价" value="<?php echo ($vo["specification_cost_price"]); ?>" class="input-text tc" style="width:90%"></td>
							
							<td><input type="text" name="specification_stock[]" onblur="checkStock($(this))"   placeholder="规格库存" value="<?php echo ($vo["specification_stock"]); ?>" class="input-text tc" style="width:90%"></td>
							<td>
							
								<div style="position:relative;width:50px; height:50px; border-radius:25px;margin: 0 auto">
									<input style="position: absolute;width: 100%;height: 100%;opacity: 0;top:0;left:0" accept="image/*" onchange="upload_img($(this))" type="file" >
									<img src="<?php echo ((isset($vo["specification_img"]) && ($vo["specification_img"] !== ""))?($vo["specification_img"]):'/Public/uploads/image/add.jpeg'); ?>" style="width:50px; height:50px;" >
								</div>
								<input name="specification_img[]" type="hidden"  value="<?php echo ($vo["specification_img"]); ?>" />
								<input name="specification_id[]" type="hidden"  value="<?php echo ($vo["specification_id"]); ?>" />
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
	</form>
</div>
<!-- <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script> -->
<script type="text/javascript">
    Array.prototype.indexOf = function(val) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == val) return i;
        }
        return -1;
    };
    Array.prototype.removeOf = function(val) {
        var index = this.indexOf(val);
        if (index > -1) {
            this.splice(index, 1);
        }
    };
		var content;
		KindEditor.ready(function (K) {
			content = K.create('#content', {
				allowFileManager: true,
				uploadJson: "<?php echo U('Common/upload');?>"
			});
		});

		KindEditor.ready(function (K) {
			K.create();
			var editor = K.editor({
				allowFileManager: true,
				uploadJson: "<?php echo U('Common/upload');?>"
				//sdl:false
			});

			K('#uparea1').click(function() {
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

			K('#uparea2').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_2').val(),
						clickFn : function(url, title, width, height, border, align) {
							$('#image2').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_2').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

			K('#uparea3').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_3').val(),
						clickFn : function(url, title, width, height, border, align) {
							$('#image3').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_3').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

			K('#uparea4').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_4').val(),
						clickFn : function(url, title, width, height, border, align) {
							$('#image4').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_4').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

			K('#uparea5').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_5').val(),
						clickFn : function(url, title, width, height, border, align) {
							$('#image5').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_5').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

			K('#uparea6').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_6').val(),
						clickFn : function(url, title, width, height, border, align) {
							$('#image6').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_6').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});
            K('#uparea7').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#image_7').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            $('#image7').css('background-image','url('+url+')').css('background-size','220px 160px');
                            K('#image_7').val(url);
                            // K('#getImgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });
		});

		$(".sign").click(function(){
			var data = $(this).attr('data');
			if(data == '4'){
				var id = "<?php echo ($_GET['id']); ?>";
				if(id < 1){
					popup.error("请先保存商品");
					setTimeout(function(){
						popup.close("asyncbox_error");
					},2000);
					return false;
				}
			}
			if(data == '3'){
    			UE.getEditor('content1');

            }else{
            	UE.delEditor('content1');
            }
			$(this).siblings().removeClass('current');
			$(this).addClass('current');
			$('.all').addClass("Height0");
			$('.all').removeClass('hide');
			$('.tag'+data).removeClass("Height0");
		});

		// $(".submit").click(function(){
		// 	commonAjaxSubmit('','form');
		// 	return false;
		// });

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

		$("#uparea3").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_3').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_3').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea3").mouseout(function(){
			$("#big").hide();
		});
		$("#uparea4").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_4').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_4').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea4").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea5").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			// var img = $('#image_5').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_5').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea5").mouseout(function(){
			$("#big").hide();
		});

		$("#uparea6").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_6').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_6').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea6").mouseout(function(){
			$("#big").hide();
		});
        $("#uparea7").mouseover(function(e){
            $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
            var img = $('#image_7').val();
            if(img.length !== 0) {
                $("#big").html('<img src="' + $('#image_7').val() + '" width=380 height=300>');
                $("#big").show();        //show：显示
            }
        });
        $("#uparea7").mouseout(function(){
            $("#big").hide();
        });

	function addGoodsTag(){
		var length = $('#goods_tag > input').length;
		if(length >5){
            layer.msg('最多只能添加6个标签',{icon:5,time:1000});
		}else{
		    if(length>0){
                $('#goods_tag').append('<input type="text" class="input-text" value="" style="max-width: 100px;margin-left:10px;" placeholder="产品标签"  name="goods_tag[]">')
			}else{
                $('#goods_tag').append('<input type="text" class="input-text" value="" style="max-width: 100px;" placeholder="产品标签"  name="goods_tag[]">')
			}
		}
	}

    function addGoodsBase(){
        var length = $('#goods_base > div').length;
        if(length >5){
            layer.msg('最多只能添加6个标签',{icon:5,time:1000});
        }else{
			$('#goods_base').append('<div class="mt-5">' +
				'<label>名称：</label><input type="text" class="input-text" value="" style="max-width: 200px;margin-right: 50px;" placeholder="名称"  name="goods_nature_name[]">'+
				'<label>属性：</label><input type="text" class="input-text" value="" style="max-width: 100px;" placeholder="产品属性"  name="goods_nature_value[]">'+
				'</div>')
        }
    }

    function addSpecification(v){
        if(v !='' || v !=undefined || v != 0) {
            var gids = new Array();
            var code = 0;
            $.each($(".specification"), function (i, n) {
                code ++;
                gids.push($(n).attr('data'));
            });
            if ($.inArray(v, gids) != -1) {
                layer.msg("已存在该型号", {icon: 5, time: 1000});
            } else {
                $.post("<?php echo U('querySpecification');?>",{id:v},function(data){
                    if(data.status =='error'){
                        layer.msg('该规格暂无数据，请自行添加或更换另一个', {icon: 5, time: 1000});
                        return false;
                    }else {
                        var html = '';
						for(var i =0;i<data.data.list.length;i++){
							html +=	'<span style="width: 120px;display: inline-block"><input onclick="checkSpecificationSon($(this))" type="checkbox" class="specification_son" value='+data.data.list[i].specification_id+' style="margin-right:5px;">'+ '<span>'+data.data.list[i].specification_value+'</span></span>';
						}
                        $('#goods_specification').append(
                            '<div class="row cl specification" data=' + v + ' code='+code+'>' +
                            '<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>'+data.data.value+'：</label>' +
                            '<div class="formControls col-xs-8 col-sm-9" style="float:left">'+html+
                            '</div>' +
                           '</div>'
						);
                    }
                },'json')
            }
        }
	}

	function eachObject(a,b){
        for(var i = 0;i<b.length;i++){
            console.log(b[i]);
			console.log(a);
			break;
            if(b[i] == a){
                return i;
			}
		}
        return -1;
	}

	function unsetempty(array){
        for(var i = 0 ;i<array.length;i++)
        {
            if(array[i] == "" || typeof(array[i]) == "undefined")
            {
                array.splice(i,1);
                i= i-1;

            }

        }
        return array;
	}

    var total_arr = [];   //总数组
    var temp_arr = [];    //临时拼凑数组
    var total_arr_index = ''; //总数组下标计数
    var total_count = ''; //输入的数组长度

	function getArrSet(arrs,current_index){
        if(current_index === ''|| current_index == undefined){
            current_index = -1;
		}else{
            current_index = current_index;
		}

        if(current_index<0) {
			  total_arr_index=0;
			  total_count = arrs.length-1;
			  getArrSet(arrs,0);
         }else{
            //循环第current_index层数组
            for(var i =0;i<arrs[current_index].length;i++){
                //如果当前的循环的数组少于输入数组长度
                if(current_index<total_count) {
                    //将当前数组循环出的值放入临时数组
                    temp_arr[current_index]= JSON.parse(arrs[current_index][i]);
                    //继续循环下一个数组
                    getArrSet(arrs,current_index+1);
				}
                //如果当前的循环的数组等于输入数组长度(这个数组就是最后的数组)
				else if(current_index==total_count){
                    //将当前数组循环出的值放入临时数组

                    temp_arr[current_index]= JSON.parse(arrs[current_index][i]);
                    //将临时数组加入总数组
                    total_arr[total_arr_index] = JSON.stringify(temp_arr);
                    //总数组下标计数+1
                    total_arr_index++;
				}
			}
		}
        return total_arr;
	}

    arr1 = new Array();
	$.each($('.specification'),function(i,n){
		var data = $(n).attr('code');
        if(arr1[data] == undefined){
            arr1[data] = [];
        }
		$.each($(n).children().find('input[class="specification_son"]:checked'), function (j, k) {
			var name = $(k).val();
			var value = $(k).next('span').html();
			var object = new Object();
			object.name = name;
			object.value = value;
			var str = JSON.stringify(object);
			if($.inArray(str, arr1[data]) == -1){
				arr1[data].push(str);
			}else{

			}
      });
    });

	arr3 = new Array();   //编辑时原有的规格
    $.each($('.tr_specification'),function(i,n){
		var specification_id = $(n).children().find('input[name="specification_id[]"]').val();
		var specification_ids = $(n).children().find('input[name="specification_ids[]"]').val();
		var specification_names = $(n).children().find('input[name="specification_names[]"]').val();
		var specification_sale_price = $(n).children().find('input[name="specification_sale_price[]"]').val();
		var specification_price = $(n).children().find('input[name="specification_price[]"]').val();
		var specification_cost_price = $(n).children().find('input[name="specification_cost_price[]"]').val();
		//var sale_ratio = $(n).children().find('input[name="specification_sale_ratio[]"]').val();
		var specification_stock = $(n).children().find('input[name="specification_stock[]"]').val();
		var specification_img = $(n).children().find('input[name="specification_img[]"]').val();
		var object = new Object();
        object.specification_id = specification_id;
        object.specification_ids = specification_ids;
        object.specification_names = specification_names;
        object.specification_sale_price = specification_sale_price;
        object.specification_price = specification_price;
        object.specification_cost_price = specification_cost_price;
//        object.sale_ratio = sale_ratio;
        object.specification_stock = specification_stock;
        object.specification_img = specification_img;
        var str = JSON.stringify(object);
        arr3.push(str);
	});
    console.log(arr3);



    //arr  = new Array();

	function checkSpecificationSon(v){
        var arr  = new Array();
        var isChecked = $(v).is(":checked");
        var specification = $(v).parents('.specification');
			//console.log(arr);
		var tag = 0;
        $.each($('.specification'),function(a,b){
            if(arr[tag] == undefined){
                arr[tag] = [];
            }
			$.each($(b).children().find('input[class="specification_son"]:checked'), function (i, n) {
				var name = $(n).val();
				var value = $(n).next('span').html();
				var object = new Object();
				object.name = name;
				object.value = value;
				var str = JSON.stringify(object);
				if($.inArray(str, arr[tag]) == -1){
					arr[tag].push(str);
				}else{

				}
			});
            if(arr[tag].length<1){
                console.log(tag);
                arr.splice(tag,1);
                tag--;
			}
			console.log(arr)
			tag++;
        });

        total_arr = [];   //总数组
        temp_arr = [];    //临时拼凑数组
        $("#goods_specification_detail").empty();
        var newArr = getArrSet(arr);
        console.log(newArr);
        var arr4 = new Array();
        arr4 = arr3;   //原有的规格赋予新数组
        arr5 = new Array();   //组合后的规格
		if(arr4.length>0){
            outer:
			for(var i =0;i<newArr.length;i++){
                inter:
                var new_str = JSON.parse(newArr[i]);
                var str1 = [];
                var str2 = [];
                for (var k = 0; k < new_str.length; k++) {
                    str1[k] = new_str[k].name;
                    str2[k] = new_str[k].value;
                }

                for(var j = 0; j < arr4.length; j++){
                    var str = JSON.parse(arr4[j]);
                    var object = new Object();
                    if (str.specification_ids == str1.join(',')) {
                        object.specification_id = str.specification_id;
                        object.specification_ids = str.specification_ids;
                        object.specification_names = str.specification_names;
                        object.specification_sale_price = str.specification_sale_price;
                        object.specification_price = str.specification_price;
                        object.specification_cost_price = str.specification_cost_price;
                        //object.sale_ratio = str.sale_ratio;
                        object.specification_stock = str.specification_stock;
                        object.specification_img = str.specification_img;
                        if(str.specification_img == '' || str.specification_img == undefined ){
                            object.specification_img1 = '/Public/uploads/image/add.jpeg';
						}else{
                            object.specification_img1 = str.specification_img;
						}

                        var str3 = JSON.stringify(object);
                        if($.inArray(str3,arr5) == -1){
                            arr5.push(str3);
						}
                        continue outer;
                    }
				}
                var object = new Object();
                object.specification_ids = str1;
                object.specification_id = '';
                object.specification_names = str2;
                object.specification_sale_price = 0;
                object.specification_price = 0;
                object.specification_cost_price = 0;
                //object.sale_ratio = 0;
                object.specification_stock = 0;
                object.specification_img = '';
                object.specification_img1 = '/Public/uploads/image/add.jpeg';
                var str3 = JSON.stringify(object);
                if($.inArray(str3,arr5) == -1){
                    arr5.push(str3);
                }

			}
		}else {
            if (arr.length > 0) {
                for (var i = 0; i < newArr.length; i++) {
                    var str = JSON.parse(newArr[i]);
                    var str1 = [];
                    var str2 = [];
                    //console.log(str);
                    for (var j = 0; j < str.length; j++) {
                        str1[j] = str[j].name;
                        str2[j] = str[j].value;
                    }

                    var object = new Object();
                    object.specification_id = 0;
                    object.specification_ids = str1;
                    object.specification_names = str2;
                    object.specification_sale_price = 0;
                    object.specification_price = 0;
                    object.specification_cost_price = 0;
                    object.specification_stock = 0;
                    //object.sale_ratio = 0;
                    object.specification_img = '';
                    object.specification_img1 = '/Public/uploads/image/add.jpeg';
                    var str = JSON.stringify(object);
                    arr5.push(str);

                }
            }
        }
        for(var i=0;i<arr5.length;i++){
            var str = i + 1;
            var str1 = JSON.parse(arr5[i]);
            $("#goods_specification_detail").append(
                '<tr class="text-c tr_specification">' +
                '<td>' + str1.specification_ids + '<input type="hidden" name="specification_ids[]"  placeholder="规格ids组合" value=' + str1.specification_ids + ' class="input-text tc" style="width:90%"></td>' +
                '<td>' + str1.specification_names + '<input type="hidden" name="specification_names[]"  placeholder="规格名称组合" value=' + str1.specification_names + ' class="input-text tc" style="width:90%"></td>' +
                '<td><input type="text" name="specification_sale_price[]"  placeholder="规格售价" value='+str1.specification_sale_price+' class="input-text tc" style="width:90%"></td>' +
                '<td><input type="text" name="specification_price[]"  placeholder="规格原价" value='+str1.specification_price+' class="input-text tc" style="width:90%"></td>' +
                '<td><input type="text" name="specification_price[]"  placeholder="规格原价" value='+str1.specification_price+' class="input-text tc" style="width:90%"></td>' +
//                '<td><input type="text" name="specification_sale_ratio[]"  placeholder="销售比例" value='+str1.sale_ratio+' class="input-text tc" style="width:90%"></td>' +
                '<td><input type="text" name="specification_stock[]"  placeholder="规格库存" value='+str1.specification_stock+' class="input-text tc" style="width:90%"></td>' +
                '<td>' +
                 '<div style="position:relative;width:50px; height:50px; border-radius:25px;margin: 0 auto">'+
                 '<input style="position: absolute;width: 100%;height: 100%;opacity: 0;top:0;left:0" accept="image/*" onchange="upload_img($(this))" type="file" >'+
                 '<img src='+str1.specification_img1+' style="width:50px; height:50px;" >'+
                '</div>'+
                 '<input name="specification_img[]" type="hidden"  value='+str1.specification_img+' />'+
                 '<input name="specification_id[]" type="hidden"  value='+str1.specification_id+' />'+
                '</td>' +
                '</tr>'
          );
		}
	}

    		function upload_img(v){
    			var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    			var formData = new FormData();
    			formData.append("img", $(v)[0].files[0]);
    			$.ajax({
    				url: "<?php echo U('Common/upload');?>" ,
    				type: 'POST',
    				data: formData,
    				async: true,
    				cache: false,
    				contentType: false,
    				processData: false,
    				dataType:"JSON",
    				success: function (data) {
    				    console.log(data);
    					layer.close(index);
    					if(data['error'] == 0){
                            layer.msg('上传成功',{icon:1,time:1000});
    						$(v).parent('div').next('input[name="specification_img[]"]').val(data['url']);
    						$(v).next('img').prop('src',data['url']);
    					}else{
                            layer.msg('上传失败',{icon:2,time:1000});
    					}
    				},
    				error: function (data) {
    					console.log(data);
    				}
    			});
    		};



	function add_kinds(id,v,e){
		var url = "<?php echo U('Goods/edit_kinds');?>";
		if(id != null || id != undefined || id != ' ' || id != '0') {
			$.ajax({
				type: "GET",
				url: url,
				dataType: 'json',
				data: {id: id},
				success: function (data) {
					console.log(data);
					if (data['status'] == 'ok') {
						if(data.data != null){
							$("#kinds_detail").val(data.data.kinds_detail);
						}
					}
				}
			})
		}
		var html='<table class="table table-striped table-hover">' +
				'<tr>' +
				'<td style="vertical-align: middle;">型号名称</td>' +
				'<td><input type="text" name="kinds_detail" value="" id="kinds_detail" style="width:320px;" placeholder="型号名称" />' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">原价</td>' +
				'<td><input type="text" name="price"  id="price" style="width:320px;" value="0" readonly placeholder="商品售价"/>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">售价</td>' +
				'<td><input type="text" name="sale_price"  id="sale_price" style="width:320px;" value="0" readonly placeholder="商品售价"/>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<tr>' +
				'<td></td>' +
				'<td>' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'</table>'
		layer.open({
			type: 1,
			title: '商品型号',
			closeBtn: 0,
			area: ['500px','240px'],
			skin: '', //没有背景色
			shadeClose: true,
			content: html,
			btn:['保存'],
			yes:function(){
				var kinds_detail = $("#kinds_detail").val();
				var sale_price = $("#sale_price").val();
				var price = $("#price").val();
				var kinds1 = $('#param1').val();
				var kinds2 = $('#param2').val();
				$.ajax({
					url:urlrl,
					type:'post',
					data:{id:id,goods_id:v,kinds_detail:kinds_detail,price:price,sale_price:sale_price,kinds1:kinds1,kinds2:kinds2,type:e},
					dataType:'json',
					success:function(data){
						if(data.status=='ok'){
							alert(data['info']);
							window.location.href = window.location.href
						}else{
							alert(data.info);
						}
					}
				})
			}
		});

	};

	function del_kinds(id,v,e){
		var url = "<?php echo U('Goods/del_kinds');?>";
		if(id != null || id != undefined || id != ' ' || id != '0') {
			$.ajax({
				type: "GET",
				url: url,
				dataType: 'json',
				data: {id: id},
				success: function (data) {
					console.log(data);
					if (data['status'] == 'ok') {
						window.location.href = window.location.href;
					}else{
						alert(data.info);
					}
				}
			})
		}

	};

	function del_stock(id,v){
		var url = "<?php echo U('Goods/del_goods_stock');?>";
		if(!confirm('确定要删除该记录？'))
			return false;
		$.post(url, {id:id}, function(data){
			if( data['status'] == 'ok' ){
				alert(data.info);
				window.location.href = window.location.href;
			}else{
				alert(data.info);
			}
		},'json');
		return false;

	};

	function add_stock(id,v){
		var url = "<?php echo U('Goods/edit_goods_stock');?>";
		if(id != null || id != undefined || id != ' ' || id != '0') {
			$.ajax({
				type: "GET",
				url: url,
				dataType: 'json',
				data: {id: id},
				success: function (data) {
					console.log(data);
					if (data['status'] == 'ok') {
						if(data.data != null){
							console.log(data);
							$('#kinds_one'+data.data.kinds1).attr("selected",true);
							$('#kinds_twe'+data.data.kinds2).attr("selected",true);
							$("#kinds_number").val(data.data.number);
							$("#kinds_sale_number").val(data.data.sale_number);
							$("#template_id2").val(data.data.template_id);
						}
					}
				}
			})
		}
		var html='<table class="table table-striped table-hover">' +
				'<tr>' +
				'<td style="vertical-align: middle;">型号一</td>' +
				'<td><select name="kinds_id1" value="" id="kinds_id1" style="width:320px;">' +
				'<option value="">请选择型号</option>' +
				'<?php if(is_array($kinds_detail)): $i = 0; $__LIST__ = $kinds_detail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>' +
				'<option value="<?php echo ($vo["kind_id"]); ?>" id="kinds_one<?php echo ($vo["kind_id"]); ?>" ><?php echo ($vo["kinds_detail"]); ?></option>' +
				'<?php endforeach; endif; else: echo "" ;endif; ?>' +
				'</select>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">型号二</td>' +
				'<td><select  name="kinds_id2" value="" id="kinds_id2" style="width:320px;">' +
				'<option value="">请选择型号</option>' +
				'<?php if(is_array($kinds_detail2)): $i = 0; $__LIST__ = $kinds_detail2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>' +
				'<option value="<?php echo ($vo["kind_id"]); ?>" id="kinds_twe<?php echo ($vo["kind_id"]); ?>" ><?php echo ($vo["kinds_detail"]); ?></option>' +
				'<?php endforeach; endif; else: echo "" ;endif; ?>' +
				'</select>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">库存量</td>' +
				'<td><input type="text" name="kinds_number" value="" id="kinds_number" style="width:320px;" placeholder="商品库存"/>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">已售数量</td>' +
				'<td><input type="text" name="kinds_sale_number" value="" id="kinds_sale_number" style="width:320px;" placeholder="商品出售量"/>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<td style="vertical-align: middle;">型号模板</td>' +
				'<td><input type="text" name="template_id" value="" id="template_id2" style="width:320px;" placeholder="商品型号模板"/>' +
				'<span class="red important"> * </span> ' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'<tr>' +
				'<tr>' +
				'<td></td>' +
				'<td>' +
				'</td>' +
				'<td></td> ' +
				'</tr>' +
				'</table>'
		layer.open({
			type: 1,
			title: '库存设置',
			closeBtn: 0,
			area: ['500px','330px'],
			skin: '', //没有背景色
			shadeClose: true,
			content: html,
			btn:['保存'],
			yes:function(){
				var kinds_id1 = $('#kinds_id1').val();
				var kinds_id2 = $('#kinds_id2').val();
				var number = $('#kinds_number').val();
				var sale_number = $('#kinds_sale_number').val();
				var template_id = $('#template_id2').val();
				$.ajax({
					url:urlrl,
					type:'post',
					data:{id:id,goods_id:v,kinds_id1:kinds_id1,kinds_id2:kinds_id2,
						number:number,sale_number:sale_number,template_id:template_id},
					dataType:'json',
					success:function(data){
						console.log(data);
						if(data.status=='ok'){
							alert(data['info']);
							window.location.href = window.location.href
						}else{
							alert(data.info);
						}
					}
				})
			}
		});

	};

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

	function change_status(id,v){
		var id = id;
		$.post("<?php echo U('Tailor/change_tailor_status');?>",{id:id},function(data){
			if(data['status'] == 'ok'){
				$(v).html(data['info']);
			}else{
				alert(data['info']);
			}
		},'json');
		return false;
	}

	function del_tailor(id,v){
		var url = "<?php echo U('Tailor/del_tailor');?>";
		if(!confirm('确定要删除该记录？'))
			return false;
		$.post(url, {id:id}, function(data){
			if( data['status'] == 'ok' ){
				alert(data.info);
				window.location.href = window.location.href;
			}else{
				alert(data.info);
			}
		},'json');
		return false;

	};

	function start_time(){
		$("#start_time").datetimepicker({
			format: 'yyyy-mm-dd  hh:ii',
			autoclose: true,
			todayBtn: true,
			language: 'zh-CN',
			pickerPosition: "bottom-left"
		}).on('changeDate', function(ev) {
			console.log(1);
			$("#end_time").datetimepicker('setStartDate', $(this).val());
		});
	}

	function end_time(){
		$("#end_time").datetimepicker({
			format: 'yyyy-mm-dd  hh:ii',
			autoclose: true,
			todayBtn: true,
			language: 'zh-CN',
			pickerPosition: "bottom-left"
		});
	}

	function checkPrice(v){
	    var n = $(v).val();
	    if(isNaN(n) || n<0){
            layer.msg('需填写不小于0的数字',{icon:5,time:1000});
            $(v).focus();
		}
	}
    function checkRatio(v){
        var n = $(v).val();
        if(isNaN(n) || n<0 || n>100){
            layer.msg('需填写不小于0且不大于100的数字',{icon:5,time:1000});
            $(v).focus();
        }
    }
    function checkStock(v){
        var n = $(v).val();
        if(Number(n)<0 || isNaN(n) || parseInt(n)!=parseFloat(n)){
            layer.msg('需填写不小于0的整数',{icon:5,time:1000});
            $(v).focus();
        }
    }

</script>
<script>
	// UE.getEditor('content1');
//	UE.getEditor('content2');
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