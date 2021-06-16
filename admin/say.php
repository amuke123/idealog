<?php
include_once 'global.php';

$pagenum = Control::get('say_pnum');//每页显示评论数
if(ADMIN_URL!==null){$pagenum = Control::get('admin_pnum');}
$pageid = isset($_GET['page'])?$_GET['page']:1;
$startnum = $pagenum*($pageid-1);
$action = isset($_GET['action'])?$_GET['action']:'';
$god = isset($_GET['god'])?$_GET['god']:1;
$good = isset($_GET['good'])?$_GET['good']:1;
$artid = isset($_GET['artid'])?$_GET['artid']:0;
$examine = isset($_GET['examine'])?$_GET['examine']:1;
$db=Conn::getConnect();

if(isset($_POST['add'])){
	$topid = isset($_POST['id'])?$_POST['id']:'0';
	$tid = isset($_POST['tid'])?$_POST['tid']:'0';
	$tid = $tid=='0'?$topid:$tid;
	$aid = isset($_POST['aid'])?$_POST['aid']:'0';
	$desc = isset($_POST['description'])?$_POST['description']:'0';
	$times = time();
	$sqlre = "INSERT INTO `". DB_PRE ."comment` (`id`,`a_id`,`top_id`,`t_id`,`date`,`posterid`,`name`,`content`,`mail`,`url`,`ip`,`show`,`check`,`mark`) VALUES (NULL,'".$aid."','".$topid."','".$tid."','".$times."','".UID."','".$user_cache[ UID ]['name']."','".$desc."','".$user_cache[ UID ]['mail']."','". IDEA_URL ."','".getIp()."','1','1','0');";
	if($db->query($sqlre)){
		$sql7="SELECT count(*) as sumnum FROM `". DB_PRE ."comment` WHERE `del`='1' AND `a_id` = ".$aid.";";
		$arr=$db->getOnce($sql7);
		$sql8="UPDATE `". DB_PRE ."article` SET `saynum`='".$arr['sumnum']."' WHERE `id` = ".$aid.";";
		$db->query($sql8);
		updateCacheAll();
	}
	mkDirect(ADMIN_URL .'say.php');
}

if($action=='edit'){
	$eid=isset($_GET['id'])?$_GET['id']:0;
	$sqlline="SELECT * FROM `". DB_PRE ."comment` WHERE `id`=".$eid;
	$lineedit=$db->getOnce($sqlline);
}

$sqltem="";
if($god=='0'){$sqltem.=" AND `mark`='2' ";}
if($good=='0'){$sqltem.=" AND `mark`='1' ";}
if($examine=='0'){$sqltem.=" AND `check`='0' ";}

$says=say_Model::getSays($artid,$sqltem,$startnum,$pagenum);

$urlsub = '';
$urlsub .= $god=='0'?'&god=0':'';
$urlsub .= $good=='0'?'&good=0':'';
$urlsub .= $examine=='0'?'&examine=0':'';

$saynumb=say_Model::getSayNum($artid,$sqltem);
$pages=ceil($saynumb/$pagenum);
$urlpre=ADMIN_URL .'say.php?';
$urlpre.='page=';
$txtsub='条评论';

$pagestr=action_Model::pagelist($saynumb,$pages,$pageid,$urlpre,$txtsub,$urlsub,$artid);


include View::getViewA('header');
require_once(View::getViewA('say'));
include View::getViewA('footer');
View::output();

?>