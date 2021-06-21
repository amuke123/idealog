<div class="main" id="main">
	<div class="content">
		<?php if($action=='install'){?>
		<div class="m_title">安装模板</div>
		<div class="m_add2">
			<form action="" method="post" enctype="multipart/form-data" >
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="group">
					<p>请上传压缩格式为zip的模板安装包</p>
					<p><input name="ziptpl" type="file" /></p>
				</div>
				<p class="m_button"><input type="submit" class="m_sub" name='uploadzip' value='上传安装' /><input type="button" onclick="javascript:window.history.back();" class="m_but2" value='取消' /></p>
			</form>
		</div>
		<?php }else{?>
		<div class="m_title">模板管理</div>
		<div class="tpl">
			<?php $code=Checking::getAjCode(12);?>
			<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
			<?php foreach($temarr as $v){;?>
			<ul class="item <?php echo Control::get('template') == $v['file']?'userz':'';?>">
				<li><a href="javascript:usertem('<?php echo $v['file']."','".IDEA_URL;?>');"><img alt="点击使用该模板" src="<?php echo TPLS_PATH .$v['file'].'/idea.jpg';?>"></a></li>
				<li class="t_title"><b><?php echo $v['name'];?></b><span> | <a href="javascript:deltem('<?php echo $v['file']."','".IDEA_URL;?>');">删除</a></span><?php echo Control::get('template') == $v['file']?'<b class="right">使用中</b>':'';?></li>
			</ul>
			<?php };?>
			<ul class="item2">
				<a href="?action=install">
					<p class="t_add"><i class="icon_add"></i></p>
					<p><b>添加模板</b></p>
				</a>
			</ul>
		</div>
		<?php }?>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('eye','template');
	showurl("0");
}
</script>