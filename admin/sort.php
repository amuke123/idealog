<?php
include_once 'global.php';

$sorts = $cache->readCache('sort');


include View::getViewA('header');
require_once(View::getViewA('sort'));
include View::getViewA('footer');
View::output();

?>