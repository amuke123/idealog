<div class="main" id="main">
	<div class="content">
		<div class="m_title">新建页面</div>
		<form action="" name="add_page" method='post'>
			<div class="m_contents left">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<input type="hidden" name='arttype' id='arttype' value="p" />
				<input type="hidden" name="id" id="aid" value="<?php echo $pid?$pagei['id']:'';?>" />
				<input type="hidden" name="fb" id="fb" value="<?php echo $pid?$pagei['id']:'';?>" />
				<input type="hidden" name="filenum" id="filenum" value="<?php echo $pid?$pagei['filenum']:'0';?>"/>
				<input type="hidden" name="saynum" value="<?php echo $pid?$pagei['saynum']:'0';?>" />
				<p><input type="text" name="title" value="<?php echo $pid?$pagei['title']:'';?>" class="formtitle" placeholder="请在这里输入标题" /></p>
				<p><textarea id="editor" class="formtext" name="content" ><?php echo $pid?$pagei['content']:'';?></textarea></p>
			</div>
			<div class="m_side right">
				<p><input type="text" name="alias" class="formlong" value="<?php echo $pid?$pagei['alias']:'';?>" placeholder="链接别名" /></p>
				<p><input type="text" name="template" class="formlong" value="<?php echo $pid?$pagei['template']:'';?>" placeholder="页面模版" /></p>
				<p><input type="text" name="key" class="formlong" value="<?php echo $pid?$pagei['key']:'';?>" placeholder="页面关键字" /></p>
				<p>
					<span class="m_mar"><input type="checkbox" name="sayok" <?php if($pid){echo $pagei['sayok']=='1'?'checked':'';}?> value="1" /><span class="m_mar">允许评论</span></span>
				</p>
				<div class="m_button">
					<input type="submit" class="m_sub" name='tj' value='<?php echo $pid?'保存并返回':'发布页面';?>' />
					<input type="button" onClick="javascript:autoSave2('<?php echo IDEA_URL;?>');" class="m_but" name='add' value='<?php echo $pid?'保存':'保存草稿';?>' />
				</div>
			</div>
			<div class="clear"></div>
		</form>
		<div class="clear"></div>
	</div>
</div>
<script>
var editor = MK.getEditor('editor',{
	uploadKey:true,
	uploadUrl:'include/action/actiondo.php',
	uploadPath:'content/uploadfile',
});
</script>
<script>
window.onload=function(){
	autoShow('bookmark','page');
}
</script>