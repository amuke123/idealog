<?php
class Mysql{
	private static $conn;
	public function __construct(){
		if(!class_exists('mysqli')){mkMsg('服务器空间PHP不支持MySqli函数');exit;}
		self::$conn=@new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
		@self::$conn->set_charset('utf8');
		if(mysqli_connect_errno()){mkMsg('连接错误:'.iconv('gbk','UTF-8',mysqli_connect_error()));exit;}
	}
	public static function query($sql=''){
		$result="";
		if($sql!=""){
			$result = self::$conn->query($sql);
		}
		return $result;
	}
	
	public static function row($result,$one = false,$type = MYSQLI_ASSOC){
		if(!empty($result)){
			if($one){return $result->fetch_array($type);}
			$arr=array();
			if(!empty($result)){
				while($row = $result->fetch_array($type)){//提取数据
					$arr[]=$row;
				}
			}
			return $arr;
		}else{return;}
	}
	
	public static function getList($sql){
		$result = self::query($sql);
		$arr = self::row($result);
		return $arr;
	}
	
	public static function getOnce($sql){
		$result = self::query($sql);
		$arr = self::row($result,true);
		return $arr;
	}
	
	public static function fetch_row($query) {
        return $query->fetch_row();
    }
	
	public static function close() {
        return self::$conn->close();
    }
	
	function getMysqlVersion(){
		return self::$conn->server_info;
    }
	
	public static function last_insert_id(){
		return self::$conn->insert_id;
	}
	
	public static function escape_string($sql) {
        return self::$conn->real_escape_string($sql);
    }
}
?>