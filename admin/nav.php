<?php
include_once 'global.php';

$tem='nav';
$navs = $cache->readCache('nav');
$sorts = $cache->readCache('sort');
$novesorts = array('默认分组','分组1','分组2','分组3','分组4');
$booksorts = array();
$db=Conn::getConnect();
$group = isset($_GET['group'])?$_GET['group']:'0';
$action = isset($_GET['action'])?$_GET['action']:'';

$pages=art_Model::getPages();
$pagearr=$pages;

if($action=='edit'){
	$navid=isset($_GET['id'])?$_GET['id']:'0';
	$navline=nav_Model::getNav($navid);
	$tem='navedit';
}

if(isset($_POST['addsort'])){
	$sck=isset($_POST['sck'])?$_POST['sck']:'';
	$groups=isset($_POST['group'])?$_POST['group']:'';
	nav_Model::addNav($sck,$groups,$sorts,'sort','4');
	mkDirect(ADMIN_URL .'nav.php');
}

if(isset($_POST['addpage'])){
	$pck=isset($_POST['pck'])?$_POST['pck']:'';
	$groupp=isset($_POST['group'])?$_POST['group']:'';
	nav_Model::addNav($pck,$groupp,$pagearr,'page','5');
	mkDirect(ADMIN_URL .'nav.php');
}

if(isset($_POST['adddiy'])){
	$adddata=array();
	$upfile=new Upfile();
	$lid=isset($_POST['id'])?$_POST['id']:'';
	
	$adddata['index'] = isset($_POST['index'])?$_POST['index']:'0';
	$adddata['name'] = isset($_POST['name'])?$_POST['name']:'0';
	if(isset($_POST['url'])){$adddata['url'] = $_POST['url'];}
	$adddata['pic']=isset($_POST['pic2'])?$_POST['pic2']:'';
	if(!empty($_FILES["pic"]["name"])){
		$adddata['pic'] = $upfile->upload($_FILES["pic"],'','nav');
	}
	$adddata['group'] = isset($_POST['group'])?$_POST['group']:'0';
	$adddata['top_id'] = isset($_POST['topid'])?$_POST['topid']:'0';
	$adddata['blank'] = isset($_POST['blank'])?$_POST['blank']:'0';
	
	nav_Model::addDiyNav($adddata,$lid);
	mkDirect(ADMIN_URL .'nav.php');
}



include View::getViewA('header');
require_once(View::getViewA($tem));
include View::getViewA('footer');
View::output();

?>