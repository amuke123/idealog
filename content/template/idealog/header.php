<?php
/*
Template Name:IDEASHU
Description:IDEASHU模板，简洁优雅
Author:IDEASHU
Author Url:https://www.ideashu.com
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
<script src="<?php echo TEMPLATE_URL;?>js/banner.js" type="text/javascript"></script>
</head>
<body>
<header>
	<div class="content">
		<div class="header">
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
							<input class="h_skey" type="text" name="keywords" placeholder="需要一颗发现美的眼睛..">
							<i class="icno-search"></i>
							<input class="h_sbt" type="submit" value="">
						</form>
					</div>
					<div class="h_user">
						<a href="<?php echo Url::getActionUrl('login');?>">登陆</a><a href="<?php echo Url::getActionUrl('register');?>">快速注册</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</header>