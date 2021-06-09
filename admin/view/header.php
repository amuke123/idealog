<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>管理中心-创意书</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo TEMPLATE_URLA;?>static/style/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATE_URLA;?>static/style/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATE_URLA;?>static/style/icon.css" rel="stylesheet" type="text/css">
<script src="<?php echo TEMPLATE_URLA;?>static/js/action.js"></script>
<script src="<?php echo TEMPLATE_URLA;?>static/js/ajax.js"></script>
<script src="<?php echo TEMPLATE_URLA;?>static/js/index.js"></script>
<script src="<?php echo ADMIN_URL;?>editor/mukeEditor.js"></script>
</head>
<body>
<div class="side" id="side">
	<p><a href="<?php echo ADMIN_URL;?>"><i class="icon aicon-home"></i>管理中心</a></p>
	<ul>
		<?php
		foreach($navlist as $navkey => $navvalue){
			$ect=explode('|',$navvalue['name']);
			$urlkey=$navkey.".php";
			if(isset($navvalue['child'])){
		?>
		<li><a id='nav_<?php echo $navkey;?>' href="javascript:void(0);" onclick="show(this);"><i class="icon aicon-<?php echo $ect[1];?>"></i><?php echo $ect[0];?><i class="icon2 aicon-fold"></i></a>
			<ul>
			<?php foreach($navvalue['child'] as $k => $v){$ect2=explode('|',$v);$ect3=explode('_',$k);$urlk = $ect3[0]=='more'?'plugin.php?plugin='.$ect3[1]:$k.'.php';?>
				<li><a id='nav_<?php echo $k;?>' href="<?php echo ADMIN_URL .$urlk;?>"><i class="icon aicon-<?php echo $ect2[1];?>"><i></i></i><?php echo $ect2[0];?></a></li>
			<?php }?>
			</ul>
		</li>
		<?php }else{?>
		<li><a id='nav_<?php echo $navkey;?>' href="<?php echo ADMIN_URL .$urlkey;?>"><i class="icon aicon-<?php echo $ect[1];?>"><i></i></i><?php echo $ect[0];?></a></li>
		<?php }
		}?>
	</ul>
</div>

<div class="head" id="head">
	<div class="h_left left">
		<a href="javascript:hide();"><i class="icon aicon-main"></i></a>
		<form action="" name="soso">
			<input type="text" name="keywords" placeholder="功能搜索" />
			<i class="icon-search"></i>
			<input type="submit" value="" />
		</form>
	</div>
	<div class="h_right right">
		<a href="<?php echo IDEA_URL;?>" target="_blank" title="网站主页"><i class="icon aicon-home"></i>&nbsp;</a>
		<a href="<?php echo Url::getActionUrl('setcache');?>" title="更新缓存"><i class="icon aicon-cache"></i>&nbsp;</a>
		<a href="#" title="消息"><i class="icon aicon-infor"></i>&nbsp;</a>
		<div class="h_user"><span><img src="<?php echo TEMPLATE_URLA;?>static/images/avatar.png" /></span><b>用户名</b><i class="icon2 aicon-fold2"></i>
			<div class="h_info">
				<p>
					<a href="#"><i class="icon aicon-user"></i>个人设置</a>
					<a href="#"><i class="icon aicon-info"></i>个人中心</a>
					<a href="#"><i class="icon aicon-write"></i>创作中心</a>
					<a href="#"><i class="icon aicon-set"><i></i></i>网站设置</a>
				</p>
				<p><a href="<?php echo Url::getActionUrl('goout');?>"><i class="icon aicon-out"></i>退出</a></p>
			</div>
		</div>
	</div>
</div>