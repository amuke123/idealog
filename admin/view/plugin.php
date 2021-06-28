<div class="main" id="main">
	<div class="content">
		<div class="m_title">插件</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>开启/禁用</b><b>版本</b><b>描述</b><b></b></p>
					<?php 
					if(!empty($pluginlist)){foreach($pluginlist as $plval){
					?>
					<p>
						<span><a href="?action=setting&plugin=<?php echo $plval['file']?>"><?php echo $plval['name']?> <img src='<?php echo TEMPLATE_URLA . "static/images/set.png";?>' /></a></span>
						<span><a href="#"><img title='开启' src='<?php echo TEMPLATE_URLA . "static/images/plugin_active.gif";?>' /></a></span>
						<span><?php echo $plval['version']?><br/><?php echo $plval['forIdealog']?></span>
						<span class="tleft linesort"><?php echo $plval['des']?> <a href="<?php echo $plval['plugUrl']?>">插件详情</a><br/>作者： <a href="<?php echo $plval['authorUrl']?>"><?php echo $plval['author']?></a> <?php echo $plval['authorEmail']?></span>
						<span> <a href="#">删除</a></span>
					</p>
					<?php }}?>
				</div>
				<div class="m_button">
					<input type="button" onClick="javascript:location.href='<?php echo ADMIN_URL .'plugin.php?action=add';?>';" class="m_but" name='add' value='安装插件 +' />
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow(<?php echo "'".$preopin."','".$nextopin."'";?>);
}
</script>