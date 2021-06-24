<?php 
define('ROOT', dirname(dirname(dirname(__FILE__))));
include_once ROOT.'/include/core/amuker.php';
Checking::setSession();

/**
if(isset($_POST['type'])){
	$db=Conn::getConnect();
	$data=array();
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$tp=isset($_POST['type'])?$_POST['type']:'';
	$data['action']=$tp;
	$aid=isset($_POST['aid'])?$_POST['aid']:'';
	if($ajcode==$_SESSION['ajcode']){
		switch($tp){
			case 'good':
				$nowdate=date("Y-m-d");
				if(!empty($_SESSION['ids'])){$sslist=explode(",",$_SESSION['ids']);}else{$sslist=array();}
				if(isset($_SESSION['goodnum']) && $_SESSION['goodnum']==$nowdate && in_array($aid,$sslist)){
					$data['text']="您今天已经赞过啦";
				}else{
					if(!isset($_SESSION['goodnum']) || $_SESSION['goodnum']!=$nowdate){$_SESSION['ids']="";}
					$sql="SELECT * FROM ". DB_PRE ."article WHERE `id`=".$aid;
					$garr = $db->getOnce($sql);
					$num1=$garr['goodnum']+1;
					$sql2="UPDATE `". DB_PRE ."article` SET `goodnum` = '".$num1."' WHERE `id` =".$aid.";";
					if($db->query($sql2)){
						$_SESSION['goodnum']=$nowdate;
						$_SESSION['ids'].=$aid.",";
					}
					$data['text']="点赞成功";
				}
				break;
			case 'bad':
				$nowdate=date("Y-m-d");
				if(!empty($_SESSION['ids2'])){$sslist=explode(",",$_SESSION['ids2']);}else{$sslist=array();}
				if(isset($_SESSION['badnum']) && $_SESSION['badnum']==$nowdate && in_array($aid,$sslist)){
					$data['text']="您今天已经踩过啦";
				}else{
					if(!isset($_SESSION['badnum']) || $_SESSION['badnum']!=$nowdate){$_SESSION['ids2']="";}
					$sql="SELECT * FROM ". DB_PRE ."article WHERE `id`=".$aid;
					$garr = $db->getOnce($sql);
					$num2=$garr['badnum']+1;
					$sql2="UPDATE `". DB_PRE ."article` SET `badnum` = '".$num2."' WHERE `id` =".$aid.";";
					if($db->query($sql2)){
						$_SESSION['badnum']=$nowdate;
						$_SESSION['ids2'].=$aid.",";
					}
					$data['text']="成功踩了一脚";
				}
				break;
			case 'sc':
				//$uid=$_POST['uid'];
				$uid=UID;
				if($uid!=""){
					$sql = "SELECT * FROM `".DB_PRE ."user` WHERE `id`=".$uid;
					$sarr = $db->getOnce($sql);
					$collects=$sarr['collect'];
					if($collects!=""){$slist=explode(",",$collects);}else{$slist=array();}
					if(in_array("a|".$aid,$slist)){
						$data['text']="您已收藏该笔记";
					}else{
						if($collects==""){
							$mycoll="a|".$aid;
						}else{
							$mycoll=$collects.",a|".$aid;
						}
						$sql3="UPDATE `".DB_PRE ."user` SET `collect`='".$mycoll."' WHERE `id`=".$uid.";";
						$db->query($sql3);
						$data['text']="收藏成功";
					}
				}else{
					$data['text']="请登录后收藏";
				}
				break;
			case 'addfocus':
				$p_id=$_POST['p_id'];
				$b_id=$_POST['b_id'];
				$sql="SELECT * FROM `". DB_PRE ."focus` where `isok`='0' AND `pre_uid`='".$p_id."' AND `pro_uid`='".$b_id."'";
				$sarr = $db->getOnce($sql);
				if(!empty($sarr)){
					$sql4 = "UPDATE `".DB_PRE ."focus` SET `isok`='1',`outdate`='' WHERE `id`='".$sarr['id']."'";
				}else{
					$sql4 = "INSERT INTO `".DB_PRE ."focus` (`id`,`pre_uid`,`pro_uid`,`date`,`isok`,`outdate`) VALUES (NULL,'".$p_id."','".$b_id."','".time()."','1','')";
				}
				$arr = $db->query($sql4);
				$data['text']="关注成功";
				if($_POST['num']!=""){$data['focus1']=$_POST['num'];}
				break;
			case 'delfocus':
				$f_id=$_POST['f_id'];
				$sql5="UPDATE `".DB_PRE ."focus` SET `isok`='0',`outdate`='".time()."' WHERE `id`=".$f_id;
				$arr = $db->query($sql5);
				$data['text']="已取消关注";
				if($_POST['num']!=""){$data['focus1']=$_POST['num'];}
				break;
			default:break;
		}
	}else{
		$data['text']='非法操作';
	}
	updateCacheAll(array('sta','collects','collectsweek'));
	echo json_encode($data);
}

if(isset($_POST['readmore'])){
	$db=Conn::getConnect();
	$data=array();
	$ajcode=isset($_POST['ajcode'])?$_POST['ajcode']:'';
	$data['action']='readmore';
	$page=isset($_POST['page'])?$_POST['page']:'0';
	$num=isset($_POST['num'])?$_POST['num']:'1';
	if($ajcode==$_SESSION['ajcode']){
		$nArts=art_Model::getNewLog($num,(int)Control::get('art_num')+($page*$num),'','');
		$str='';
		foreach($nArts as $nval){
			$pic=$nval['pic']!=''?str_replace('../',IDEA_URL,$nval['pic']):getImg($nval['id']);
			$excerpt=$nval['excerpt']==''?strip_tags(htmlspecialchars_decode($nval['content'])):strip_tags($nval['excerpt']);
			$str.='<li>';
			$str.='<h2><a href="'.Url::log($nval["id"]).'">'.$nval['title'].'</a></h2>';
			$str.='<div class="c_li_cont">';
			$str.='<div class="c_li_img">';
			$str.='<p><a href="'.Url::log($nval['id']).'"><img src="'.$pic.'" ></a></p>';
			$str.='</div>';
			$str.='<div class="c_li_des">';
			$str.='<p>'.mb_substr(trim($excerpt),0,180).'...<a href="'.Url::log($nval['id']).'">阅读全文</a></p>';
			$str.='</div>';
			$str.='<div class="clear"></div>';
			$str.='</div>';
			$str.='<div class="c_li_info">';
			$str.='<div class="left"><a href="'.Url::author($nval['author']).'">by '.user_Model::getUserName($nval['author']).'</a></div>';
			$str.='<div class="right">';
			$str.='<a href="'.Url::sort($nval['s_id']).'">'.sort_Model::getSortName($nval['s_id']).'</a>';
			$str.='<a href="'.Url::log($nval['id']).'#comments">'.$nval['saynum'].' 评论</a>';
			$str.='<a href="'.Url::log($nval['id']).'">'.art_Model::getCollects($nval['id']).' 收藏</a>';
			$str.='<a href="'.Url::log($nval['id']).'">'.$nval['goodnum'].' 攒</a>';
			$str.='<a href="'.Url::log($nval['id']).'">'.$nval['eyes'].' 浏览</a>';
			$str.='</div>';
			$str.='<div class="clear"></div>';
			$str.='</div>';
			$str.='</li>';
		}
		$data['text']=$str;
	}else{
		$data['text']='非法操作';
	}
	echo json_encode($data);
}
**/





?>