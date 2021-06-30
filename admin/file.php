<?php
include_once 'global.php';

$pagenum = 15;//Control::get(admin_pnum);//每页显示数
$pageid = isset($_GET['page'])?$_GET['page']:1;
$startnum = $pagenum*($pageid-1);

$type = isset($_GET['type'])?$_GET['type']:'';
$aid = isset($_GET['aid'])?$_GET['aid']:'';

$urlhz='';
$urlsub = '';
if($aid!=''){
	$urlhz = '?aid='.$aid;
	$urlsub .='&aid='.$aid;
}


$sqlpre = $type!=''?" AND `type` like '".$type."/%' ":"";
if($type=='other'){$sqlpre = " AND `type` not like 'image/%' AND `type` not like 'audio/%' AND `type` not like 'video/%' ";}
$sqlpre .= $aid!=''?" AND `a_id`='{$aid}' ":"";

$list=file_Model::getFileList($startnum,$pagenum,$sqlpre);
$spannum=5-(count($list)%5);

$resum=file_Model::getFileAllNum($sqlpre);
$filenumb=$resum['sum'];
$pages=ceil($filenumb/$pagenum);
$urlpre=ADMIN_URL .'file.php?';
if($type!=''){$urlpre.='type='.$type.'&';}
$urlpre.='page=';
$txtsub='项资源';

$pagestr=action_Model::pagelist($filenumb,$pages,$pageid,$urlpre,$txtsub,$urlsub);


include View::getViewA('header');
require_once(View::getViewA('file'));
include View::getViewA('footer');
View::output();

?>