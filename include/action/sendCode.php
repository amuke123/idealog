<?php
define('ROOT', dirname(dirname(dirname(__FILE__))));
include_once ROOT.'/include/core/amuker.php';
Checking::setSession();

if(isset($_POST['sendid'])){
	$data=array();
	$data['action']='sendid';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$text='';
	if(in_array($ajcode,$_SESSION['ajcode'])){
		unset($_SESSION['ajcode'][array_search($ajcode,$_SESSION['ajcode'])]);
		$sendid=isset($_POST['sendid'])?$_POST['sendid']:'';
		$type=isset($_POST['type'])?$_POST['type']:'';
		$do=isset($_POST['do'])?$_POST['do']:'';
		if($do!=''&&$type!=''){
			if($do=='register'){
				if(Checking::checkSendId($sendid)){
					$text="该账号已被注册，请直接登录！";
				}else{
					if($type=='email'){Email::sendMail($sendid);}
					if($type=='tell'){App::sendTell($sendid);}
				}
			}else if($do=='reset'){
				if(Checking::checkSendId($sendid)){
					if($type=='email'){Email::sendMail($sendid);}
					if($type=='tell'){App::sendTell($sendid);}
				}else{
					$text="该账号未注册，请先注册！";
				}
			}else if($do=='yzm'){
				if($type=='email'){Email::sendMail($sendid);}
				if($type=='tell'){App::sendTell($sendid);}
			}else{$text="错误操作！";}
		}
	}
	$data['text']=$text;
	echo json_encode($data);
}


?>