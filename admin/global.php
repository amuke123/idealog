<?php
header('Content-Type:text/html;charset=UTF-8');
include_once '../include/core/amuker.php';

checkRole();//登录和权限验证

define('TEMPLATE_PATHA', IDEA_ROOT .'/'. ADMIN_TYPE .'/view/');//后台当前模板路径
define('ADMIN_URL', IDEA_URL . ADMIN_TYPE .'/' );//后台地址
define('TEMPLATE_URLA', ADMIN_URL .'view/');//后台当前模板地址
define('IDEASHU_HOST', 'https://www.ideashu.com/');//官方服务域名

$userinfo = user_Model::getInfo();
$navlist = Control::getAlist();
$sta_cache = $cache->readCache('sta');

$avatar = empty($userinfo['photo']) ? TEMPLATE_URLA .'static/images/avatar.png' : IDEA_URL .str_replace('../','',$userinfo['photo']);
$nicename = $userinfo['name'];



?>