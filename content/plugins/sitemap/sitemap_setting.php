<?php
!defined('IDEA_ROOT') && exit('access deined!');
function plugin_setting_view(){
?>
<div class="m_title">good插件设置</div>
<div class="m_contents">
	<form action="?plugin=sitemap" method="post">
		<p><b>请输入数据：</b></p>
		<p><input name="keywords" type="text" class="formput" /></p>
		<p class="m_button"><input type="submit" class="m_sub" name='set' value='提交' /></p>
	</form>
</div>
<?php
}
function plugin_setting(){
	$keywordss = isset($_POST['keywords'])?$_POST['keywords']:'';
	echo "sitemap提交的数据是：".$keywordss;
	
}

?>