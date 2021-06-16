<div class="main" id="main">
	<div class="content">
		<div class="m_title">编辑导航</div>
		<div class="m_content">
			<div class="m_add2">
				<form action="" method="post" name="navadddiy" onSubmit="return yzNavAdd();" enctype="multipart/form-data" >
					<input type="hidden" name="id" value="<?php echo $navline['id'];?>" />
					<?php if($navline['type']!='1'){?>
					<p>
						<select name="group" class="formsele">
							<?php foreach($novesorts as $nokey => $noval){?>
							<option value="<?php echo $nokey;?>" <?php echo $navline['group']==$nokey?'selected':'';?>><?php echo $noval;?></option>
							<?php }?>
						</select> <b>分组</b>
					</p>
					<?php }?>
					<p><input type="text" class="formin" name="index" value="<?php echo $navline['index'];?>" placeholder="序号" /> <b>序号</b></p>
					<p><input type="text" class="formput" name="name" value="<?php echo $navline['name'];?>" placeholder="导航名称" /> <b>导航名称</b></p>
					<p><input type="text" class="formput" name="url" <?php if($navline['type']!='0'){echo "disabled='disabled'";}?> value="<?php echo $navline['type']!='0'?'该导航地址由系统生成，无法修改':$navline['url'];?>" placeholder="链接(带http或https)" /> <b>导航地址</b></p>
					<div class="group">
						<p><img <?php echo $navline['pic']==""?'src="'.TEMPLATE_URLA .'static/images/img.gif" class="xt" title="无图"':'src="'.$navline['pic'].'"';?> /><input type="hidden" name="pic2" value="<?php echo $navline['pic'];?>" /> <b>导航图标</b></p>
						<p><input type="file" class="formfile" name="pic" /></p>
					</div>
					<?php if($navline['type']=='0'){?>
					<p>
						<select name="topid" class="formsele">
							<option value="0">无</option>
							<?php echo nav_Model::getNavList($navs,$group,$navid,$navline['top_id']);?>
						</select> <b>父导航</b>
					</p>
					<?php }?>
					<p>
						<select name="blank" class="formsele">
							<option value="0">当前页打开</option>
							<option value="1" <?php echo $navline['blank']=='1'?'selected':'';?>>新页面打开</option>
						</select> <b>打开方式</b>
					</p>
					<p class="m_button"><input type="submit" class="m_sub" name='adddiy' value='保存修改' /><input type="button" onclick="window.history.back();" class="m_but2" value='取消' /></p>
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('eye','nav');
}
</script>