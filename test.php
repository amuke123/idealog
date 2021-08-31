<?php
$t1 = microtime(true);
for($i=0;$i<1000;$i++){
	for($j=0;$j<1000;$j++){
		
	}
}
$t2 = microtime(true);
//echo '耗时'.round($t2-$t1,16).'秒<br/>';
//echo substr(uniqid(),-8);

echo strtotime("2009-01-01 00:00:00")."<br/>";
echo strtotime("2009-1-1 0:0:0")."<br/>";
echo strtotime("2009-12-31 23:59:59")."<br/>";
echo strtotime("2009")."<br/>";
?>