<?php
include_once 'global.php';

$them='user';
$db=Conn::getConnect();
$action = isset($_GET['action'])?$_GET['action']:'';

$pagenum = Control::get('admin_pnum');//每页显示用户数
$pageid=isset($_GET['page'])?$_GET['page']:1;//页码
$startnum = $pagenum*($pageid-1);//开始数
$endnum = $startnum+$pagenum;//结束数

$examine = isset($_GET['examine'])?$_GET['examine']:1;
$state = isset($_GET['state'])?$_GET['state']:1;

$urlsub = '';
$urlsub .= $state=='0'?'&state=0':'';
$urlsub .= $examine=='0'?'&examine=0':'';

$users = user_Model::getUsersIofo($startnum,$pagenum,$examine,$state);

//print_r($users);

if($action=='check'){//审核
	$idck=isset($_GET['id'])?$_GET['id']:'';
	$sqlst="UPDATE `". DB_PRE ."user` SET `check`='1' WHERE `id`=".$idck;
	if($db->query($sqlst)){
		updateCacheAll('sta');
		mkDirect(ADMIN_URL ."user.php?examine=0");
	}
}
if($action=='state'){//解禁
	$idst=isset($_GET['id'])?$_GET['id']:'';
	$sqlst="UPDATE `". DB_PRE ."user` SET `state`='0' WHERE `id`=".$idst;
	if($db->query($sqlst)){
		updateCacheAll('sta');
		mkDirect(ADMIN_URL ."user.php?state=0");
	}
}
if($action=='do'){//封禁
	$iddo=isset($_GET['id'])?$_GET['id']:'';
	$doid=isset($_GET['doid'])?$_GET['doid']:'';
	$sqlst="UPDATE `". DB_PRE ."user` SET `state`='".$doid."' WHERE `id`=".$iddo;
	if($db->query($sqlst)){
		updateCacheAll('sta');
		mkDirect(ADMIN_URL ."user.php");
	}
}
if($action=='del'){
	$iddel=isset($_GET['id'])?$_GET['id']:'';
	$sqlst="DELETE FROM `". DB_PRE ."user` WHERE `id` =".$iddel;
	if($db->query($sqlst)){
		updateCacheAll('sta');
		mkDirect(ADMIN_URL ."user.php");
	}
}


if($action=='edit'||$action=='add'){
	$them='useredit';
	$uid=isset($_GET['id'])?$_GET['id']:'';
	if($uid!=""){$edituser=user_Model::getInfo($uid);}
}


if(isset($_POST['add'])||isset($_POST['edit'])){
	$datauser=array();
	$userid=isset($_POST['userid'])?$_POST['userid']:'';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		
		$usernames=isset($_POST['username'])?$_POST['username']:'';
		if(isset($_POST['add'])){
			$sqlcxuser="SELECT `id` FROM `". DB_PRE ."user` WHERE `username` ='".$usernames."'";
			$cxus=$db->getOnce($sqlcxuser);
			if(!empty($cxus['id'])){
				echo "<script>alert('用户登录名已存在！请更换用户名');window.history.back();</script>";exit;
			}
		}
		$datauser['username']=$usernames;
		if($userid!=''){$oldpw=isset($_POST['password'])?$_POST['password']:'';}
		if(isset($_POST['add'])){
			if(!isset($_POST['password1'])||$_POST['password1']==''){
				echo "<script>alert('密码不能为空！');window.history.back();</script>";exit;
			}else{
				$datauser['password']=Checking::hashjm(Checking::jm($_POST['password1']));
			}
		}
		if(isset($_POST['edit'])){
			$sqlcx="SELECT `password` FROM `". DB_PRE ."user` WHERE `id` =".$userid;
			$cxjg=$db->getOnce($sqlcx);
			$password=setUTF8(Checking::jm($oldpw));
			if(!empty($cxjg['password'])&&$oldpw!=''){
				if(Checking::checkPw($password,$cxjg['password'])){
					if(!isset($_POST['password1'])||$_POST['password1']==''){
						echo "<script>alert('密码不能为空！');window.history.back();</script>";exit;
					}else{
						$datauser['password']=Checking::hashjm(Checking::jm($_POST['password1']));
					}
				}else{
					echo "<script>alert('原密码错误！');window.history.back();</script>";exit;
				}
			}
		}
		
		$datauser['photo']=isset($_POST['pic'])?$_POST['pic']:'';
		$datauser['date']=time();
		$datauser['nickname']=isset($_POST['nickname'])?$_POST['nickname']:'';
		$datauser['email']=isset($_POST['email'])?$_POST['email']:'';
		$datauser['tel']=isset($_POST['tel'])?$_POST['tel']:'';
		$datauser['order']=isset($_POST['order'])?$_POST['order']:'';
		$datauser['diyurl']=isset($_POST['userurl'])?$_POST['userurl']:'';
		$datauser['description']=isset($_POST['description'])?$_POST['description']:'';
		
		if(user_Model::addLine($datauser,'user',$userid)){mkDirect(ADMIN_URL ."user.php");}
		
	}else{
		echo "<script>alert('非法操作');window.history.back();</script>";exit;
	}
}


$usernumb=user_Model::getUsersNum($examine,$state);
$pages=ceil($usernumb/$pagenum);
$urlpre=ADMIN_URL .'user.php?';
$urlpre.='page=';
$txtsub='位用户';

$pagestr=action_Model::pagelist($usernumb,$pages,$pageid,$urlpre,$txtsub,$urlsub);


include View::getViewA('header');
require_once(View::getViewA($them));
include View::getViewA('footer');
View::output();

?>