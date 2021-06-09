<?php
include_once 'global.php';




include View::getViewA('header');
require_once(View::getViewA('say'));
include View::getViewA('footer');
View::output();

?>