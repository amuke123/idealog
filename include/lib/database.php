<?php
/**
***文章和页面信息
**/
class Database{
	
	static function importDb($pathname){
		$restr = self::checkDb($pathname);
		if($restr=='ok'){
			$text=self::inDb($pathname);
		}else{
			$text=$restr;
		}
		echo $text;
	}
	
	static function inDb($pathname){
		return "成功！";
	}
	
	static function checkDb($pathname){
		$fp = @fopen($pathname,'r');
		$text='ok';
		if(!$fp){$text='导入失败！读取数据文件失败';}
		$info = array();
		$i=0;
		while(!feof($fp)){
			if($i++<3){$info[]=fgets($fp);}else{break;}
		}
		fclose($fp);
		if(!empty($info)){
			if(!preg_match('/-- version:ideaLog '. Control::IDEA_VERSION .'/',$info[0])){
				$text='导入失败！该备份文件不是ideaLog' . Control::IDEA_VERSION . '生成的备份!';
			}else if(preg_match('/-- prefix:'. DB_PRE .'/',$info[2])===0){
				$text='导入失败！备份文件中的数据库表前缀与当前系统数据库表前缀不匹配'. $info[2];
			}
		}else{
			$text='导入失败！数据文件损坏';
		}
		return $text;
	}
	
	static function setBak($tables=""){
		$tbs = $tables==""?self::getTables():$tables;
		
		$bakname = 'idb_'.date('Ymd').'_'.substr(md5(AUTO_STR .uniqid()),0,12);
		$sqldump = '';
		foreach($tbs as $table){
			$sqldump .= self::dataBak($table);
		}
		$sqldump = trim($sqldump);
		if(!empty($sqldump)){
			$filestr = '-- version:ideaLog '. Control::IDEA_VERSION . "\n";
        	$filestr .= '-- date:' . date('Y-m-d H:i') . "\n";
        	$filestr .= '-- prefix:' . DB_PRE . "\n\n";
        	$filestr .= $sqldump;
        	$filestr .= "\n\n-- the end of backup";
			$filename = IDEA_ROOT .'/content/backup/'.$bakname.'.sql';
			$fip = fopen($filename,'w+');
			if($fip){
				@flock($fip,LOCK_UN);
                if(@!fwrite($fip,$filestr)){
                    $txt='备份失败。备份目录(content/backup)不可写';
                }else{
					$txt='备份成功！';
                }
				@fclose($fip);
			}else{
				$txt='创建备份文件失败。备份目录(content/backup)不可写';
			}
		}else{
			$txt='数据库没有任何数据表';
		}
		return $txt;
	}
	
	static function upload($file){//file 文件
		$save_path = IDEA_ROOT . '/content/backup/';
		$max_size = (Control::get('file_maxsize')*1024)*1024;
		$ext_arr=array('sql');
		
		$file_name = $file['name'];
		$tmp_name = $file['tmp_name'];
		$file_size = $file['size'];
		
		if($file['error'] == 1){return "导入文件大小超过系统".ini_get('upload_max_filesize')."限制";}
		
		if(@is_dir($save_path) === false){return "导入目录不存在。";}
		if(@is_writable($save_path) === false){return "导入目录没有写权限。";}
		if($file_size > $max_size){return "导入文件大小超过限制。";}

		$temp_arr = explode(".",$file_name);
		$file_ext = array_pop($temp_arr);
		$file_ext = trim($file_ext);
		$file_ext = strtolower($file_ext);
		if(in_array($file_ext,$ext_arr) === false){return "文件类型错误，请导入后缀名为“".implode('/',$ext_arr)."”的备份文件";}

		$tmp_pre = "updb_";
		$new_path = $save_path;
		$new_file_name = $tmp_pre.time().rand(10000,99999).'.'.$file_ext;

		$file_path = $new_path . $new_file_name;
		if(move_uploaded_file($tmp_name,$file_path) === false){return "导入文件失败。";}

		return $new_file_name;
	}
	
	static function dataBak($table,$nums=50){
		$db=Conn::getConnect();
		$sql = "DROP TABLE IF EXISTS $table;\n";
		$createtb = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_row($createtb);
		$sql .= $create[1].";\n\n";

		$list = $db->getList("SELECT * FROM $table");
		$rows = count($list);
		$nums=$nums==0?1:$nums;$i=0;
		if(!empty($list)){
			$sql .= "INSERT INTO $table VALUES ";
			foreach($list as $v){
				$i++;
				foreach($v as $key=>$val){$v[$key]=str_replace("'","''",$val);}
				if($i<$rows){
					$sql .= ($i%$nums)==0?"('".implode("','",$v)."');\nINSERT INTO $table VALUES ":"('".implode("','",$v)."'),\n";
				}else{
					$sql .= "('".implode("','",$v)."');\n";
				}
			}
		}
		$sql .= "\n\n";
		return $sql;
	}
	
	static function getTables(){
		$db=Conn::getConnect();
		$tbs = $db->getList("SHOW TABLES");
		$tbarr=array();
		foreach($tbs as $v){
			$tmpname=$v['Tables_in_'.DB_NAME];
			if(empty(DB_PRE)||stripos($tmpname,DB_PRE)!=FALSE){$tbarr[]=$tmpname;}
		}
		return $tbarr;
	}
	
}
?>