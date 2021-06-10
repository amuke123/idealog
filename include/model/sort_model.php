<?php
/**
***分类信息
**/
class sort_Model{
	
	static function moveArtsSort($artids,$newsid=0){//批量更换文章分类
		$db=Conn::getConnect();
		foreach($artids as $val){
			$sqlok="UPDATE `". DB_PRE ."article` SET `s_id`='".$newsid."' WHERE `id` = ".$val.";";
			$db->query($sqlok);
		}
	}
	
	/**static function getSortUrl($sorts,$now='',$urlsub=''){//获取分类列表跳转链接，可指定选中列表项和后缀
		$text='';
		foreach($sorts as $value){
			if($value['top_id']==0){
				$text.='<option value="'.ADMIN_URL .'article.php?sortid='.$value['id'].$urlsub.'" ';
				if($value['id']==$now){$text.='selected';}
				$text.='>'.$value['sortname'].'</option>';
				$children=$value['children'];
				foreach($children as $val){
					$text.='<option value="'.ADMIN_URL .'article.php?sortid='.$sorts[$val]['id'].$urlsub.'" ';
					if($sorts[$val]['id']==$now){$text.='selected';}
					$text.='>---- '.$sorts[$val]['sortname'].'</option>';
					if(isset($sorts[$val]['children'])){
						foreach($sorts[$val]['children'] as $v){
							$text.='<option value="'.ADMIN_URL .'article.php?sortid='.$sorts[$v]['id'].$urlsub.'" ';
							if($sorts[$v]['id']==$now){$text.='selected';}
							$text.='>---- ---- '.$sorts[$v]['sortname'].'</option>';
						}
					}
				}
			}
		}
		return $text;
	}
	
	static function getSortName($sid=0){
		$cache=Conn::getCache();
		$sorts=$cache->readCache('sort');
		return $sid!=0?$sorts[$sid]['sortname']:'未分类';
	}**/
	
	static function getSortList($sorts,$sid=0){//获取分类列表，可指定选中列表项
		$text='';
		foreach($sorts as $value){
			if($value['top_id']==0){
			$text.='<option value="'.$value['id'].'" ';
			if($value['id']==$sid){$text.='selected';}
			$text.='>'.$value['sortname'].'</option>';
				$children=$value['children'];
				foreach($children as $val){
					$text.='<option value="'.$sorts[$val]['id'].'" ';
					if($sorts[$val]['id']==$sid){$text.='selected';}
					$text.='>---- '.$sorts[$val]['sortname'].'</option>';
					if(isset($sorts[$val]['children'])){
						foreach($sorts[$val]['children'] as $v){
							$text.='<option value="'.$sorts[$v]['id'].'" ';
							if($sorts[$v]['id']==$sid){$text.='selected';}
							$text.='>---- ---- '.$sorts[$v]['sortname'].'</option>';
						}
					}
				}
			}
		}
		return $text;
	}
	
	static function getTopSorts($sorts,$tid=0,$sid=0){//获取可用上级分类列表，可指定上级分类并隐藏指定的自身分类
		$text='';
		foreach($sorts as $value){
			if($value['top_id']==0){
				if($value['id']!=$sid){
					$text.='<option value="'.$value['id'].'" ';
					if($value['id']==$tid){$text.='selected';}
					$text.='>'.$value['sortname'].'</option>';
				}
				$children=$value['children'];
				foreach($children as $val){
					if($sorts[$val]['id']!=$sid){
						$text.='<option value="'.$sorts[$val]['id'].'" ';
						if($sorts[$val]['id']==$tid){$text.='selected';}
						$text.='>---- '.$sorts[$val]['sortname'].'</option>';
					}
				}
			}
		}
		return $text;
	}
	
	
}

?>