<?php
header('Content-Type:text/html;charset=UTF-8');
include_once 'include/core/amuker.php';

Router::dispatch();

Email::sendMail('amuke123@163.com');

?>