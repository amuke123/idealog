<?php
include_once 'global.php';

updateCacheAll('options');
$links=Control::get('link_list');
$linkid=isset($_GET['id'])?$_GET['id']:'';

if(isset($_POST['add'])){
	$adddata=array();
	$upfile=new Upfile();
	$lid=isset($_POST['id'])?$_POST['id']:'';
	$adddata['name']=isset($_POST['sitename'])?$_POST['sitename']:'';
	$adddata['pic']=isset($_POST['pic2'])?$_POST['pic2']:'';
	if(!empty($_FILES["pic"]["name"])){
		$adddata['pic'] = $upfile->upload($_FILES["pic"],'','link');
		if($lid!=''){delThem($links[$lid]['pic']);}
	}
	$adddata['url']=isset($_POST['siteurl'])?$_POST['siteurl']:'0';
	$adddata['des']=isset($_POST['description'])?$_POST['description']:'0';
	$adddata['show']=isset($_POST['show'])?$_POST['show']:'1';
	$adddata['index']=isset($_POST['index'])?$_POST['index']:'0';
	$adddata['index']=$adddata['index']!=''?$adddata['index']:'0';
	
	$lid!=''?$links[$lid]=$adddata:$links[]=$adddata;
	$links=action_Model::array_order($links);
	$opdata['link_list']=serialize($links);
	Control::set($opdata);
	mkDirect(ADMIN_URL .'link.php');
}

include View::getViewA('header');
require_once(View::getViewA('link'));
include View::getViewA('footer');
View::output();

?>