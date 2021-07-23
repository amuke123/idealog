<?php
include_once 'global.php';

$db=Conn::getConnect();
$action=isset($_GET['action'])?$_GET['action']:'';
$them='page';

if($action==""){$pages=art_Model::getPage();}

if($action=='add'){$them='pageedit';}

if($action=='edit'){
	$pid=isset($_GET['id'])?$_GET['id']:'';
	$pagearr=art_Model::getPage($pid);
	$pagei=$pagearr[0];
	$them='pageedit';
}else{$pid='';}

if(isset($_POST['tj'])){
	$db=Conn::getConnect();
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$fb = isset($_POST['fb']) ? $_POST['fb'] : '';
	$arr=array();

	if($id==''){
		$arr['author'] = isset($_POST['author']) ? $_POST['author'] : '1';
		$arr['show'] = isset($_POST['show']) ? $_POST['show'] : '1';
		$arr['check'] = isset($_POST['check']) ? $_POST['check'] : '1';
		$arr['getsite'] = isset($_POST['getsite']) ? $_POST['getsite'] : '';
		$arr['geturl']= isset($_POST['geturl']) ? $_POST['geturl'] : '';
		$arr['copyrights']= isset($_POST['copyrights']) ? $_POST['copyrights'] : '0';
		$arr['pic'] = isset($_POST['pic']) ? htmlspecialchars($_POST['pic']) : '';
		$arr['excerpt'] = isset($_POST['excerpt']) ? htmlspecialchars($_POST['excerpt']) : '';
		$arr['s_id'] = isset($_POST['s_id']) ? $_POST['s_id'] : '0';
		$arr['date'] = time();
		$arr['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
		$arr['eyes'] = isset($_POST['eyes']) ? htmlspecialchars($_POST['eyes']) : '0';
		$arr['goodnum'] = isset($_POST['goodnum']) ? htmlspecialchars($_POST['goodnum']) : '0';
		$arr['badnum'] = isset($_POST['badnum']) ? htmlspecialchars($_POST['badnum']) : '0';
		$arr['mark'] = isset($_POST['mark']) ? $_POST['mark'] : '';
		$arr['filenum'] = isset($_POST['filenum'])&&!empty($arr['filenum']) ? $_POST['filenum'] : '0';
	}else{
		$arr['filenum'] = art_Model::getArtFileNum($id);
		$arr['filenum']=!empty($arr['filenum'])?$arr['filenum']:'0';
	}
	if($fb==''){$data['show'] = '1';}
	$arr['type'] = isset($_POST['arttype']) ? $_POST['arttype'] : 'p';
	$arr['template'] = isset($_POST['template']) ? $_POST['template'] : '';
	$arr['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
	$arr['content'] = isset($_POST['content']) ? $_POST['content'] : '';
	$arr['saynum'] = isset($_POST['saynum'])&&!empty($arr['saynum']) ? $_POST['saynum'] : '0';

	$arr['alias'] = isset($_POST['alias']) ? htmlspecialchars($_POST['alias']) : '';
	$arr['key'] = isset($_POST['key']) ? htmlspecialchars($_POST['key']) : '';
	$arr['sayok'] = isset($_POST['sayok']) ? $_POST['sayok'] : '0';
	
	if(art_Model::addArt($arr,$id)){
		mkDirect(ADMIN_URL .'page.php');
	}else{
		echo "<script>alert('保存错误');window.history.go(-1);</script>";
	}
}

include View::getViewA('header');
require_once(View::getViewA($them));
include View::getViewA('footer');
View::output();

?>