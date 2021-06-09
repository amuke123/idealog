<?php
include_once 'global.php';

$sorts = $cache->readCache('sort');
$tags = $cache->readCache('tags');


include View::getViewA('header');
require_once(View::getViewA('write_art'));
include View::getViewA('footer');
View::output();

?>