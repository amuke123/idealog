<?php
include_once 'global.php';

$sorts = $cache->readCache('sort');
$tags = $cache->readCache('tags');


if(isset($_POST['id'])){
	$data=array();
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$fb = isset($_POST['fb']) ? $_POST['fb'] : '';
	if($id==''){
		$data['author'] = UID;
		$data['type'] = 'a';
		$data['check'] = Control::get('art_check')=='1'?'0':'1';
		$data['template'] = '';
		$data['filenum'] = isset($_POST['filenum']) ? $_POST['filenum'] : '0';
	}else{
		$arr['filenum'] = art_Model::getArtFileNum($id);
	}
	if($fb==''){$data['show'] = '1';ROLE==ROLE_ADMIN?$data['check'] = '1':'';}
	$data['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']): '';//addslashes//htmlspecialchars
	if($data['title']==''){echo "<script>alert('标题不能为空');window.history.go(-1);</script>";exit();}
	$data['content'] = isset($_POST['content']) ? htmlspecialchars(addslashes($_POST['content'])):'';
	$getsite = isset($_POST['getsite']) ? $_POST['getsite'] : '';
	if($getsite=='网络'){$geturl = isset($_POST['geturl']) ? htmlspecialchars($_POST['geturl']) : '';}
	if($getsite=='原创'){$copyrights = isset($_POST['copyrights']) ? $_POST['copyrights'] : '0';}
	$data['getsite']=$getsite;
	$data['geturl']=isset($geturl)?$geturl:'';
	$data['copyrights']=isset($copyrights)?$copyrights:'0';
	$data['pic'] = isset($_POST['pic']) ? htmlspecialchars($_POST['pic']) : '';
	$data['excerpt'] = isset($_POST['excerpt']) ? htmlspecialchars($_POST['excerpt']) : '';
	$data['saynum'] = isset($_POST['saynum']) ? $_POST['saynum'] : '0';
	
	$data['s_id'] = isset($_POST['sort']) ? $_POST['sort'] : '-1';
	$tagstr = isset($_POST['tags']) ? htmlspecialchars($_POST['tags']) : '';
	//$data['tags'] = isset($_POST['tags']) ? htmlspecialchars($_POST['tags']) : '';
	$data['date'] = isset($_POST['date']) ? strtotime(htmlspecialchars($_POST['date'])) : '';
	$data['alias'] = isset($_POST['alias']) ? htmlspecialchars($_POST['alias']) : '';
	$data['key'] = isset($_POST['key']) ? htmlspecialchars(str_replace('，',',',$_POST['key'])) : '';
	$data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
	$data['eyes'] = isset($_POST['eyes']) ? htmlspecialchars($_POST['eyes']) : '0';
	$data['goodnum'] = isset($_POST['goodnum']) ? htmlspecialchars($_POST['goodnum']) : '0';
	$data['badnum'] = isset($_POST['badnum']) ? htmlspecialchars($_POST['badnum']) : '0';
	$data['sayok'] = isset($_POST['sayok']) ? $_POST['sayok'] : '0';
	$marktop= isset($_POST['marktop']) ? htmlspecialchars($_POST['marktop']) : '0';
	$marksorttop = isset($_POST['marksorttop']) ? htmlspecialchars($_POST['marksorttop']) : '0';
	$mark="";
	if($marktop=='1'){$mark.='T';}
	if($marksorttop=='1'){$mark.=',ST';}
	$mark=trim($mark,',');
	$data['mark']=$mark;

	if(art_Model::addArt($data,$id,$tagstr)){
		mkDirect(ADMIN_URL .'article.php');
	}else{
		echo "<script>alert('保存错误');window.history.go(-1);</script>";
	}
}

if(isset($_GET['artid'])){
	$aid=!empty($_GET['artid'])?$_GET['artid']:'';
	$art=art_Model::getOnceArt($aid);
	if(!empty($art)&&!empty($art['tags'])){
		$tagidsarr=explode(',',$art['tags']);
		$tagnamestr='';
		if(!empty($tagidsarr)){
			foreach($tagidsarr as $vtag){
				$tagnamestr.=','.$tags[$vtag]['tagname'];
			}
		}
		$tagnamestr=trim($tagnamestr,',');
	}else{
		$tagnamestr='';
	}
}else{$aid='';}



include View::getViewA('header');
require_once(View::getViewA('write_art'));
include View::getViewA('footer');
View::output();

?>