<?php
/**
***资源管理
**/
class file_Model{
	
	static function getFileList($startnum,$pagenum,$sqlpre){
		$db=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."file` WHERE `top_id`='0' ";
		if($sqlpre){$sql.=$sqlpre;}
		$sql.=" ORDER BY `addtime` DESC LIMIT {$startnum},{$pagenum}";
		return $navs=$db->getlist($sql);
	}
	
	static function getFileAllNum($sqlpre){
		$db=Conn::getConnect();
		$sql="SELECT count(*) as sum FROM `". DB_PRE ."file` WHERE `top_id`='0' ";
		if($sqlpre){$sql.=$sqlpre;}
		return $navs=$db->getOnce($sql);
	}

	
}

?>