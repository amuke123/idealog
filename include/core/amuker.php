<?php
ob_start();
//error_reporting(0);//屏蔽错误
header('Content-Type: text/html; charset=UTF-8');
define('IDEA_ROOT', dirname(dirname(dirname(__FILE__))));
if(extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}
require_once IDEA_ROOT.'/include/core/config.php';
require_once IDEA_ROOT.'/include/core/function.main.php';

spl_autoload_register("mkAutoload");
//doStripslashes();

$cache = Conn::getCache();

//权限
define('ROLE_ADMIN','admin');
define('ROLE_VISITOR','visitor');

date_default_timezone_set(Control::get('time_zone'));//设置时区

$siteurl=substr(Control::get('siteurl'),-1)=="/"?Control::get('siteurl'):Control::get('siteurl')."/";
define('IDEA_URL',$siteurl);//网站URL
define('SITE_NAME',Control::get('sitename'));//网站名称

define('ADMIN_TYPE',Control::get('admin_tem'));//后台路径
define('TPLS_PATH',IDEA_URL .'content/template/');//模板库目录
define('TEMPLATE_URL',TPLS_PATH .Control::get('template').'/');//模版url地址
define('TEMPLATE_PATH',IDEA_ROOT .'/content/template/'.Control::get('template').'/');//模板路径


$uid = !empty(Checking::isLogin())?Checking::isLogin():0;
define('UID',$uid);
$userData = UID!=0?user_Model::getInfo():array();
define('ROLE', !empty($userData)?$userData['role']:ROLE_VISITOR);


//$cache -> updateCache();


?>