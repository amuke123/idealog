<?php
/**
***系统控制页面
**/
class action_Model{
	static function actionFc($do,$site_title){
		$doFc = 'fc_'.$do;
		self::$doFc($site_title);
	}
	static function fc_login($site_title){
		$site_title='登录-'.$site_title;
		$username=$_POST['username'];
		$password=$_POST['password'];
		$code=isset($_POST['code'])?$_POST['code']:'';
		$save=isset($_POST['save'])?$_POST['save']:'';
		Checking::getLogin($username,$password,$code,$save);
	}
	static function fc_register($site_title){
		$site_title='注册-'.$site_title;
		$dataarr=array();
		$sendId=isset($_POST['sendid'])?$_POST['sendid']:'';
		$code=isset($_POST['code'])?$_POST['code']:'';
		$password=isset($_POST['password'])?$_POST['password']:'';
		$dataarr['role']='writer';
		$dataarr['date']=time();
		$dataarr['password']=Checking::hashjm(Checking::jm($password));
		if(Checking::checkSendId($sendId)){
			echo "<script>alert('".$sendid." 已注册，请登录！');location.href='".Url::getActionUrl('login')."';</script>";exit;
		}
		$sendType=Checking::checkSendType($sendId);
		if(Checking::checkCode($code,$sendId)){
			$dataarr[$sendType]=$sendId;
			$dataarr[$sendType.'ok']='1';
			Checking::registerUser($dataarr);
		}else{
			echo "<script>alert('验证码错误');window.history.go(-1);</script>";exit;
		}
	}
	static function fc_reset($site_title){
		$site_title='密码重置-'.$site_title;
		$sendId=isset($_POST['sendid'])?$_POST['sendid']:'';
		$code=isset($_POST['code'])?$_POST['code']:'';
		$password=isset($_POST['password'])?$_POST['password']:'';
		$pwd=Checking::hashjm(Checking::jm($password));
		if(!Checking::checkSendId($sendId)){
			echo "<script>alert('未检测到 ".$sendid." 相关账号，请注册！');location.href='".Url::getActionUrl('register')."';</script>";exit;
		}
		$sendType=Checking::checkSendType($sendId);
		if(Checking::checkCode($code,$sendId)){
			Checking::resetUser($sendType,$sendId,$pwd);
		}else{
			echo "<script>alert('验证码错误');window.history.go(-1);</script>";exit;
		}
	}
	static function fc_goout($site_title){
		$site_title='退出-'.$site_title;
		Checking::LoginOut();
	}
	static function fc_setcache($site_title){
		$site_title='更新缓存-'.$site_title;
		updateCacheAll();
		echo "<script>alert('缓存更新成功！');window.history.go(-1);</script>";
	}
	
	static function fc_comments($site_title){
		$site_title='回复-'.$site_title;
		Checking::setSession();
		$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
        $content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
        $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
        $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
        $imgcode = isset($_POST['imgcode']) ? addslashes(trim(strtolower($_POST['imgcode']))):'';
        $aid = isset($_POST['aid']) ? intval($_POST['aid']) : -1;
        $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
		if(UID!=0){
            $user_cache=user_Model::getInfo();
            $name = addslashes($user_cache['name']);
            $mail = addslashes($user_cache['email']);
            $url = addslashes(Url::author(UID));
        }

        if($url && strncasecmp($url,'http',4)){$url = 'http://'.$url;}
		say_Model::setCommentCookie($name,$mail,$url);
		if(Control::get('sayok')==0||art_Model::getOnceArt($aid,'sayok')==0){
			mkMsg('评论失败：该文章已关闭评论');
		}else if(say_Model::isCommentExist($aid,$name,$content)===true){
            mkMsg('评论失败：已存在相同内容评论');
        }else if(ROLE==ROLE_VISITOR&&say_Model::isCommentTooFast()===true){
            mkMsg('评论失败：您提交评论的速度太快了，请稍后再发表评论');
        }else if(empty($name)){
            mkMsg('评论失败：请填写姓名');
        }else if(strlen($name) > 20){
            mkMsg('评论失败：输入的姓名太长');
        }else if($mail!=''&&!checkMail($mail)){
            mkMsg('评论失败：邮件地址不符合规范');
        }else if(UID==0&&say_Model::isNameAndMailValid($name,$mail)===false){
            mkMsg('评论失败：禁止使用管理员昵称或邮箱评论');
        }else if(!empty($url)&&preg_match("/^(http|https)\:\/\/[^<>'\"]*$/",$url)==false) {
            mkMsg('评论失败：主页地址不符合规范','javascript:history.back(-1);');
        }else if(empty($content)){
            mkMsg('评论失败：请填写评论内容');
        }else if(strlen($content)>8000){
            mkMsg('评论失败：内容不符合规范');
        }else if(Control::get('say_chinese')=='1'&&!preg_match('/[\x{4e00}-\x{9fa5}]/iu',$content)){
            mkMsg('评论失败：评论内容需包含中文');
        }else if(Control::get('say_code')=='1'&&(empty($imgcode)||$imgcode!==$_SESSION['code'])){
			//echo $imgcode."--"; echo $_SESSION['code'];
            mkMsg('评论失败：验证码错误');
        }else{
            $_SESSION['code']=null;
			if($pid!=0){
				$tid_tem=say_Model::getSayTid($pid);
				$tid=$tid_tem!="0"?$tid_tem:$pid;
			}else{
				$tid=0;
			}
            say_Model::addComment($name,$content,$mail,$url,$aid,$pid,$tid);
        }
		
	}
	
	static function addLine($adddata,$dbtb,$sid=''){//创建
		$db=Conn::getConnect();
		$keystr='';
		$valstr='';
		$upstr='';
		foreach($adddata as $keys => $vals){
			$keystr.="`".$keys."`,";
			$valstr.="'".$vals."',";
			$upstr.="`".$keys."`='".$vals."',";
		}
		$keystr=trim($keystr,',');
		$valstr=trim($valstr,',');
		$upstr=trim($upstr,',');
		if($sid==''){
			$sqladd="INSERT INTO `". DB_PRE .$dbtb."` (`id`,".$keystr.") VALUES (NULL,".$valstr.");";
			$text="创建分类失败";
		}else{
			$sqladd="UPDATE `". DB_PRE .$dbtb."` SET ".$upstr." WHERE `id`=".$sid;
			$text="编辑失败";
		}
		if(!$db->query($sqladd)){
			echo "<script>alert('".$text."');</script>";return 0;
		}else{
			updateCacheAll();return 1;
		}
	}
	
	static function setIndex($sids,$indexs,$dbtb){//更新index
		$db=Conn::getConnect();
		foreach($sids as $key=>$value){
			$sql="UPDATE `". DB_PRE .$dbtb."` SET `index`='".$indexs[$key]."' WHERE `id` = ".$value.";";
			$db->query($sql);
		}
	}
	
	static function delFile($id,$dbtb,$p=''){//删除图片
		$db=Conn::getConnect();
		if($p=='path'){
			$sql2="SELECT `path` FROM `". DB_PRE ."file` WHERE `a_id` = '".$id."';";
			$arr=$db->getlist($sql2);
			foreach($arr as $value){
				if($value['path']!=''){
					delFileLine($value['path']);
				}
			}
		}else{
			$sql="SELECT `pic` FROM `". DB_PRE .$dbtb."` WHERE `id` = ".$id.";";
			$arr=$db->getOnce($sql);
			if($arr['pic']!=''){
				delFileLine($arr['pic']);
			}
		}
	}
	
	static function delLine($id,$dbtb){//删除数据
		$db=Conn::getConnect();
		$sql="delete from `". DB_PRE .$dbtb."` where `id`= ".$id.";";
		$db->query($sql);
	}
	
	static function array_order($data,$index='index',$order='asc',$odarr=array()){//二维数组排序，$index排序字段，$order排序 asc 升序 desc 降序,$odarr 顺序数组
		if(empty($odarr)){foreach($data as $k=>$v){$odarr[$k]=$v[$index];}}
		if($order=='asc'){asort($odarr);}
		if($order=='desc'){arsort($odarr);}
		$newdata=array();
		foreach($odarr as $odk => $odv){
			$newdata[]=$data[$odk];
		}
		return $newdata;
	}
	
	static function pagelist($artnumb,$pages,$pageid,$urlpre,$txtsub,$urlsub,$artid='0',$pro=''){
		//echo $artid;
		if($artid!='0'){$astr='&artid='.$artid;}else{$astr='';}
		$str='';
		if($pages>1){
			if($pages<10){
				for($i=1;$i<=$pages;$i++){
					if($i==$pageid){
						$str .= '<span>'.$i.'</span>';
					}else{
						$str .= '<a href="'.$urlpre.$i.$urlsub.$astr.$pro.'">'.$i.'</a>';
					}
				}
			}else{
				if($pageid=='1'){$str .= '<span>1</span>';}else{$str .= '<a href="'.$urlpre.'1">1</a>';}
				if(($pageid-4)>1){$str .= ' ... ';}
				if(($pageid-4)>1){$pstart=($pageid-3);$bc1=0;}else{$pstart=2;$bc1=$pageid-5;}
				if(($pageid+4)<$pages){$pend=($pageid+3);$bc2=0;}else{$pend=($pages-1);$bc2=($pageid-$pages)+4;}
				for($j=($pstart-$bc2),$tj=($pend-$bc1);$j<=$tj;$j++){
					if($j==$pageid){
						$str .= '<span>'.$j.'</span>';
					}else{
						$str .= '<a href="'.$urlpre.$j.$urlsub.$astr.$pro.'">'.$j.'</a>';
					}
				}
				if(($pageid+4)<$pages){$str .= ' ... ';}
				if($pageid==$pages){$str .= '<span>'.$pages.'</span>';}else{$str .= '<a href="'.$urlpre.$pages.$urlsub.$astr.$pro.'">'.$pages.'</a>';}
			}
		}
		$str .= '(有 '.$artnumb.' '.$txtsub.')';
		return $str;
	}
	
	static function delList($lists,$dbtb,$p=''){//删除多条数据
		$db=Conn::getConnect();
		foreach($lists as $val){
			$sql1="SELECT `tags` FROM `". DB_PRE .$dbtb."` WHERE `id` = '".$val."';";
			$arr1=$db->getOnce($sql1);
			$tagstr=$arr1['tags'];
			tag_Model::upArtTags($tagstr,$val);
			self::delFile($val,$dbtb,$p);
			$sql="delete from `". DB_PRE .$dbtb."` where `id`=".$val;
			$db->query($sql);
		}
	}
	
	static function showOrHide($key,$id,$dbtb){//显示和隐藏
		$db=Conn::getConnect();
		$sql="UPDATE `". DB_PRE .$dbtb."` SET `show`='".$key."' WHERE `id` = ".$id.";";
		$db->query($sql);
	}
	

	
}

?>