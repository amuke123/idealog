<div class="main" id="main">
	<div class="content">
		<div class="m_title">轮换图</div>
		<div class="m_add2">
			<form action="" method="post" name="bannadd" onSubmit="return yzBannAdd2();" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $bannid?>" />
				<input type="hidden" name="show" value="<?php echo $banners[$bannid]['show']?>" />
				<p><input type="text" class="formin" name="index" value="<?php echo $banners[$bannid]['index']?>" placeholder="序号" /></p>
				<p><input type="text" class="formput" name="name" value="<?php echo $banners[$bannid]['name']?>" placeholder="名称" /></p>
				<div class="group">
					<p><b>轮换图</b><img <?php echo $banners[$bannid]['pic']==""?'src="'.TEMPLATE_URLA .'static/images/img.gif" title="无图"':'src="'.str_replace('../',IDEA_URL,$banners[$bannid]['pic']).'"';?> /><input type="hidden" name="pic2" value="<?php echo $banners[$bannid]['pic']?>" /></p>
					<p><input type="file" class="formfile" name="pic" /></p>
				</div>
				<p><input type="text" class="formput" name="link" value="<?php echo $banners[$bannid]['link']?>" placeholder="链接" /></p>
				<p>
					<select name="blank" class="formsele" >
						<option value='0' <?php echo $banners[$bannid]['blank']=='0'?'selected':'';?>>当前页打开</option>
						<option value='1' <?php echo $banners[$bannid]['blank']=='1'?'selected':'';?>>新页面打开</option>
					</select>
				</p>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='保存' /><input type="button" onclick="javascript:window.history.back();" class="m_but2" value='取消' /></p>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('bookmark','banner');
}
</script>