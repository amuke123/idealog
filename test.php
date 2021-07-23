<?php
$t1 = microtime(true);
for($i=0;$i<1000;$i++){
	for($j=0;$j<1000;$j++){
		
	}
}
$t2 = microtime(true);
echo '耗时'.round($t2-$t1,16).'秒';
echo substr(uniqid(),-8);
?>