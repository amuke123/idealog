<?php
include_once 'global.php';
Checking::setSession();

$path = IDEA_ROOT .'/content/backup/';
$dblist=getBakDir($path);
$action=isset($_GET['action'])?$_GET['action']:'';

if($action=='databak'){
	$ajcode=isset($_GET['code'])?$_GET['code']:'';
	if(in_array($ajcode,$_SESSION['ajcode'])){
		unset($_SESSION['ajcode'][array_search($ajcode,$_SESSION['ajcode'])]);
		$_SESSION['ajcode']='';
		$text=Database::setBak();
	}else{
		$text='非法操作';
	}
	echo "<script>alert('".$text."');location.href='". ADMIN_URL ."data.php';</script>";
}

if($action=='import'){
	$ajcode=isset($_POST['token'])?$_POST['token']:'';
	if(in_array($ajcode,$_SESSION['ajcode'])){
		unset($_SESSION['ajcode'][array_search($ajcode,$_SESSION['ajcode'])]);
		$_SESSION['ajcode']='';
		$dbname=isset($_POST['dbname'])?urldecode($_POST['dbname']):'';
		$pathname='';
		if(!empty($dbname)){
			$pathname=$path.$dbname;
			$text=Database::importDb($pathname);
		}else{
			$temname=Database::upload($_FILES['file']);
			if(is_file($path.$temname)){
				$pathname=$path.$temname;
				$text=Database::importDb($pathname);
				delThem($pathname);
			}else{
				$text=$temname;
			}
		}
	}else{
		$text='非法操作';
	}
	echo "<script>alert('".$text."');location.href='". ADMIN_URL ."data.php';</script>";
	exit();
}

include View::getViewA('header');
require_once(View::getViewA('data'));
include View::getViewA('footer');
View::output();

?>