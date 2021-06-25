<div class="main" id="main">
	<div class="content">
		<div class="m_title">编辑分类</div>
		<div class="m_add2">
			<form action="" method="post" name="sortadd" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $sorts[$sortid]['id'];?>" />
				<p><input type="text" class="formin" name="index" value="<?php echo $sorts[$sortid]['index'];?>" placeholder="序号" /></p>
				<p><input type="text" class="formput" name="name" value="<?php echo $sorts[$sortid]['sortname'];?>" required placeholder="名称" /></p>
				<p><input type="text" class="formput" name="alias" value="<?php echo $sorts[$sortid]['alias'];?>" required placeholder="别名" /></p>
				<p><input type="text" class="formput" name="template" value="<?php echo $sorts[$sortid]['template'];?>" placeholder="模板" /></p>
				
				<p>
					<select name="top_id" class="formsele" >
						<option value='0'>无上级分类</option>
						<?php echo sort_Model::getTopSorts($sorts,$sorts[$sortid]['top_id'],$sortid);?>
					</select>
				</p>
				<div class="group">
					<p><b>分类图片</b><img <?php echo $sorts[$sortid]['pic']==""?'src="'.TEMPLATE_URLA .'static/images/img.gif" title="无图"':'src="'.str_replace('../',IDEA_URL,$sorts[$sortid]['pic']).'"';?> /><input type="hidden" name="pic2" value="<?php echo $sorts[$sortid]['pic'];?>" /></p>
					<p><input type="file" class="formfile" name="pic" placeholder="分类图片" /></p>
				</div>
				<p><input type="text" class="formput" name="key" value="<?php echo $sorts[$sortid]['key'];?>" placeholder="关键字" /></p>
				<p><textarea name="description" class='formtext2' placeholder="分类描述"><?php echo $sorts[$sortid]['description'];?></textarea></p>
				<p>
					<select name="group" class="formsele">
						<option value='0' <?php echo $sorts[$sortid]['group']=='0'?'selected':'';?>>笔记</option>
						<option value='1' <?php echo $sorts[$sortid]['group']=='1'?'selected':'';?>>图集</option>
					</select>
				</p>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='保存' /><input type="button" onclick="javascript:window.history.back();" class="m_but2" value='取消' /></p>
			</form>
		</div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('sort');
}
</script>