<?php
include_once 'global.php';

updateCacheAll('options');
$banners=Control::get('banner_list');
$bannid=isset($_GET['id'])?$_GET['id']:'';
$temp = $bannid!=''&&!empty($banners[$bannid])?'bannedit':'banner';

if(isset($_POST['add'])){
	$adddata=array();
	$upfile=new Upfile();
	$bid=isset($_POST['id'])?$_POST['id']:'';
	$adddata['name']=isset($_POST['name'])?$_POST['name']:'';
	$adddata['pic']=isset($_POST['pic2'])?$_POST['pic2']:'';
	if(!empty($_FILES["pic"]["name"])){
		$adddata['pic'] = $upfile->upload($_FILES["pic"],'','banner');
		if($bid!=''){delThem($banners[$bid]['pic']);}
	}
	$adddata['blank']=isset($_POST['blank'])?$_POST['blank']:'0';
	$adddata['link']=isset($_POST['link'])?$_POST['link']:'0';
	$adddata['show']=isset($_POST['show'])?$_POST['show']:'1';
	$adddata['index']=isset($_POST['index'])?$_POST['index']:'0';
	$adddata['index']=$adddata['index']!=''?$adddata['index']:'0';
	
	$bid!=''?$banners[$bid]=$adddata:$banners[]=$adddata;
	$banners=action_Model::array_order($banners);
	$opdata['banner_list']=serialize($banners);
	Control::set($opdata);
	mkDirect(ADMIN_URL .'banner.php');
}


include View::getViewA('header');
require_once(View::getViewA($temp));
include View::getViewA('footer');
View::output();

?>