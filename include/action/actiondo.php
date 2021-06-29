<?php
define('ROOT', dirname(dirname(dirname(__FILE__))));
include_once ROOT.'/include/core/amuker.php';
Checking::setSession();

if(isset($_POST['idexid'])){
	$data=array();
	$data['action']='index';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$sids=explode(',',$_POST['idexid']);
		$indexs=explode(',',$_POST['idexval']);
		action_Model::setIndex($sids,$indexs,$dbtb);
		updateCacheAll();
		$data['text']='更新成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['idexid2'])){
	$data=array();
	$data['action']='index';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$option=isset($_POST['option'])?$_POST['option']:'';
	$banners=Control::get($option);
	if($ajcode==$_SESSION['ajcode']){
		$sids=explode(',',$_POST['idexid2']);
		$indexs=explode(',',$_POST['idexval']);
		$orda=array();
		foreach($sids as $sk => $sv){
			$orda[$sv]=$indexs[$sk];
			$banners[$sv]['index']=$indexs[$sk];
		}
		$banners=action_Model::array_order($banners,'index','asc',$orda);
		$opdata[$option]=serialize($banners);
		Control::set($opdata);
		updateCacheAll('options');
		$data['text']='更新成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['delline'])){
	$data=array();
	$data['action']='delline';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$sortid=$_POST['delline'];
		if($dbtb=='sort'){art_Model::moveSort($sortid);}
		action_Model::delFile($sortid,$dbtb);
		action_Model::delLine($sortid,$dbtb);
		updateCacheAll();
		$data['text']='已删除';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['delline2'])){
	$data=array();
	$data['action']='delline';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$option=isset($_POST['option'])?$_POST['option']:'';
	$banners=Control::get($option);
	if($ajcode==$_SESSION['ajcode']){
		$id=$_POST['delline2'];
		delThem($banners[$id]['pic']);
		unset($banners[$id]);
		$opdata[$option]=serialize($banners);
		Control::set($opdata);
		updateCacheAll('options');
		$data['text']='已删除';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['showhide'])){
	$data=array();
	$data['action']='showhide';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	$key=isset($_POST['key'])?$_POST['key']:'';
	$id=isset($_POST['showhide'])?$_POST['showhide']:'';
	$aid=isset($_POST['aid'])?$_POST['aid']:'';
	if($ajcode==$_SESSION['ajcode']){
		if($dbtb=='say'){art_Model::setComment($aid,$dbtb);}
		action_Model::showOrHide($key,$id,$dbtb);
		updateCacheAll();
		$data['text']='更改成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
	
}

if(isset($_POST['showhide2'])){
	$data=array();
	$data['action']='showhide';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$option=isset($_POST['option'])?$_POST['option']:'';
	$key=isset($_POST['key'])?$_POST['key']:'';
	$id=isset($_POST['showhide2'])?$_POST['showhide2']:'';
	$banners=Control::get($option);
	if($ajcode==$_SESSION['ajcode']){
		$banners[$id]['show']=$key;
		$opdata[$option]=serialize($banners);
		Control::set($opdata);
		updateCacheAll('options');
		$data['text']='更改成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['addart'])){
	$db=Conn::getConnect();
	$data=array();
	$arr=array();
	$data['action']='addart';
	$id=$_POST['id'];
	$tp=$_POST['type'];

	if($id==''){
		$arr['author'] = UID;
		$arr['show'] = '0';
		if($tp=='a'){
			$arr['check'] = Control::get('art_check')=='1'?'0':'1';
		}else{$arr['check'] = 1;}
		$arr['filenum'] = $_POST['filenum'];
	}else{
		$arr['filenum'] = art_Model::getArtFileNum($id);
	}
	
	$arr['type'] = $tp;
	$arr['template'] = $_POST['template'];
	$arr['title'] = htmlspecialchars($_POST['title']);
	$arr['content'] = $_POST['content'];
	$getsite = $_POST['getsite'];
	if($getsite=='网络'){$geturl = htmlspecialchars($_POST['geturl']);}
	if($getsite=='原创'){$copyrights = $_POST['copyrights'];}
	$arr['getsite']=$getsite;
	$arr['geturl']=isset($geturl)?$geturl:'';
	$arr['copyrights']=isset($copyrights)?$copyrights:'1';
	$arr['pic'] = htmlspecialchars($_POST['pic']);
	$arr['excerpt'] = htmlspecialchars($_POST['excerpt']);
	$arr['saynum'] = $_POST['saynum'];
	
	$arr['s_id'] = $_POST['s_id'];
	$tagstr=htmlspecialchars($_POST['tags']);
	$arr['date'] = $_POST['date']==''?time():strtotime(htmlspecialchars($_POST['date']));
	$arr['alias'] = htmlspecialchars($_POST['alias']);
	$arr['key'] = htmlspecialchars($_POST['key']);
	$arr['password'] = htmlspecialchars($_POST['password']);
	$arr['eyes'] = htmlspecialchars($_POST['eyes']);
	$arr['goodnum'] = htmlspecialchars($_POST['goodnum']);
	$arr['badnum'] = htmlspecialchars($_POST['badnum']);
	$arr['sayok'] = $_POST['sayok'];
	$arr['mark'] = $_POST['mark'];
	$pathkey = $_POST['pathkey'];
	if($pathkey=='1'){$data['pathkey']=IDEA_URL;}
	
	if($data['id']=art_Model::addArt($arr,$id,$tagstr)){
		$data['text']='自动保存成功';
	}else{
		$data['text']='自动保存失败';
	}
	echo json_encode($data);
}

if(isset($_POST['showfile'])){
	$data=array();
	$data['action']='showfile';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$aid=isset($_POST['showfile'])?$_POST['showfile']:'';
	if($ajcode==$_SESSION['ajcode']){
		$data['txt']=art_Model::setFileList($aid);
		$data['text']='更改成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['upaid'])){
	$data=array();
	$data['action']='upaid';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$aid=isset($_POST['upaid'])?$_POST['upaid']:'';
	$type=isset($_POST['type'])?$_POST['type']:'';
	if($ajcode==$_SESSION['ajcode']){
		$upfile=new Upfile();
		$files=$upfile->getFileList($_FILES);
		if(!empty($files)){
			foreach($files as $key => $val){
				$data['url'][$key]=$upfile->upload($val,$aid,'',1);
			}
		}
		$data['txt']=art_Model::setFileList($aid);
		$data['text']='上传成功';
		$data['type']=$type;
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['dellist'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='dellist';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$lists=explode(',',$list);
		action_Model::delList($lists,$dbtb,'path');
		$data['text']='删除成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['draft'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='draft';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$key=$_POST['draft'];
		$lists=explode(',',$list);
		art_Model::setDraft($lists,$dbtb,$key);
		$data['text']='已放入草稿箱';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}


if(isset($_POST['release'])){
	$data=array();
	$data['action']='release';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$key=$_POST['release'];
		$lists=explode(',',$list);
		art_Model::setRelease($lists,$dbtb,$key);
		art_Model::setCheck($lists,$dbtb,$key);
		$data['text']='发布并审核成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['check'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='check';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$dbtb=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$key=$_POST['check'];
		$lists=explode(',',$list);
		art_Model::setCheck($lists,$dbtb,$key);
		$data['text']='审核成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['move'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='movesort';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$newsid=isset($_POST['move'])?$_POST['move']:0;
		$lists=explode(',',$list);
		sort_Model::moveArtsSort($lists,$newsid);
		$data['text']='移动成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['top'])){
	$data=array();
	$data['action']='settop';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:'';
		$topmark=isset($_POST['top'])?$_POST['top']:'0';
		$lists=explode(',',$list);
		art_Model::setArtTop($lists,$topmark);
		$data['text']='设置成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['userpic'])){
	$data=array();
	$data['action']='userpic';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$userpic=isset($_POST['userpic'])?$_POST['userpic']:'';
	$uid=isset($_POST['uid'])?$_POST['uid']:'';
	if($ajcode==$_SESSION['ajcode']){
		if($userpic!=''){delFileLine($userpic);}
		if($uid!=''){user_Model::delUserPhoto($uid);}
		$data['text']='删除成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['upfile'])){
	$data=array();
	$data['action']='upfile';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$up=isset($_POST['upfile'])?$_POST['upfile']:'';
	if($ajcode==$_SESSION['ajcode']){
		$upfile=new Upfile();
		$files=$upfile->getFileList($_FILES);
		if(!empty($files)){
			foreach($files as $key => $val){
				$data['url'][]=$upfile->upload($val,'',$up);
			}
		}
		$data['text']='上传成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}


if(isset($_POST['delsay'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='delsay';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:0;
		$lists=explode(',',$list);
		foreach($lists as $val){
			$sql1="SELECT `a_id` FROM `" . DB_PRE . "comment`  WHERE `id` = ".$val;
			$arr2=$db->getOnce($sql1);
			$sql="UPDATE `" . DB_PRE . "comment` SET `del`='0' WHERE `id`=".$val;
			$db->query($sql);
			if(!empty($arr2['a_id'])){
				$sql7="SELECT count(*) as sumnum FROM `". DB_PRE ."comment` WHERE `del`='1' and `a_id` = ".$arr2['a_id'].";";
				$arr=$db->getOnce($sql7);
				$sql8="UPDATE `". DB_PRE ."article` SET `saynum`='".$arr['sumnum']."' WHERE `id` = ".$arr2['a_id'].";";
				$db->query($sql8);
			}
		}
		$data['text']='删除成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['checksay'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='checksay';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:0;
		$checkid=$_POST['checksay'];
		$lists=explode(',',$list);
		foreach($lists as $val){
			$sql="UPDATE `" . DB_PRE . "comment` SET `show`='".$checkid."',`check`='".$checkid."' WHERE `id`=".$val.";";
			$db->query($sql);
		}
		$data['text']='审核成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['goodsay'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='goodsay';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['list'])?$_POST['list']:0;
		$goodid=$_POST['goodsay'];
		$lists=explode(',',$list);
		foreach($lists as $val){
			$sql="UPDATE `". DB_PRE ."comment` SET `mark`='".$goodid."' WHERE `id`=".$val.";";
			$db->query($sql);
		}
		$data['text']='修改成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['usertem'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='usertem';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$key=isset($_POST['key'])?$_POST['key']:'';
	if($ajcode==$_SESSION['ajcode']){
		$tem=$_POST['usertem'];
		$path = IDEA_ROOT .'/content/template/'.$tem.'/';
		if(is_dir($path)){
			$p = scandir($path);
			$fkey = 1;
			$filearr=array('404','function','header','footer','article','index','list','page');
			foreach($filearr as $val){
				$v = $val.".php";
				if(!in_array($v,$p)){$fkey = 0;}
			}
			if(!in_array('idea.jpg',$p)){$fkey = 0;}
			if($fkey == 1){
				$sql="UPDATE `" . DB_PRE ."options` SET `value` = '".$tem."' WHERE `key` = '".$key."';";
				$db->query($sql);
				updateCacheAll();
				$data['text']='模板更换成功';
			}else{
				$data['text']='更换失败，模板不完整或已损坏';
			}
		}else{
			$data['text']='更换失败，模板不存在';
		}
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['deltem'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='deltem';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$key=isset($_POST['db'])?$_POST['db']:'';
	if($ajcode==$_SESSION['ajcode']){
		$tem=$_POST['deltem'];
		$sql="SELECT * FROM `" . DB_PRE ."options` WHERE `key` = '".$key."';";
		$arr=$db->getlist($sql);
		if($arr[0]['value']==$tem){
			$data['text']='删除失败，模板正在使用';
		}else{
			$path = IDEA_ROOT .'/content/template/';
			$temlist=getDir($path);
			if(count($temlist)<2){
				$data['text']='删除失败，已经是最后一个模板了';
			}else{
				if(in_array($tem,$temlist)){
					$path2=$path.$tem.'/';
					delAllDirAndFile($path2);
					$data['text']='模板已成功删除';
					updateCacheAll('options');
				}else{
					$data['text']='删除失败，模板不存在，请刷新缓存后重试';
				}
			}
		}
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['delbak'])){
	$db=Conn::getConnect();
	$data=array();
	$data['action']='delbak';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$list=isset($_POST['delbak'])?$_POST['delbak']:'';
		$lists=explode(',',$list);
		foreach($lists as $vel){
			delThem(IDEA_ROOT .'/content/backup/'.urldecode($vel));
		}
		$data['text']='删除成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['plugin'])){//插件开启关闭
	$db=Conn::getConnect();
	$data=array();
	$data['action']='plugin';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$plugin=isset($_POST['plugin'])?$_POST['plugin']:'';
		$key=isset($_POST['key'])?$_POST['key']:0;
		$plugins=Control::get('plugins_list');
		$ee='操作失败';
		if($key){
			if(!in_array($plugin,$plugins)){$plugins[]=$plugin;$ee='已开启';}
		}else{
			if(in_array($plugin,$plugins)){$plugins=array_diff($plugins,array($plugin));$ee='已关闭';}
		}
		$opdata['plugins_list']=serialize($plugins);
		Control::set($opdata);
		updateCacheAll('options');
		$data['text']='插件'.$plugin.$ee;
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

if(isset($_POST['plugindel'])){//删除插件
	$db=Conn::getConnect();
	$data=array();
	$data['action']='plugin';
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	if($ajcode==$_SESSION['ajcode']){
		$plugin=isset($_POST['plugindel'])?$_POST['plugindel']:'';
		$pluginpath=IDEA_ROOT .'/content/plugins/'.$plugin.'/';
		delAllDirAndFile($pluginpath);
		$plugins=Control::get('plugins_list');
		if(in_array($plugin,$plugins)){$plugins=array_diff($plugins,array($plugin));}
		$opdata['plugins_list']=serialize($plugins);
		Control::set($opdata);
		updateCacheAll('options');
		$data['text']='插件'.$plugin.'删除成功';
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}

?>