<?php
class Conn{
	private static $link = null;
	public static function getCache(){
        $cache = new Cache();
		return $cache;
    }
	public static function getConnect(){
		$mysql = new Mysql();
		return $mysql;
	}
	
}

?>