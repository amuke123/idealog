<?php
include_once 'global.php';

$path = IDEA_ROOT .'/content/backup/';
$dblist=getDir2($path);

function getDir2($path){
	if(is_dir($path)){
		$data = scandir($path,1);
		$dirs = array();
		foreach($data as $value){
			$newdir=$path.$value;
			if($value!='..'&&$value!='.'){
				$extension=pathinfo($newdir,PATHINFO_EXTENSION);
				if(is_file($newdir)&&$extension=='sql'){
					$pinfo['size']=filesize($newdir);
					$pinfo['date']=date("Y-m-d H:i:s",filemtime($newdir));
					$pinfo['name']=pathinfo($newdir,PATHINFO_BASENAME);
					$pinfo['url'] = IDEA_URL .'content/backup/';
					$dirs[]=$pinfo;
				}
			}
		}
	}
	return $dirs;
}



include View::getViewA('header');
require_once(View::getViewA('data'));
include View::getViewA('footer');
View::output();

?>