<?php
include_once 'global.php';

$sorts = $cache->readCache('sort');
$sortid = isset($_GET['id'])?$_GET['id']:'';
$temp = $sortid?'sortedit':'sort';


if(isset($_POST['add'])){
	$adddata=array();
	$upfile=new Upfile();
	$sid=isset($_POST['id'])?$_POST['id']:'';
	$adddata['name']=isset($_POST['name'])?$_POST['name']:'';
	$adddata['alias']=isset($_POST['alias'])?$_POST['alias']:'';
	$adddata['pic']=isset($_POST['pic2'])?$_POST['pic2']:'';
	if(!empty($_FILES["pic"]["name"])){$adddata['pic'] = $upfile->upload($_FILES["pic"],'','sort');if($sid!=''){action_Model::delFile($sid,'sort');}}
	$adddata['description']=isset($_POST['description'])?$_POST['description']:'';
	$adddata['key']=isset($_POST['key'])?$_POST['key']:'';
	$adddata['template']=isset($_POST['template'])?$_POST['template']:'';
	$adddata['group']=isset($_POST['group'])?$_POST['group']:'0';
	$adddata['top_id']=isset($_POST['top_id'])?$_POST['top_id']:'0';
	$adddata['index']=isset($_POST['index'])?$_POST['index']:'0';
	$adddata['index']=$adddata['index']!=''?$adddata['index']:'0';
	
	if(action_Model::addLine($adddata,'sort',$sid)){mkDirect(ADMIN_URL .'sort.php');}
}



include View::getViewA('header');
require_once(View::getViewA($temp));
include View::getViewA('footer');
View::output();

?>