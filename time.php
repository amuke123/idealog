<?php
date_default_timezone_set("PRC");
$t=time();
echo date("c",$t);
echo "<br/>";
echo DATE_W3C;
echo "<br/>";
echo date(DATE_W3C,$t);
echo "<br/>";
echo DATE_ATOM;
echo "<br/>";
echo date(DATE_ATOM,$t);
?>