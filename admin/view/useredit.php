<div class="main" id="main">
	<div class="content">
		<div class="m_title"><?php echo $action=='add'?'添加用户':'修改资料';?></div>
		<div class="m_add2">
			<div class="cont">
			<?php $photo = TEMPLATE_URLA .'static/images/avatar.jpg';?>
			<form action="" method="post" name="useradd" onSubmit="return yzUserAdd();" >
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<p><b>登陆名:</b><?php echo $uid?$edituser['username']:'';?><input name="username" type="<?php echo $uid?'hidden':'text';?>" class="long" value="<?php echo $uid?$edituser['username']:'';?>"  placeholder="登陆名" /></p>
				<?php if($action=='edit'){?>
					<p><b>原密码:</b><input name="password" type="password" autocomplete="off" class="long" placeholder="原密码，设置新密码时填写" /></p>
				<?php }?>
				<p><b><?php echo $action=='add'?'登录密码':'新密码，不修改请留空';?></b></p>
				<p><input name="password1" type="password" class="long" autocomplete="off" placeholder="密码" /></p>
				<p><input name="password2" type="password" class="long" autocomplete="off" placeholder="确认密码" /></p>
				
				<?php if($uid){$photoimg = $edituser['photo']!='' ?str_replace('../',IDEA_URL,$edituser['photo']):$photo;}else{$photoimg=$photo;}?>
				<p><b><img id="userphoto" src="<?php echo $photoimg?>" /></b></p>
				<?php if($uid){$photosrc = $edituser['photo']!='' ?$edituser['photo']:'';}else{$photosrc='';}?>
				<span><input name="pic" id="userpic" type="hidden" value="<?php echo $photosrc;?>" /></span>
				<p><a href="javascript:delphoto('<?php echo IDEA_URL;?>','<?php echo $uid;?>');">删除头像</a></p>
				<p><b>上传头像(支持JPG、PNG格式图片)</b></p>
				<p><input name="myfile" type="file" id="myfile" class="nonebor" onchange="upfile('<?php echo IDEA_URL;?>','avatar');" /></p>
				<p><b>昵称:</b><input name="nickname" type="text"  class="long" value="<?php echo $uid?$edituser['name']:'';?>" placeholder="昵称" /></p>
				<p><b>邮箱:</b><input name="email" type="text"  class="long" value="<?php echo $uid?$edituser['email']:'';?>" placeholder="邮箱" /></p>
				<p><b>电话:</b><input name="tel" type="text"  class="long" value="<?php echo $uid?$edituser['tel']:'';?>" placeholder="电话" /></p>
				<p><b>积分:</b><input name="order" type="text"  class="long" value="<?php echo $uid?$edituser['order']:'';?>" placeholder="积分" /></p>
				<p><b>个性域名:</b><input name="userurl" type="text"  class="long" value="<?php echo $uid?$edituser['diyurl']:'';?>" placeholder="个性域名 （ <?php echo IDEA_URL;?>author/个性域名 ）" /><span>个性域名（ <?php echo IDEA_URL;?>author/个性域名 ）</span></p>
				<p><b>个人描述</b></p>
				<p><textarea name="description" class="long"><?php echo $uid?$edituser['description']:'';?></textarea></p>
				<span><input name="userid" type="hidden" value="<?php echo $uid?$edituser['id']:'';?>" /></span>
				<p><br/>
				<?php if($action=='add'){?>
					<input type="submit" class="m_sub" name='add' value='添加用户' />
				<?php }else{?>
					<input type="submit" class="m_sub" name='edit' value='保存' />
					<input type="button" onclick="javascript:window.history.back();" class="m_but2" value='取消' />
				<?php }?>
				</p>
			</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('ulist','user');
}
</script>