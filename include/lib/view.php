<?php
class View{
	
	public static function getView($template,$ext='.php'){
		if(!is_dir(TEMPLATE_PATH)){
			echo "<script>alert('当前使用的模板已被删除或损坏，请登录后台更换其他模板。');location.href='". IDEA_URL . ADMIN_TYPE ."/template.php';</script>";exit;
		}
		return TEMPLATE_PATH .$template.$ext;
	}
	public static function getViewA($template,$ext='.php'){
		$path = IDEA_ROOT .'/'. ADMIN_TYPE .'/view/';
		if(!is_dir($path)){
			echo "<script>alert('当前使用的模板已被删除或损坏，请登录后台更换其他模板。');location.href='". IDEA_URL . ADMIN_TYPE ."/template.php';</script>";exit;
		}
		return $path .$template.$ext;
	}
	public static function output() {
		$content = ob_get_clean();
        ob_start();
		echo $content;
		ob_end_flush();
		exit;
	}
	
}
?>