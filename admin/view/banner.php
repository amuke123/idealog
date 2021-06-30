<div class="main" id="main">
	<div class="content">
		<div class="m_title">轮换图</div>
		<div class="m_content">
			<?php $code=Checking::getAjCode(12);?>
			<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
			<div class="m_list" id="m_list">
				<p><b>序号</b><b>标题</b><b>图片</b><b>打开方式</b><b>状态</b><b>跳转链接</b><b>操作</b></p>
				<?php 
				if(!empty($banners)){foreach($banners as $key=>$value){
					$pic = $value['pic']==""?TEMPLATE_URLA .'static/images/img.gif':$value['pic'];
				?>
					<p class="high <?php echo $value['show']=='0'?'gray':'';?>">
					<span><input type="text" name="num[]" alt="<?php echo $key;?>" value="<?php echo $value['index'];?>" /></span>
					<span class="tleft"><a href="?id=<?php echo $key;?>" title="点击标题编辑" ><?php echo $value['name']==''?'无标题':$value['name'];?></a></span>
					<span><a <?php echo $value['pic']==''?'':'target="_blank" class="listimg"';?> title="<?php echo $value['pic']==''?'无图':'点击图片可查看原图';?>" href="<?php echo $value['pic']==''?'':$pic;?>"><img src="<?php echo $pic;?>" /></a></span>
					<span><?php echo $value['blank']==0?'<img title="当前页" src="'. TEMPLATE_URLA .'static/images/vlog2.gif" />':'<img title="新页面" src="'. TEMPLATE_URLA .'static/images/vlog.gif" />';?></span>
					<span><a href="javascript:showOrHide2('<?php echo $key."','".IDEA_URL."','";echo $value['show']==0?'1':'0';?>','banner_list');"><?php echo $value['show']==0?'<img title="隐藏" src="'. TEMPLATE_URLA .'static/images/plugin_inactive.gif" />':'<img title="显示" src="'. TEMPLATE_URLA .'static/images/plugin_active.gif" />';?></a></span>
					<span><?php echo $value['link'];?></span>
					<span><a href="javascript:delLine2('<?php echo $key."','".IDEA_URL;?>','banner_list');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a></span></p>
				<?php }}?>
			</div>
			<div class="m_button">
				<input type="button" onClick="javascript:change_index2('<?php echo IDEA_URL;?>','banner_list');" class="m_sub" name='tj' value='更改排序' /><input type="button" onClick="javascript:show_add('banner_add');" class="m_but" name='add' value='添加轮换图 +' />
			</div>
		</div>
		<div class="m_add" id="banner_add">
			<form action="" method="post" name="bannadd" onSubmit="return yzBannAdd();" enctype="multipart/form-data" >
				<p><input type="text" class="formin" name="index" placeholder="序号" /></p>
				<p><input type="text" class="formput" name="name" placeholder="名称" /></p>
				<div class="group">
					<p><b>轮换图</b></p>
					<p><input type="file" class="formfile" name="pic" placeholder="分类图片" /></p>
				</div>
				<p><input type="text" class="formput" name="link" placeholder="链接" /></p>
				<p>
					<select name="blank" class="formsele" >
						<option value='0'>当前页打开</option>
						<option value='1'>新页面打开</option>
					</select>
				</p>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='创建轮换图' /></p>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('eye','banner');
}
</script>