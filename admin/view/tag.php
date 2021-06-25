<div class="main" id="main">
	<div class="content">
		<?php if($tagid!=''){?>
		<div class="m_title">修改标签</div>
		<div class="m_add2">
			<form action="" method="post" name="tagadd" onSubmit="return yzTagAdd();" >
				<input type="hidden" name="tid" value="<?php echo $tagid;?>" />
				<p><input type="text" class="formput" name="name" value="<?php echo $tags[$tagid]['tagname']?>" placeholder="标签名" /></p>
				<div class="m_button"><input type="submit" class="m_sub" name='add' value='保存' /><input type="button" onclick="javascript:window.history.back();" class="m_but2" value='取消' /></div>
			</form>
		</div>
		<?php }else{?>
		<div class="m_title">标签</div>
		<form action="?action=del" method="post" name="myform">
			<div class="m_tags" id="m_tags">
			<?php foreach($tags as $value){?>
				<p style="background:<?php echo $value['color'];?>;" onclick="checked(this);" title="点击选中标签">
					<input type="checkbox" name="tag[<?php echo $value['id'];?>]" />
					<b><?php echo $value['tagname'];?></b> ( <?php echo $value['artnum'];?> )<br/>
					<a title="编辑标签" href="?id=<?php echo $value['id'];?>" ><i class="icon aicon-write2"></i></a>
				</p>
			<?php }?>
			</div>
			<div class="m_bt"><a href="javascript:all_checked('m_tags');">全选</a> 选中项：<a href="javascript:sub(myform,'m_tags');">删除</a> <span>（点击标签非编辑按钮处可选中该标签，再次点击取消选择。）</span></div>
		</form>
		<?php }?>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('bookmark','tag');
}
</script>