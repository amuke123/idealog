<?php
class Email{
	static function sendMail($emailid,$data=''){//发送邮件
	
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
$content = <<<EOF
Subject: $title
From:"$sendname"<$sendmail>
To:""<$toemail>
Content-Type: text/html;

$str
.

EOF;
		
		$streamContext = stream_context_create();
		$stream = stream_socket_client("tcp://$host:$port",$errno,$errstr,$timeout = 10,STREAM_CLIENT_CONNECT,$streamContext);
		stream_set_blocking($stream,1);
		fgets($stream);
		
		fwrite($stream, sprintf("HELO %s\n", $host));
		fgets($stream);
		
		fwrite($stream, "AUTH LOGIN\n");
		fgets($stream);
		
		fwrite($stream, sprintf("%s\n", base64_encode($sendname)));
		fgets($stream);
		
		fwrite($stream, sprintf("%s\n", base64_encode($sendmailpswd)));
		fgets($stream);
		
		fwrite($stream, sprintf("MAIL FROM: <%s>\n",$sendmail));
		fgets($stream);
		
		fwrite($stream, sprintf("RCPT TO: <%s>\n",$toemail));
		fgets($stream);
		
		fwrite($stream, sprintf("%s\n", 'DATA'));
		fgets($stream);
		
		fwrite($stream, $content);
		fgets($stream);

		fwrite($stream, sprintf("%s\n", 'QUIT'));
		fgets($stream);
		
	}
}

?>