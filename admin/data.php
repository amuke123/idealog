<?php
include_once 'global.php';




include View::getViewA('header');
require_once(View::getViewA('data'));
include View::getViewA('footer');
View::output();

?>