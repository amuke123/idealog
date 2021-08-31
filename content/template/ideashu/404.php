<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>

<html>
<head>
<meta charset="utf-8">
<title>404提示-<?php echo SITE_NAME;?></title>
<meta name="keywords" content="404,网站404,<?php echo SITE_NAME;?>" />
<meta name="description" content="网站404-<?php echo SITE_NAME;?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/404.css">
</head>
<body>
<h1 class="keTitle"></h1>
<div class="demo">
	<p align="center"><span>4</span><span>0</span><span>4</span></p>
	<p align="center">该页面不存在或者您的权限不足 (′?ω?`) ！ </p><br /><br />
	<p align="center">Not Found Or No Access (′?ω?`)  ！ </p><br /><br /><br /><br />
	<p><a href="<?php echo IDEA_URL;?>">返回首页</a> <a href="javascript:history.back(-1);">返回上一页</a></p>
</div>
<div class="keBottom"><a class="keUrl" href="<?php echo IDEA_URL;?>" target="_blank">创意书</a> </div>
</body>
</html>