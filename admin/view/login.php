<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/style/login.css">
<link rel="stylesheet" type="text/css" href="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/style/icon.css">
<script charset="utf-8" src="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/js/action.js"></script>
<script charset="utf-8" src="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/js/ajax.js"></script>
<script charset="utf-8" src="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/js/login.js"></script>
<title><?php if($action=='login'){echo '登录';}if($action=='register'){echo '注册';}if($action=='reset'){echo '重置';}?>-IDESHU</title>
</head>
<body>
<div class="login">
	<div class="loginbg"></div>
	<div class="loginc">
		<a href="<?php echo IDEA_URL;?>">
			<div class="home" title="返回主页">
				<span class="h_movo1">I</span>
				<span class="h_movo2">D</span>
				<span class="h_movo3">E</span>
				<span class="h_movo4">A</span>
				<span class="h_movo5">-</span>
				<span class="h_movo6">S</span>
				<span class="h_movo7">H</span>
				<span class="h_movo8">U</span>
			</div>
		</a>
		<?php if($action=='login'){?>
		<div class="l_form">
			<div class="l_ftop">登录</div>
			<form action='' method='post' name='login'>
				<p><i class="icon icon-user"></i><input type="text" name="username" class="form_full2" required placeholder="用户ID/邮箱/手机号" /></p>
				<p><i class="icon icon-password"></i><input type="password" name="password" class="form_full2" required autocomplete="on" placeholder="请输入密码" /></p>
				<p>
				<?php if(Control::get('login_code')){?>
				<i class="icon icon-code"></i><input type="text" name="code" class="form_half" placeholder="验证码" /><span><img title="点击图片更换验证码" style="cursor:pointer;" src="<?php echo IDEA_URL.'include/core/code.php?ac='.rand(10000,99999);?>" onclick="this.src=this.src+Math.floor(Math.random()*10);" /></span>
				<?php }?>&nbsp;
				</p>
				<p><input type="checkbox" name="save" value='1' class="form_check"/><label>记住登录</label></p>
				<p class="l_p"><a href="<?php echo Url::getActionUrl('register');?>">账号注册</a><a href="<?php echo Url::getActionUrl('reset');?>">忘记密码</a><input type="submit" class="form_bt right" value="登录" name="tj" /></p>
			</form>
		</div>
		<?php }?>
		<?php if($action=='register'){?>
		<div class="l_form">
			<div class="l_ftop">注册</div>
			<form action='' method='post' name='register' onsubmit="return yzRegister();">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<input type="hidden" name='do' id='do' value="register" />
				<p><i class="icon icon-mail"></i><input type="text" name="sendid" id="email" class="form_full2" required placeholder="邮箱/手机号" /></p>
				<p><i class="icon icon-code"></i><input type="text" name="code" class="form_half" required placeholder="验证码" />
				<input type="button" class="form_bt2 right" value="获取验证码" id="mailcode" onclick="sendMail('<?php echo IDEA_URL;?>');" name="mailcode" /></p>
				<p><i class="icon icon-password"></i><input type="password" name="password" class="form_full2" required autocomplete="off" placeholder="请输入密码" /></p>
				<p><i class="icon icon-password"></i><input type="password" name="password2" class="form_full2" required autocomplete="off" placeholder="确认密码" /></p>
				<p>&nbsp;</p>
				<p class="l_p"><a href="<?php echo Url::getActionUrl('login');?>">已有账号</a><input type="submit" class="form_bt right" value="注册" name="tj" /></p>
			</form>
		</div>
		<?php }?>
		<?php if($action=='reset'){?>
		<div class="l_form">
			<div class="l_ftop">密码重置</div>
			<form action='' method='post' name='reset' onsubmit="return yzReset();">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<input type="hidden" name='do' id='do' value="reset" />
				<p><i class="icon icon-mail"></i><input type="text" name="sendid" id="email" class="form_full2" required placeholder="邮箱/手机号" /></p>
				<p><i class="icon icon-code"></i><input type="text" name="code" class="form_half" required placeholder="验证码" />
				<input type="button" class="form_bt2 right" value="获取验证码" id="mailcode" onclick="sendMail('<?php echo IDEA_URL;?>');" name="mailcode" /></p>
				<p><i class="icon icon-password"></i><input type="password" name="password" class="form_full2" required autocomplete="off" placeholder="请输入新密码" /></p>
				<p><i class="icon icon-password"></i><input type="password" name="password2" class="form_full2" required autocomplete="off" placeholder="确认新密码" /></p>
				<p>&nbsp;</p>
				<p class="l_p"><a href="<?php echo Url::getActionUrl('login');?>">返回登录</a><a href="<?php echo Url::getActionUrl('register');?>">注册新账号</a><input type="submit" class="form_bt right" value="重置" name="tj" /></p>
			</form>
		</div>
		<?php }?>
	</div>
</div>


</body>
</html>