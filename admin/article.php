<?php
include_once 'global.php';

$pagenum = Control::get('art_num');//每页显示笔记数
if(ADMIN_URL!==null){$pagenum = Control::get('admin_pnum');}
$pageid = isset($_GET['page'])?$_GET['page']:1;
$startnum = $pagenum*($pageid-1);

$draft = isset($_GET['draft'])?$_GET['draft']:1;
$examine = isset($_GET['examine'])?$_GET['examine']:1;
$keyword = isset($_GET['keyword'])?$_GET['keyword']:'';

$rolestr = ROLE!=ROLE_ADMIN?" AND `author`='". UID ."' ":"";
if(isset($_GET['author'])){$rolestr = is_numeric($_GET['author'])?" AND `author`='". $_GET['author'] ."' ":"";}
if(isset($_GET['sortid'])){$rolestr .= is_numeric($_GET['sortid'])?" AND `s_id` = '". $_GET['sortid'] ."' ":"";}
$sidthem=isset($_GET['sortid'])?$_GET['sortid']:'';

$urlsub = '';
$urlsub .= $draft=='0'?'&draft=0':'';
$urlsub .= $examine=='0'?'&examine=0':'';

$sorts = $cache->readCache('sort');
//print_r($sorts);

$arts=art_Model::getArtList($draft,$examine,$rolestr,$keyword,$startnum,$pagenum);
$artnumb=art_Model::getArtsNum($draft,$examine,$rolestr,$keyword);
$pages=ceil($artnumb/$pagenum);
$urlpre=ADMIN_URL .'article.php?';
if(isset($_GET['sortid'])){$urlpre.='sortid='.$_GET['sortid'].'&';}
$urlpre.='page=';
$txtsub='篇笔记';

$pagestr=action_Model::pagelist($artnumb,$pages,$pageid,$urlpre,$txtsub,$urlsub);


include View::getViewA('header');
require_once(View::getViewA('article'));
include View::getViewA('footer');
View::output();

?>