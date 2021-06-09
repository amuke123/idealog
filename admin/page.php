<?php
include_once 'global.php';




include View::getViewA('header');
require_once(View::getViewA('page'));
include View::getViewA('footer');
View::output();

?>