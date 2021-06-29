<div class="main" id="main">
	<div class="content">
		<?php if($plugin==''){?>
		<div class="m_title">插件管理</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>开启/关闭</b><b>版本</b><b>描述</b><b></b></p>
					<?php 
					if(!empty($pluginlist)){foreach($pluginlist as $plval){
					?>
					<p>
						<span>
						<?php if($plval['setting']){?>
							<a href="?plugin=<?php echo $plval['file'];?>"><?php echo $plval['name']?> <img src='<?php echo TEMPLATE_URLA . "static/images/set.png";?>' /></a>
						<?php }else{echo $plval['name'];}?>
						</span>
						<span><a href="javascript:pluginopin(<?php echo in_array($plval['file'],$plugins)?"'".IDEA_URL ."','{$plval['file']}','0'":"'".IDEA_URL ."','{$plval['file']}','1'";?>);"><img title='<?php echo in_array($plval['file'],$plugins)?"已开启":"已关闭";?>' src='<?php echo TEMPLATE_URLA . "static/images/";echo in_array($plval['file'],$plugins)?"plugin_active.gif":"plugin_inactive.gif";?>' /></a></span>
						<span><?php echo $plval['version']?><br/><?php echo $plval['forIdealog']?></span>
						<span class="tleft linesort"><?php echo $plval['des']?> <a target="_blank" href="<?php echo $plval['plugUrl']!=''?$plval['plugUrl']:'#';?>">插件详情</a><br/>作者： <a target="_blank" href="<?php echo $plval['authorUrl']?>"><?php echo $plval['author']?></a> <?php echo $plval['authorEmail']?></span>
						<span> <a href="javascript:plugindel(<?php echo "'".IDEA_URL ."','{$plval['file']}'";?>);">删除</a></span>
					</p>
					<?php }}?>
				</div>
				<div class="m_button">
					<input type="button" onClick="javascript:show_add('plug_add');" class="m_but" name='add' value='安装插件 +' />
				</div>
			</form>
		</div>
		<div class="clear"></div>
		<div class="m_add" id="plug_add">
			<form action="" method="post" name="plugadd" enctype="multipart/form-data" >
				<div class="group">
					<p><b>上传一个zip压缩格式的插件安装包</b></p>
					<p><input type="file" class="formfile" required name="pluzip" /></p>
				</div>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='上传安装' /></p>
				<p>获取更多插件：<a href="<?php echo ADMIN_URL;?>store.php">应用中心 >></a></p>
			</form>
		</div>
		<?php }else{$mathe();}?>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow(<?php echo "'".$preopin."','".$nextopin."'";?>);
}
</script>