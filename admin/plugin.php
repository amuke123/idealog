<?php
include_once 'global.php';

$path=IDEA_ROOT .'/content/plugins/';
$pluginlist=getPlugDir($path);
print_r($pluginlist);

$plugins=Control::get('plugins_list');

$action=isset($_GET['action'])?$_GET['action']:'';
$plugin=isset($_GET['plugin'])?$_GET['plugin']:'';


$preopin='sys';
$nextopin='plugin';
if(!$action&&$plugin){
	$preopin='extend';
	$nextopin='more_'.$plugin;
}


include View::getViewA('header');
require_once(View::getViewA('plugin'));
include View::getViewA('footer');
View::output();

?>