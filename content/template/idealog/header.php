<?php
/*
Template Name:IDEASHU
Description:IDEASHU模板，简洁优雅
Author:IDEASHU
Author Url:https://www.ideashu.cn
*/

if(!defined('IDEA_ROOT')){exit('error!');}
require_once View::getView('function');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $site_title;?></title>
<meta name="keywords" content="<?php echo $seo_key;?>" />
<meta name="description" content="<?php echo $seo_description;?>" />
<meta name="generator" content="amuker" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $header_meta;?>
<link href="<?php echo TEMPLATE_URL;?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo TEMPLATE_URL;?>js/index.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL;?>js/action.js" type="text/javascript"></script>
<script src="<?php echo IDEA_URL . ADMIN_TYPE;?>/view/static/js/ajax.js" type="text/javascript"></script>
<script src="<?php echo IDEA_URL . ADMIN_TYPE;?>/view/static/js/index.js" type="text/javascript"></script>
</head>
<body>
<header>
	<div class="content">
		<div class="header" id="h_top">
			<div class="center">
				<div class="left">
					<div class="h_logo"><a href="<?php echo IDEA_URL;?>"><img src="<?php echo TEMPLATE_URL;?>images/logo.png"><b>创意书</b></a></div>
					<div class="h_nav">
						<ul>
							<?php site_nav();?>
						</ul>
					</div>
				</div>
				<div class="right">
					<div class="h_search">
						<form action="<?php echo IDEA_URL;?>">
							<input class="h_skey" type="text" name="keywords" placeholder="输入需要查询的内容..">
							<i class="icno-search"></i>
							<input class="h_sbt" type="submit" value="">
						</form>
					</div>
					<?php if(UID==0){?>
					<div class="h_user">
						<a href="<?php echo Url::getActionUrl('login');?>">登陆</a><a href="<?php echo Url::getActionUrl('register');?>">快速注册</a>
					</div>
					<?php
					}else{
						$userData=user_Model::getInfo(UID);
						$avatar = empty($userData['avatar']) ? IDEA_URL . ADMIN_TYPE .'/view/static/images/avatar.jpg' : '../' . $userData['avatar'];
						$name = $userData['name'];
					?>
					<div class="h_login">
						<ul>
							<li class="h_login_zx"><b><img src="<?php echo $avatar;?>" title="<?php echo $name;?>" /></b>
							<p><a href="<?php echo Url::setting(UID);?>">设置</a><a href="<?php echo Url::person(UID);?>">个人中心</a><?php if(ROLE==ROLE_ADMIN){?><a  target="_blank" href="<?php echo IDEA_URL .ADMIN_TYPE; ?>">后台管理</a><?php }?><a href="<?php echo Url::getActionUrl('goout');?>">退出</a><p>
							</li>
						</ul>
					</div>
					<?php }?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</header>