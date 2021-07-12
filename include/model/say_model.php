<?php
/**
***评论信息
**/
class say_Model{
	
	static function getSays($artid,$sqltem,$startnum,$pagenum,$del='1',$order='DESC',$top='',$tid=''){
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."comment` WHERE 1=1 ";
		if($top!=''){$sql.=" AND `top_id`='".$top."' ";}
		if($del=='1'){$sql.=" AND `del`='".$del."' ";}else{$sql.=" AND `show`='1' AND `check`='1' ";}
		if($artid!='0'){$sql.=" AND `a_id`='".$artid."' ";}
		if($tid!=''){$sql.=" AND `t_id`='".$tid."' ";}
		$sql.=$sqltem;
		$sql.=" ORDER BY `date` ".$order.",`id` ".$order." ";
		if($pagenum>0){$sql.=" LIMIT ".$startnum.",".$pagenum;}
		
		$sayss=$db->getlist($sql);
		$says=array();
		foreach($sayss as $vals){
			$says[$vals['id']]=$vals;
		}
		return $says;
	}
	
	static function getSayNum($artid='0',$sqltem='',$del='1',$show='',$topid=''){
		$db=Conn::getConnect();
		$sql2="SELECT count(*) as total FROM `" . DB_PRE . "comment` WHERE 1=1 ";
		if($show!=''){$sql2.=" AND `show`='1' AND `check`='1' ";}
		if($del=='1'){$sql2.=" AND `del`='".$del."' ";}
		if($topid!=''){$sql2.=" AND `top_id`='0' ";}
		if($artid!='0'){$sql2.=" AND `a_id`='".$artid."' ";}else{$sql2.=" AND `a_id`<>'".$artid."' ";}
		$sql2.=$sqltem;
		$counts=$db->getOnce($sql2);
		return $counts['total'];
	}
	
	static function getUname($uid){
		$userinfo=user_Model::getInfo($uid);
		return $userinfo['name'];
	}
	
	static function getTopidUname($topid){
		$db=Conn::getConnect();
		$sql="SELECT `posterid` FROM `". DB_PRE ."comment` WHERE `id` = ".$topid;
		$counts=$db->getOnce($sql);
		$userinfo=user_Model::getInfo($counts['posterid']);
		return $userinfo['name'];
	}
	
	static function getSays2($artid,$sqltem,$startnum,$pagenum,$del='1',$order='DESC',$tid=''){
		$comments=self::getSays($artid,$sqltem,$startnum,$pagenum,$del,$order,'0');
		foreach($comments as $key => $value){
			$comments[$key]['children']=self::getSays($artid,$sqltem,$startnum,$pagenum,$del,'ASC','',$key);
		}
		return $comments;
	}
	
	
	/**
	static function getTipsSay($num,$sqlpro='',$order=''){
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."comment` WHERE `del`='1' AND `check`='1' AND `show`='1' ";
		$sql.=$sqlpro;
		$sql.=" ORDER BY ".$order."`date` DESC limit 0,".$num;
		$says=$db->getlist($sql);
		return $says;
	}
	
	
	static function isCommentExist($aid,$name,$content){
		$db=Conn::getConnect();
		$data = $db->getOnce("SELECT COUNT(*) AS `total` FROM `".DB_PRE ."comment` WHERE `a_id`='".$aid."' AND (`posterid`='".UID ."' OR `name`='".$name."') AND `content`='".$content."'");
		return intval($data['total'])>0?true:false;
	}
	static function getSayTid($pid){
		$db=Conn::getConnect();
		$data=$db->getOnce("SELECT `t_id` FROM `". DB_PRE ."comment` WHERE `id`='".$pid."'");
		return $data['t_id'];
	}
	static function updateCommentNum($aid) {
		$db=Conn::getConnect();
        if(is_array($aid)){
            foreach($aid as $val){self::updateCommentNum($val);}
        }else{
            $sql="SELECT count(*) as `total` FROM `".DB_PRE ."comment` WHERE `a_id`='".$aid."' AND `show`='1' AND `check`='1'";
            $res=$db->getOnce($sql);
            $comNum=$res['total'];
            $db->query("UPDATE `".DB_PRE ."article` SET `saynum`='".$comNum."' WHERE `id`='".$aid."'");
            return $comNum;
        }
    }
	static function addComment($name,$content,$mail,$url,$aid,$pid,$tid){
		$db=Conn::getConnect();
        $ipaddr = getIp();
        $utctimestamp=time();

        $say_check=Control::get('say_check')?0:1;
        $hide=ROLE==ROLE_VISITOR?$say_check:'1';
        $sql="INSERT INTO `".DB_PRE ."comment` (`id`,`a_id`,`top_id`,`t_id`,`date`,`posterid`,`name`,`content`,`mail`,`url`,`ip`,`show`,`check`,`mark`,`good`,`bad`,`del`) VALUES (NULL,'".$aid."','".$pid."','".$tid."','".$utctimestamp."','".UID ."','".$name."','".$content."','".$mail."','".$url."','".$ipaddr."','1','".$hide."','0','0','0','1')";
        $ret = $db->query($sql);

        if($hide){
            self::updateCommentNum($aid);
            emDirect(Url::log($aid).'#comments');
        }else{
           mkMsg('评论发表成功，请等待管理员审核',Url::log($aid));
        }
		updateCacheAll(array('sta','newArts','goods','eyes','collect'));
    }
	
	static function isNameAndMailValid($name,$mail){
        $user_cache = user_Model::getUsersAllNameAndEmail();
        foreach($user_cache as $user) {
            if($user['username']==$name||$user['nickname']==$name||($mail!=''&&$user['email']==$mail)){return false;}
        }
        return true;
    }
	
	static function isCommentTooFast(){
		$db=Conn::getConnect();
        $ipaddr=getIp();
        $utctimestamp=time()-Control::get('say_time');
        $sql = 'select count(*) as `total` from `'.DB_PRE ."comment` where `date`>".$utctimestamp." AND ip='".$ipaddr."'";
        $row = $getOnce($sql);
        return intval($row['total'])>0?true:false;
    }
	
	static function setCommentCookie($name,$mail,$url) {
        $cookietime = time() + 31536000;
        setcookie('commentposter',$name,$cookietime);
        setcookie('postermail',$mail,$cookietime);
        setcookie('posterurl',$url,$cookietime);
    }
	
	
	
	
	
	
	**/
	
}

?>