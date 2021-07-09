<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>安装-ideaLog</title>
<style>
body{background:#f7f8f9;}
.main{background:#fff;font-size:14px;color:#333;width:780px;margin:50px auto;padding:10px 20px;border:#ddd 1px solid;border-radius:4px;text-align:center;}
.main2{line-height:40px;}
.title{margin:30px 0px;font-size:24px;line-height:50px;color:#2a6496;}
.box p{line-height:30px;padding:5px 0px;text-align:left;margin:15px 0px;}
.box p strong{line-height:45px;display:block;border-bottom:1px #ddd solid;font-size:15px;}
.box p b{width:100px;display:inline-block;padding:0px 10px 0px 15px;text-align:right;}
.box p input{padding:0px 10px;width:160px;border-radius:5px;border:#ccc solid 1px;line-height:28px;height:28px;}
.box p span{display:inline-block;padding:0px 10px;color:#0c7dd5;}
.bottom{margin:20px 0px 40px;text-align:left;}
.bottom input{padding:0px 12px;font-size:15px;line-height:32px;height:32px;border-radius:4px;color:#fff;background:#428bca;border:1px solid #357ebd;}
.bottom input:hover{background:#3071a9;border:1px solid #285e8e;}
</style>
</head>
<body>
<?php
/**
*** 安装程序
**/
define('IDEA_ROOT',dirname(__FILE__));
require_once IDEA_ROOT.'/include/core/function.main.php';
header('Content-Type: text/html; charset=UTF-8');
spl_autoload_register("mkAutoload");

$action = isset($_GET['action'])?$_GET['action']:'';

if(PHP_VERSION<'5.0'){mkMsg('您的php版本过低，请选用5.0以上版本的PHP环境安装ideaLog');}
if(!$action){
?>
<form name="form1" method="post" action="?action=install">
	<div class="main">
		<p class="title">ideaLog <?php echo Control::IDEA_VERSION ?> 安装程序</p>
		<div class="box">
			<p><strong>MySql数据库设置</strong></p>
			<p><b>数据库地址：</b><input name="hostname" type="text" value="127.0.0.1"><span>(通常为 localhost / 127.0.0.1， 不必修改)</span></p>
			<p><b>数据库用户名：</b><input name="dbuser" type="text" value=""></p>
			<p><b>数据库密码：</b><input name="dbpw" type="password"></p>
			<p><b>数据库名：</b><input name="dbname" type="text" value=""><span>(程序不自动创建数据库，请提前创建一个空数据库或使用已有数据库)</span></p>
			<p><b>数据库表前缀：</b><input name="prefix" type="text" value="ilog_"><span>(默认即可。由英文字母、数字、下划线组成，且以下划线结束)</span></p>
		</div>
		<div class="box">
			<p><strong>管理员设置</strong></p>
			<p><b>登录名：</b><input name="admin" type="text"></p>
			<p><b>登录密码：</b><input name="adminpw" type="password"></p>
			<p><b>确认登录密码：</b><input name="adminpw2" type="password"></p>
			<p><strong></strong></p>
		</div>
		<p class="bottom"><input type="submit" class="submit" value="开始安装"></p>
	</div>
</form>
<?php
}
if($action=='install'){
	$db_host = isset($_POST['hostname'])?addslashes(trim($_POST['hostname'])):'';
    $db_user = isset($_POST['dbuser'])?addslashes(trim($_POST['dbuser'])):'';
    $db_pw = isset($_POST['dbpw'])?addslashes(trim($_POST['dbpw'])):'';
    $db_name = isset($_POST['dbname'])?addslashes(trim($_POST['dbname'])):'';
    $db_prefix = isset($_POST['prefix'])?addslashes(trim($_POST['prefix'])):'';
    $admin = isset($_POST['admin'])?addslashes(trim($_POST['admin'])):'';
    $adminpw = isset($_POST['adminpw'])?addslashes(trim($_POST['adminpw'])):'';
    $adminpw2 = isset($_POST['adminpw2'])?addslashes(trim($_POST['adminpw2'])):'';
	
	$txt='';$txt2='';$result = '';
	if($db_prefix==''){
		$txt='数据库表前缀不能为空!';
	}else if(!preg_match("/^[\w_]+_$/",$db_prefix)){
		$txt='数据库表前缀格式错误!';
	}else if($admin==''||$adminpw==''){
		$txt='登录名和密码不能为空!';
	}else if(strlen($adminpw)<6){
		$txt='登录密码不得小于6位!';
	}else if($adminpw!=$adminpw2){
		$txt='两次输入的密码不一致!';
	}
	if($txt!=""){mkMsg($txt);exit;}
	
	if($db_host==""){$txt2='数据库链接地址不能为空!';
	}else if($db_user==""){$txt2='请输入数据库用户名!';
	}else if($db_name==""){$txt2='不能使用空数据库!';}
	if($txt2!=""){mkMsg($txt2);exit;}
	
	define('DB_HOST',$db_host);
	define('DB_USER',$db_user);
	define('DB_PASSWD',$db_pw);
	define('DB_NAME',$db_name);
	define('DB_PRE',$db_prefix);
	
	$db=Conn::getConnect();
	$cache=Conn::getCache();
	
	$confpath=IDEA_ROOT .'/include/core/config.php';
	if(!is_writable($confpath)){mkMsg('配置文件(config.php)不可写');exit;}
    if(!is_writable(IDEA_ROOT .'/content/cache')){mkMsg('缓存文件(content/cache)不可写');exit;}
	
	$config="<?php\n"
    ."define('DB_HOST','$db_host');\n"
    ."define('DB_USER','$db_user');\n"
    ."define('DB_PASSWD','$db_pw');\n"
    ."define('DB_NAME','$db_name');\n"
    ."define('DB_PRE','$db_prefix');\n\n"
    ."define('AUTO_STR','".Checking::hashjm(getStr(16).$_SERVER['HTTP_USER_AGENT'])."');\n"
    ."\n";
	
	$fp = @fopen($confpath,'w');
    $fw = @fwrite($fp,$config);
    if(!$fw){mkMsg('配置文件(config.php)不可写');exit;}
    fclose($fp);
	
	$adminpw=Checking::hashjm(Checking::jm($adminpw));
	$dbcharset = 'utf8mb4';
    $type = 'InnoDB';
	$table_charset_sql = $db->getMysqlVersion()>'4.1' ? 'ENGINE='.$type.' DEFAULT CHARSET='.$dbcharset : 'ENGINE='.$type;
    if($db->getMysqlVersion()>'4.1'){
		$db->query("ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;",true);
	}
	
	$link='a:1:{i:0;a:6:{s:4:"name";s:9:"创意书";s:3:"pic";s:0:"";s:3:"url";s:22:"https://www.ideashu.cn";s:3:"des";s:9:"创意书";s:4:"show";s:1:"1";s:5:"index";s:1:"1";}}';
	$logurl=strstr($_SERVER['HTTP_REFERER'],'install.php',true);
	define('IDEA_URL',$logurl);
	define('SITE_NAME','ideaLog');
	
	$sql="
DROP TABLE IF EXISTS {$db_prefix}article;
CREATE TABLE `{$db_prefix}article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` varchar(12) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` longtext NOT NULL,
  `key` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `author` int(10) NOT NULL DEFAULT '0',
  `s_id` int(10) NOT NULL DEFAULT '-1',
  `type` varchar(8) NOT NULL,
  `eyes` int(10) NOT NULL,
  `goodnum` int(10) NOT NULL,
  `badnum` int(10) NOT NULL,
  `saynum` int(10) NOT NULL,
  `filenum` int(10) NOT NULL,
  `getsite` varchar(255) NOT NULL,
  `geturl` varchar(255) NOT NULL,
  `show` int(1) NOT NULL,
  `sayok` int(1) NOT NULL,
  `template` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `check` int(1) NOT NULL,
  `mark` varchar(32) NOT NULL,
  `copyrights` int(1) NOT NULL,
  PRIMARY KEY (`id`)
  ) {$table_charset_sql};
INSERT INTO `{$db_prefix}article` VALUES (1,'欢迎使用ideaLog','".time()."','成功安装了ideaLog，这是系统自动生成的一篇笔记，记录精彩生活从现在开始','','','',1,0,'a',0,0,0,0,0,'','',1,1,'','','','',1,'',0);
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE `{$db_prefix}comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `a_id` int(10) NOT NULL,
  `top_id` int(10) NOT NULL,
  `t_id` int(10) NOT NULL,
  `date` varchar(12) NOT NULL,
  `posterid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `mail` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `show` int(1) NOT NULL,
  `check` int(1) NOT NULL,
  `mark` int(1) NOT NULL,
  `good` int(10) NOT NULL,
  `bad` int(10) NOT NULL,
  `del` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) {$table_charset_sql};
DROP TABLE IF EXISTS {$db_prefix}file;
CREATE TABLE `{$db_prefix}file` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `a_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `size` varchar(32) NOT NULL,
  `path` varchar(255) NOT NULL,
  `addtime` varchar(12) NOT NULL,
  `type` varchar(32) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `top_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) {$table_charset_sql};
DROP TABLE IF EXISTS {$db_prefix}nav;
CREATE TABLE `{$db_prefix}nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `url` varchar(128) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `blank` int(1) NOT NULL,
  `show` int(1) NOT NULL,
  `top_id` int(10) NOT NULL,
  `index` int(10) NOT NULL DEFAULT '0',
  `change` int(1) NOT NULL,
  `type` int(1) NOT NULL,
  `type_id` int(10) NOT NULL,
  `group` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) {$table_charset_sql};
INSERT INTO {$db_prefix}nav VALUES ('1','首页','','','0','1','0','1','0','1','0','0'),
('2','登录','login','','1','0','0','99','0','3','0','0');
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE `{$db_prefix}options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`)
) {$table_charset_sql};
INSERT INTO {$db_prefix}options VALUES ('1','sitename','ideaLog'),
('2','siteinfo','带你享受创意生活'),
('3','seo_title','ideaLog'),
('4','seo_description','ideaLog 带你享受创意生活'),
('5','seo_key','ideaLog'),
('6','seo_type','1'),
('7','logo',''),
('8','siteurl','{$logurl}'),
('9','icp',''),
('10','footer_info',''),
('11','header_meta',''),
('12','template','idealog'),
('13','admin_tem','admin'),
('14','admin_style',''),
('15','admin_pnum','15'),
('16','art_num','12'),
('17','art_check','0'),
('18','login_code','1'),
('19','time_zone','PRC'),
('20','aliasok','0'),
('21','htmlok','0'),
('22','url_type','1'),
('23','excerpt','0'),
('24','excerpt_long','120'),
('25','sayok','1'),
('26','say_time','60'),
('27','say_code','1'),
('28','say_check','1'),
('29','say_chinese','0'),
('30','say_gravatar','1'),
('31','say_page','1'),
('32','say_pnum','5'),
('33','say_order','1'),
('34','reply_code','0'),
('35','file_maxsize','2'),
('36','file_type','jpg,gif,png,jpeg,mp4,mp3,rar,zip,txt,pdf,docx,doc,xls,xlsx'),
('37','thumbnailok','1'),
('38','thum_imgmaxw','420'),
('39','thum_imgmaxh','480'),
('40','userpre','i'),
('41','mailhost',''),
('42','mail',''),
('43','mailpswd',''),
('44','mailport',''),
('45','message_appid',''),
('46','message_appkey',''),
('47','message_templId',''),
('48','message_sign',''),
('49','message_url',''),
('50','ali_appid',''),
('51','ali_publicKey',''),
('52','ali_privateKey',''),
('53','wx_id',''),
('54','wx_key',''),
('55','wx_appid',''),
('56','wx_secert',''),
('57','wx_m_appid',''),
('58','wx_m_secert',''),
('59','pay_name',''),
('60','pay_bank',''),
('61','pay_id',''),
('62','banner_list','a:0:{}'),
('63','link_list','a:0:{}'),
('64','plugins_list','a:0:{}'),
('65','side','a:0:{}');
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE `{$db_prefix}sort` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `alias` varchar(128) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `key` text NOT NULL,
  `template` varchar(128) NOT NULL,
  `group` int(10) NOT NULL,
  `top_id` int(10) NOT NULL,
  `index` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) {$table_charset_sql};
DROP TABLE IF EXISTS {$db_prefix}tags;
CREATE TABLE `{$db_prefix}tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `a_id` text NOT NULL,
  PRIMARY KEY (`id`)
) {$table_charset_sql};
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE `{$db_prefix}user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `role` varchar(32) NOT NULL,
  `check` int(1) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `emailok` int(1) NOT NULL DEFAULT '0',
  `tel` varchar(12) NOT NULL,
  `telok` int(1) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  `date` varchar(12) NOT NULL,
  `lastdate` varchar(12) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '0',
  `birthday` varchar(12) NOT NULL,
  `diyurl` varchar(64) NOT NULL,
  `order` int(10) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) {$table_charset_sql};
INSERT INTO {$db_prefix}user VALUES ('1','{$admin}','{$adminpw}','','admin','1','','','0','','0','','".time()."','','0','','','0','0');";
	$array_sql = preg_split("/;[\r\n]/",$sql);
	$array_sql[]="UPDATE `{$db_prefix}options` SET `value` = '".$link."' WHERE `key` = 'link_list';";
	foreach($array_sql as $sqlv){
		$sqlv=trim($sqlv);
		if($sqlv){$db->query($sqlv);}
    }
	updateCacheAll();
	$result.='<div class="main main2"><p class="title">恭喜，安装成功！</p><p>您的ideaLog已经安装好了，现在可以开始您的创作了，就这么简单!</p><p><b>用户名</b>：'.$admin.'</p><p><b>密 码</b>：您刚才设定的密码</p><div class="box"><p><strong></strong></p></div><p><a href="./">访问首页</a> | <a href="./admin/">登录后台</a></p></div>';
	echo $result;
}
?>
</body>
</html>