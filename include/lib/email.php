<?php
class Email{
	static function sendMail($emailid,$data=''){//发送邮件
		include_once IDEA_ROOT .'/include/core/mail/PHPMailer.php';
		include_once IDEA_ROOT .'/include/core/mail/Exception.php';
		include_once IDEA_ROOT .'/include/core/mail/SMTP.php';
		
		$host=Control::get('mailhost');
		$port=Control::get('mailport');
		$sendmail=Control::get('mail');
		$te=explode('@',$sendmail);
		$sendname=$te[0];
		$sendmailpswd=Control::get('mailpswd');
		$title='验证码';
		$code=Cellcode::getCode($emailid);
		$sitename=SITE_NAME;
		$toemail=$emailid;
		$str = $data!=''?$data:'<p>您的验证码是：</p><p><b>'.$code.'</b></p><p>如非本人操作，请忽略此邮件，由此给您带来的不便请谅解！</p><p>'.$sitename .'</p>';
		
		//$mail = new PHPMailer(true);
		$mail = new PHPMailer\PHPMailer\PHPMailer();// 实例化PHPMailer核心类//$mail = new PHPMailer();
		//$mail->SMTPDebug = 1;// 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
		$mail->isSMTP();// 使用smtp鉴权方式发送邮件
		$mail->SMTPAuth = true;// smtp需要鉴权 这个必须是true
		$mail->Host = $host;// 链接qq域名邮箱的服务器地址
		$mail->SMTPSecure = 'ssl';// 设置使用ssl加密方式登录鉴权
		$mail->Port = $port;// 设置ssl连接smtp服务器的远程服务器端口号
		$mail->CharSet = 'UTF-8';// 设置发送的邮件的编码
		$mail->FromName = $sitename;// 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
		$mail->Username = $sendmail;// smtp登录的账号 QQ邮箱即可
		$mail->Password = $sendmailpswd;// smtp登录的密码 使用生成的授权码
		$mail->From = $sendmail;// 设置发件人邮箱地址 同登录账号
		$mail->isHTML(true);// 邮件正文是否为html编码 注意此处是一个方法
		$mail->addAddress($sendmail);// 添加密送者，Mail Header不会显示密送者信息
		$mail->addAddress($toemail);// 设置收件人邮箱地址// 添加多个收件人 则多次调用方法即可
		$mail->Subject = $title;// 添加该邮件的主题
		$mail->Body = $str;// 添加邮件正文
		//$mail->addAttachment('./example.pdf');// 为该邮件添加附件
		$status = $mail->send();// 发送邮件 返回状态,debug开启后才会返回状态

	}
	
}

?>