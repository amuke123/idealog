<?php
require_once 'amuker.php';
Checking::setSession();
header('content-type:image/png');//向浏览器输出图片头信息
$image=imagecreatetruecolor(100, 30);//1.创建黑色画布
$bgcolor=imagecolorallocate($image, 255, 255, 255);//2.为画布定义(背景)颜色
imagefill($image,0,0,$bgcolor);//3.填充颜色
$content="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$captcha="";
for($i=0;$i<4;$i++) {
	$fontsize=15;// 字体大小
	$fontcolor=imagecolorallocate($image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));// 字体颜色
	$fontcontent=substr($content,mt_rand(0,strlen($content)-1),1);// 设置字体内容
	$captcha.=$fontcontent;
	$x=($i*100/4)+mt_rand(5,10);// 显示的坐标
	$y=mt_rand(15,25);//mt_rand(5,10)
	//imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);// 填充内容到画布中
	imagettftext($image,$fontsize,0,$x,$y,$fontcolor,'font/fenix.ttf',$fontcontent);
}
$_SESSION["code"]=strtolower($captcha);

for($$i=0;$i<120;$i++){//5.设置背景干扰元素
	$pointcolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
	imagesetpixel($image, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
}
for($i=0;$i<2;$i++){//4.设置干扰线
	$linecolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
	imageline($image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
}
imagepng($image);//6.输出图片到浏览器
imagedestroy($image);
?>