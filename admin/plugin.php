<?php
include_once 'global.php';

$plugin=isset($_GET['plugin'])?$_GET['plugin']:'';


include View::getViewA('header');
require_once(View::getViewA('plugin'));
include View::getViewA('footer');
View::output();

?>