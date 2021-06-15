<div class="main" id="main">
	<div class="content">
		<div class="m_title">页面</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>标题</b><b>别名</b><b>模版</b><b>查看</b><b>评论</b><b>时间</b></p>
					<?php foreach($pages as $value){?>
						<p>
						<span><input type="checkbox" name="artck[]" value="<?php echo $value['id'];?>" /></span>
						<span class="tleft">
							<a title="点击标题编辑文章" href="<?php echo  ADMIN_URL ."page.php?action=edit&id=".$value['id'];?>"><?php echo $value['title']==''?'无标题':$value['title'];?></a>
							<?php echo $value['filenum']!=0?'<img src="'. ADMIN_URL .'view/static/images/att.gif" title="附件数：'.$value['filenum'].'" />':'';?>
							<?php echo $value['show']==0?'<strong class="red"> - 草稿 </strong>':'';?>
						</span>
						<span><?php echo $value['alias']==''?'':$value['alias'];?></span>
						<span><?php echo $value['template']==''?'page':$value['template'];?></span>
						<span><a target="_blank" href="<?php echo Url::log($value['id']);?>"><img title='查看' src='<?php echo ADMIN_URL . "/view/static/images/eye.png";?>' /></a></span>
						<span><a href="<?php echo  ADMIN_URL ."say.php?artid=".$value['id'];?>"><?php echo $value['saynum'];?></a></span>
						<span><?php echo $value['date']!=''?date("Y-m-d H:i:s",$value['date']):'';?></span>
						</p>
					<?php }?>
				</div>
				<div class="m_set">
					<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：<a class="red" href="javascript:delList('<?php echo IDEA_URL;?>','article');">删除</a> | <a href="javascript:setDraft('<?php echo IDEA_URL;?>','article');">放入草稿箱</a> | <a href="javascript:release('<?php echo IDEA_URL;?>','article');">发布</a>
				</div>
				<div class="m_button">
					<input type="button" onClick="javascript:location.href='<?php echo ADMIN_URL .'page.php?action=add';?>';" class="m_but" name='add' value='新建页面 +' />
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('bookmark','page');
	showurl("0");
}
</script>