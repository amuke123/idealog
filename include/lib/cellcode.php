<?php
class Cellcode{
	public static function getCode($mark){//手机验证码生成
		Checking::setSession();
		$randCode = rand(100000, 999999);
		$_SESSION['code_'.$mark] = $randCode;
		return $randCode;
	}
}
?>