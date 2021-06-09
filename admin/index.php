<?php
include_once 'global.php';

$serverapp = $_SERVER['SERVER_SOFTWARE'];
$DB = Conn::getConnect();
$mysql_ver=$DB->getMysqlVersion();
$php_ver = PHP_VERSION;
$uploadfile_maxsize = ini_get('upload_max_filesize');

if(function_exists("imagecreate")){
	if(function_exists('gd_info')){
		$ver_info = gd_info();
		$gd_ver = $ver_info['GD Version'];
	}else{$gd_ver = '支持';}
}else{$gd_ver = '不支持';}


include View::getViewA('header');
require_once(View::getViewA('index'));
include View::getViewA('footer');
View::output();

?>