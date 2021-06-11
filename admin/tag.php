<?php
include_once 'global.php';

$tags=$cache->readCache('tags');
$action=isset($_GET["action"])?$_GET["action"]:'';
$tagid=isset($_GET["id"])?$_GET["id"]:'';
$db=Conn::getConnect();

if(isset($_POST['add'])){
	$adddata=array();
	$tid=isset($_POST["tid"])?$_POST["tid"]:'';
	$adddata['name']=isset($_POST["name"])?$_POST["name"]:'';
	if(action_Model::addLine($adddata,'tags',$tid)){mkDirect(ADMIN_URL .'tag.php');}
}

if($action=='del'){
	$taglist=isset($_POST['tag'])?$_POST['tag']:"";
	print_r($taglist);
	if(tag_Model::delTags($taglist)){mkDirect(ADMIN_URL .'tag.php');}
}

include View::getViewA('header');
require_once(View::getViewA('tag'));
include View::getViewA('footer');
View::output();

?>