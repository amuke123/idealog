<?php
/**
***用户信息
**/
class user_Model{
	public static function getInfo($uid=UID,$option=''){//获取指定用户信息，默认获取当前登录用户
		$mysql = Conn::getConnect();
		$cxop = $option==''?'*':'`'.$option.'`';
		$data = array();
		$sql = "SELECT ".$cxop." FROM `". DB_PRE ."user` where `id`='". $uid ."'";
		$row = $mysql->getOnce($sql);
		$data=$row;
		if($option==''){
			$name=empty($data['nickname'])?$data['username']:$data['nickname'];
			$artnum = art_Model::getUserArtNum($uid);
			$data['artnum']=$artnum;
			$data['name']=$name;
			return $data;
		}else{
			return $data[$option];
		}
	}
	public static function setLastdate($uid){
		$mysql = Conn::getConnect();
		$sqlst="UPDATE `". DB_PRE ."user` SET `lastdate`='".time()."' WHERE `id`=".$uid;
		$mysql->query($sqlst);
	}
	
	public static function getUsersIofo($startnum,$pagenum,$examine,$state){//获取指定用户的用户信息
		$mysql = Conn::getConnect();
		$sql = "SELECT `id` FROM `". DB_PRE ."user` WHERE `username`!='' ";
		if($examine=='0'){$sql .= " AND `check`='0' ";}
		if($state=='0'){$sql .= " AND `check`='1' AND `state` != '0' ";}
		$sql .= " LIMIT ".$startnum.",".$pagenum;
		$row = $mysql->getlist($sql);
		return $row;
	}
	
	public static function getUsersNum($examine,$state){//获取所有用户数
		$mysql = Conn::getConnect();
		$sql = "SELECT COUNT(*) AS total FROM `". DB_PRE ."user` WHERE `username` != '' ";
		if($examine=='0'){$sql .= " AND `check`='0' ";}
		if($state=='0'){$sql .= " AND `check`='1' AND `state` != '0'";}
		$row = $mysql->getOnce($sql);
		return $row['total'];
	}
	
	public static function delUserPhoto($uid=''){
		$mysql = Conn::getConnect();
		$sqlst="UPDATE `". DB_PRE ."user` SET `photo`='' WHERE `id`=".$uid;
		$mysql->query($sqlst);
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
			$sqladd="INSERT INTO `". DB_PRE .$dbtb."` (`id`,`check`,`role`,".$keystr.") VALUES (NULL,'1','writer',".$valstr.");";
			$text="创建失败";
		}else{
			$sqladd="UPDATE `". DB_PRE .$dbtb."` SET ".$upstr." WHERE `id`=".$sid;
			$text="修改失败";
		}
		if(!$db->query($sqladd)){
			echo "<script>alert('".$text."');</script>";
			return 0;
		}else{
			updateCacheAll();return 1;
		}
	}
	
	public static function getUserName($uid){
		$reset=self::getInfo($uid);
		return $reset['name'];
	}
	
	public static function getUserPhoto($uid,$y=''){
		$photo=self::getInfo($uid,'photo');
		if(isset($photo)){
			if($y==''){
				return $photo!=''?str_replace('../',IDEA_URL,$photo):IDEA_URL .ADMIN_TYPE .'/view/static/images/avatar.jpg';
			}else{
				return $photo!=''?str_replace('../',IDEA_URL,$photo):'';
			}
		}else{
			return IDEA_URL .ADMIN_TYPE .'/view/static/images/avatar.jpg';
		}
	}
	
	public static function getAdminsAllNameAndEmail(){
		$mysql = Conn::getConnect();
		$sql = "SELECT `username`,`nickname`,`email` FROM `". DB_PRE ."user` WHERE `role`='admin' ";
		$row = $mysql->getlist($sql);
		return $row;
	}
	
/**
	
	
	
	
	public static function getUserList($num=9){//获取指定个数的正常用户信息
		$mysql = Conn::getConnect();
		$sql = "SELECT * FROM `". DB_PRE ."user` WHERE `username`!='' AND `check`='1' AND `state`='0' ORDER BY `lastdate` DESC LIMIT 0,".$num;
		$row = $mysql->getlist($sql);
		return $row;
	}
	
	
	
	public static function getUserDes($uid){
		$reset=self::getInfo($uid);
		return $reset['description'];
	}
	
	
	
	
	
	
	
	public static function getCollect($pagenum,$startnum,$ids=''){//获取收藏列表
		$lists="";
		$data=array();
		if($startnum<count($ids)){
			$lists=array_slice($ids,$startnum,$pagenum);
			foreach($lists as $val){
				$data[]=art_Model::getOnceArt($val);
			}
		}
		return $data;
	}
	
	public static function getStrToId($liststr){//获取收藏字符串转id列表
		$lists=explode(",",$liststr);
		$data=array();
		foreach($lists as $value){
			$line=explode("|",$value);
			if($line[0]=="a"){$data[]=$line[1];}
		}
		$data=array_reverse($data);
		return $data;
	}

	public static function getGz($author){//获取关注列表
		$db = Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."focus` where `isok`='1' AND `pre_uid` =".$author;
		$focus1=$db->getlist($sql);
		return $focus1;
	}
	

	public static function getFs($author){//获取粉丝列表
		$db = Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."focus` where `isok`='1' AND `pro_uid` =".$author;
		$focus2=$db->getlist($sql);
		return $focus2;
	}

	public static function isGz($foc,$id){//判断是否被您关注
		$key=0;
		if(count($foc)>0){
			foreach($foc as $val){
				if($val['pre_uid']==$id){
					$key=$val['id'];
				}
			}
		}
		return $key;
	}
	
	public static function isGz2($foc,$id){//判断是否被您关注
		$key=0;
		if(count($foc)>0){
			foreach($foc as $val){
				if($val['pro_uid']==$id){
					$key=$val['id'];
				}
			}
		}
		return $key;
	}
	
    static function isAliasExist($alias, $uid = '') {//判断个性域名是否存在 $uid 兼容更新作者资料时用户名未变更情况
		$db=Conn::getConnect();
        if(empty($alias)){return FALSE;}
		//if($alias=="set"||$alias=="company"||$alias=="add"){return false;}
		if(!ctype_alpha(substr($alias,0,1))){return false;}
		if(!ctype_alnum($alias)){return false;}
		$subSql = $uid!='' ? ' and `id`!='.$uid : '';
		$sql="SELECT COUNT(*) AS `total` FROM `". DB_PRE ."user` WHERE `diyurl`='".$alias."' ".$subSql;
		//echo $sql;
		$data = $db->getOnce($sql);
		if($data['total']>0){return false;}else{return true;}
    }
	
	
	**/
	
	
}
?>