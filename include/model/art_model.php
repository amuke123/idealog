<?php
/**
***文章和页面信息
**/
class art_Model{
	
	static function getUserArtNum($uid='',$show=''){//获取文章数，可指定用户//$uid 指定用户//$show 正常显示的
		$db=Conn::getConnect();
		$sql="SELECT COUNT(*) AS total FROM `". DB_PRE ."article` WHERE `type`='a' ";
		if($show!=''){$sql .= " AND `show`='1' AND `check`='1' ";}
		if($uid!=''){$sql .= " AND `author`='".$uid."'";}
		$row=$db->getOnce($sql);
		return $row['total'];
	}
	
	static function moveSort($sortid,$newsid=0){//更换一个分类下的笔记分类
		$db=Conn::getConnect();
		$sql="SELECT `id` FROM `". DB_PRE ."article` WHERE `s_id` = '".$sortid."';";
		$arts=$db->getlist($sql);
		foreach($arts as $val){
			$sqlok="UPDATE `". DB_PRE ."article` SET `s_id`='".$newsid."' WHERE `id` = ".$val['id'].";";
			$db->query($sqlok);
		}
	}
	
	static function getOnceArt($aid){//获取单篇笔记
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."article` WHERE `id` =".$aid;
		return $art=$db->getOnce($sql);
	}
	
	static function getArtFileNum($aid){//获取笔记附件数
		$db=Conn::getConnect();
		$sql="SELECT COUNT(*) AS total  FROM `". DB_PRE ."file` WHERE `top_id`='0' and `a_id` = ".$aid.";";
		$file=$db->getOnce($sql);
		return $file['total'];
	}
	
	static function addArt($data,$id='',$tagstr=''){//创建笔记/单页
		$db=Conn::getConnect();
		$keystr="";
		$valuestr="";
		$upstr="";
		foreach($data as $key => $value){
			$keystr.="`".$key."`,";
			$valuestr.="'".$value."',";
			$upstr.="`".$key."`='".$value."',";
		}
		$keystr=trim($keystr,',');
		$valuestr=trim($valuestr,',');
		$upstr=trim($upstr,',');
		if($id==""){
			$sql="INSERT INTO `". DB_PRE ."article` (`id`,`tags`,".$keystr.") VALUES (NULL,'',".$valuestr.")";
		}else{
			$sql="UPDATE `". DB_PRE ."article` SET ".$upstr." WHERE `id`=".$id;
		}
		//echo $sql;
		if($db->query($sql)){
			$dataid=$id==""?$db->last_insert_id():$id;
			if($dataid!=''&&$tagstr!=''){tag_Model::getTagsId($tagstr,$dataid);}
			$kk=$dataid;
		}else{
			$kk=0;
		}
		user_Model::setLastdate(UID);
		updateCacheAll();
		return $kk;
	}
	
	static function getFiles($aid,$tp=''){//获取附件
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."file` WHERE `top_id`='0' and `a_id` = ".$aid;
		if($tp!=''){$sql.=" AND `type` LIKE '".$tp."/%'";}
		return $files=$db->getlist($sql);
	}
	
	static function setFileList($aid){//显示附件
		$files=self::getFiles($aid);
		$txt='';
		if(is_array($files)){
			foreach($files as $fval){
				$fvalarr=explode('/',$fval['type']);
				if($fvalarr[0]=='image'){
					$txt.='<a href="javascript:setImages(\''.$fval['path'].'\',\''.IDEA_URL .'\')"><img src="'.str_replace("../",IDEA_URL,$fval['path']).'" /></a>';
				}
			}
		}
		return $txt;
	}
	
	static function getArtList($draft,$examine,$rolestr,$keyword,$startnum,$pagenum){//笔记列表
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."article` WHERE `type`='a' ";
		$sqltem="";
		if($draft=='0'){
			$sqltem.=" AND `show`='".$draft."' ".$rolestr;
		}
		if($examine=='0'){
			$sqltem.=" AND `show`='".$draft."' AND `check`='".$examine."' ".$rolestr;
		}
		if($draft=='1' && $examine=='1'){
			$sqltem.=" AND `show`='".$draft."' AND `check`='".$examine."' ".$rolestr;
		}
		if($keyword!=''){
			$sqltem.=" AND `title` LIKE '%".$keyword."%'";
		}
		$sql.=$sqltem;
		$sql.=" ORDER BY `date` DESC LIMIT ".$startnum.",".$pagenum;
		return $arts=$db->getlist($sql);
	}
	
	static function getArtsNum($draft,$examine,$rolestr,$keyword){//搜索
		$db=Conn::getConnect();
		$sql2="SELECT count(*) as total FROM `". DB_PRE ."article` WHERE `type`='a' ";
		$sqltem="";
		if($draft=='0'){
			$sqltem.=" AND `show`='".$draft."' ".$rolestr;
		}
		if($examine=='0'){
			$sqltem.=" AND `show`='".$draft."' AND `check`='".$examine."' ".$rolestr;
		}
		if($draft=='1' && $examine=='1'){
			$sqltem.=" AND `show`='".$draft."' AND `check`='".$examine."' ".$rolestr;
		}
		if($keyword!=''){
			$sqltem.=" AND `title` LIKE '%".$keyword."%'";
		}
		$sql2.=$sqltem;
		$counts=$db->getOnce($sql2);
		return $counts['total'];
	}
	
	static function setDraft($lists,$dbtb,$key){//草稿箱/隐藏
		$db=Conn::getConnect();
		foreach($lists as $val){
			$sql="UPDATE `". DB_PRE .$dbtb."` SET `show`='".$key."' WHERE `id` = ".$val.";";
			$db->query($sql);
		}
	}
	
	static function setRelease($lists,$dbtb,$key){//发布
		$db=Conn::getConnect();
		foreach($lists as $val){
			$sql="UPDATE `". DB_PRE .$dbtb."` SET `show`='".$key."' WHERE `id` = ".$val.";";
			$db->query($sql);
		}
	}
	
	static function setCheck($lists,$dbtb,$key){//审核
		$db=Conn::getConnect();
		foreach($lists as $val){
			$sql="UPDATE `". DB_PRE .$dbtb."` SET `check`='".$key."' WHERE `id` = ".$val.";";
			$db->query($sql);
		}
	}
	
	static function setArtTop($lists,$topmark){//设置置顶
		$db=Conn::getConnect();
		foreach($lists as $val){
			$sql2="SELECT `mark` FROM `". DB_PRE ."article` WHERE `id` = ".$val.";";
			$arr=$db->getOnce($sql2);
			$marks=explode(',',$arr['mark']);
			if(!in_array($topmark,$marks)){
				$mark=$topmark=='0'?'':$arr['mark'].",".$topmark;
				$mark=trim($mark,",");
				$sql="UPDATE `" . DB_PRE . "article` SET `mark` = '".$mark."' WHERE `id` = ".$val.";";
				$db->query($sql);
			}
		}
	}
	
	static function getPages(){//获取全部单页并格式化
		$pages=self::getPage();
		$pagearr=array();
		foreach($pages as $pagesval){
			$pagearr[$pagesval['id']]=$pagesval;
		}
		return $pagearr;
	}
	
	static function getPage($pid=''){//获取单页
		$db=Conn::getConnect();
		$sql1="SELECT * FROM `" . DB_PRE . "article` WHERE `type`='p'";
		if($pid!=''){$sql1.=" AND `id`=".$pid;}
		$sql1.=" ORDER BY `date` DESC";
		return $pages=$db->getlist($sql1);
	}
	
	static function getArtName($aid){//获取笔记名称
		$art=self::getOnceArt($aid);
		return $art['title'];
	}
	
	static function setComment($aid,$dbtb){//更换笔记评论数
		$db=Conn::getConnect();
		$sql1="SELECT count(*) as sumnum FROM `". DB_PRE .$dbtb."` WHERE `del`='1' and `a_id` = ".$aid.";";
		$arr=$db->getOnce($sql1);
		$sql2="UPDATE `". DB_PRE ."article` SET `saynum`='".$arr['sumnum']."' WHERE `id` = ".$aid.";";
		$db->query($sql2);
	}
	
	static function getlogArt($aid){//笔记详情信息
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."article` WHERE `id` =".$aid;
		$art=$db->getOnce($sql);
		$data=array();
		if(!empty($art)){
			$data['art_title']=$art['title'];
			$data['art_date']=$art['date'];
			$data['art_content']=$art['content'];
			$data['art_excerpt']=$art['excerpt'];
			$data['art_key']=$art['key'];
			$data['art_alias']=$art['alias'];
			$data['art_uid']=$art['author'];
			$data['art_author']=user_Model::getUserName($art['author']);
			$data['art_authorUrl']=user_Model::getUserPhoto($art['author']);
			$data['art_sortid']=$art['s_id'];
			$data['art_sortName']=sort_Model::getSortName($art['s_id']);
			$data['art_type']=$art['type'];
			$data['art_eyes']=$art['eyes'];
			$data['art_goodnum']=$art['goodnum'];
			$data['art_badnum']=$art['badnum'];
			$data['art_saynum']=$art['saynum'];
			$data['art_filenum']=$art['filenum'];
			$data['art_mark']=$art['mark'];
			$data['art_copyrights']=$art['copyrights'];
			$data['art_show']=$art['show'];
			$data['art_sayok']=$art['sayok'];
			$data['art_template']=$art['template'];
			$data['art_password']=$art['password'];
			$data['art_pic']=$art['pic'];
			$data['art_tags']=$art['tags'];
			$data['art_check']=$art['check'];
			$data['art_getsite']=$art['getsite'];
			$data['art_geturl']=$art['geturl'];
		}
		return $data;
	}
	
	static function upEyes($aid){//阅读量
		$db=Conn::getConnect();
        $db->query("UPDATE `". DB_PRE ."article` SET eyes=eyes+1 WHERE `id`=".$aid);
    }
	
	static function getNeighbour($date){//上下篇
		$neighbor = array();
		$db=Conn::getConnect();
        $neighbor['prev']=$db->getOnce("SELECT `title`,`id` FROM `". DB_PRE ."article` WHERE `date`<".$date." and `show`='1' and `check`='1' and `type`='a' ORDER BY `date` DESC LIMIT 0,1");
        $neighbor['next']=$db->getOnce("SELECT `title`,`id` FROM `". DB_PRE ."article` WHERE `date`>".$date." and `show`='1' and `check`='1' and `type`='a' ORDER BY `date` LIMIT 0,1");
        if($neighbor['next']){$neighbor['next']['title']=htmlspecialchars($neighbor['next']['title']);}
        if($neighbor['prev']){$neighbor['prev']['title']=htmlspecialchars($neighbor['prev']['title']);}
        return $neighbor;
	}
	
	static function getArtType($aid){
		$info=self::getOnceArt($aid);
		return $info['type'];
	}
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	static function getArtTags($aid,$tags='id'){//获取笔记指定的属性
		$art=self::getOnceArt($aid);
		return $art[$tags];
	}
	
	static function getCollects($aid,$tp='a'){//blog：收藏数
		$snum=0;
		$db=Conn::getConnect();
		$sql= "SELECT * FROM ".DB_PRE ."user";
		$row=$db->getlist($sql);
		foreach($row as $value){
			if(!empty($value['collect'])){
				$collarr=explode(",",$value['collect']);
				if(count($collarr)>0){
					if(in_array($tp."|".$aid,$collarr)){$snum++;}
				}else{
					if($value['collect']==$tp."|".$aid){$snum++;}
				}
			}
		}
		return $snum;
	}
	
	static function getNewLog($num=10,$start=0,$sqlpro='',$order=''){//获取笔记
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."article` WHERE `type`='a' and `show`='1' and `check`='1' ";
		$sql.=$sqlpro;
		$sql.=" ORDER BY ".$order."`date` DESC limit ".$start.",".$num;
		$arts=$db->getlist($sql);
		return $arts;
	}
	
	static function getRandLog($num=12){//获取随机笔记
		$db=Conn::getConnect();
		$sql1="SELECT `id` FROM `". DB_PRE ."article` WHERE `type`='a' and `show`='1' and `check`='1' ";
		$ids=$db->getlist($sql1);
		shuffle($ids);
		$ids2=array_slice($ids,0,$num,true);
		$idstr="";
		foreach($ids2 as $val){$idstr.="'".$val['id']."',";}
		$idstr=trim($idstr,',');
		$sql="SELECT * FROM `". DB_PRE ."article` WHERE `id` in (".$idstr.") ";
		//echo $sql;
		return $arts=$db->getlist($sql);
	}
	
	
	
	
	
	
	
    
	
	
	
	

**/
}

?>