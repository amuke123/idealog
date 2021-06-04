<?php
header('Content-Type:text/html;charset=UTF-8');
include_once '../include/core/amuker.php';
checkRole();
//checkRole();

echo '后台';

?>
<p><a href="<?php echo Url::getActionUrl('setcache');?>">更新缓存</a></p>
<p><a href="<?php echo Url::getActionUrl('goout');?>">退出</a></p>