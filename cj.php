<meta charset="UTF-8">
<?php
$strat=1;
$speed=1;
$end=1;
$temurl="http://www.gdmaoda.com/zfzx/list_55_[参数1].html";
$pre="http://www.gdmaoda.com";
$topurl=array();
$stapreg='/<div class="new_tit">/i';
$urlpreg='/<a href="(.+)" >/iU';
$endpreg='/<div class="mainPage">/i';
for($i=$strat;$i<($end+1);$i+=$speed){
	$url=str_replace('[参数1]',$i,$temurl);
	$str=file_get_contents($url);
	$temarr=preg_split($stapreg,$str,2);
	$temarr=preg_split($endpreg,$temarr[1],2);
	preg_match_all($urlpreg,$temarr[0],$topurl[]);
}
$list=array();
$lipreg='/<h1>(.*)<\/h1>/iU';
foreach($topurl as $k => $v){
	foreach($v[1] as $key => $val){
		$str2=file_get_contents($pre.$val);
		preg_match($lipreg,$str2,$list[$k][$key]['title']);
	}
}
$titles=array();
foreach($list as $lk => $lv){
	foreach($lv as $val2){
		$titles[$lk][]=$val2['title'][1];
	}
}
print_r($titles);
?>