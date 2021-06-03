<?php
/*
**导航信息
*/
class nav_Model{
	
	const navtype_custom  = 0;
    const navtype_home    = 1;
    const navtype_sys     = 2;
    const navtype_admin   = 3;
    const navtype_sort    = 4;
    const navtype_page    = 5;
	
	/**static function getNav($navid='0'){
		$db=Conn::getConnect();
		$sqledit="SELECT * FROM `". DB_PRE ."nav` ";
		if($navid=='0'){
			return $navs=$db->getlist($sqledit);
		}else{
			$sqledit .= " WHERE `id`=".$navid;
			return $navline=$db->getOnce($sqledit);
		}
	}
	static function addNav($ck,$group,$data,$key,$num){
		$db=Conn::getConnect();
		foreach($ck as $v){
			$name='';
			if($key=='sort'){$name=$data[$v]['sortname'];}
			if($key=='book'){$name=$data[$v]['name'];}
			if($key=='page'){$name=$data[$v]['title'];$alia=$data[$v]["alias"]==''?$data[$v]["id"].".html":$data[$v]["alias"].".html";}else{$alia=$key."/".$data[$v]["alias"];}
			$sqladdp="INSERT INTO `". DB_PRE ."nav` (`id`,`name`,`url`,`pic`,`blank`,`show`,`top_id`,`index`,`changeok`,`type`,`type_id`,`group`) VALUES (NULL,'".$name."','".IDEA_URL .$alia."','".$data[$v]["pic"]."','0','1','0','0','1','".$num."','".$data[$v]["id"]."','".$group."');";
			$textp="导航添加失败";
			if(!$db->query($sqladdp)){
				echo "<script>prompt1('".$textp."');</script>";
			}
		}
		updateCacheAll('nav');
	}
	
	static function addDiyNav($adddata,$lid){
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
		if($lid==''){
			$sqladd="INSERT INTO `". DB_PRE ."nav` (`id`,`show`,`changeok`,`type`,`type_id`,".$keystr.") VALUES (NULL,'1','1','0','0',".$valstr.");";
			$text="创建分类失败";
		}else{
			$sqladd="UPDATE `". DB_PRE ."nav` SET ".$upstr." WHERE `id`=".$lid;
			$text="编辑失败";
		}
		if(!$db->query($sqladd)){
			echo "<script>prompt1('".$text."');</script>";
		}
		updateCacheAll('nav');
	}**/
	
}
?>