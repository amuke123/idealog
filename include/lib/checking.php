<?php
class Checking{
	
	public static function setSession(){
		$savePath = IDEA_ROOT.'/content/cache/session/';//getcwd()获取当前工作路径
		if(session_id()){
			if(!empty($_COOKIE["ideashu"])){
				$sid=$_COOKIE["ideashu"];
				session_id($sid);
			}
		}else{
			if(!empty($_COOKIE["ideashu"])){
				$sid=$_COOKIE["ideashu"];
				session_id($sid);
			}
			session_save_path($savePath);//session_start 开启前
			session_start();
		}
	}
	
	public static function isLogin(){//登陆检测
		$loginid = 0;
		if(!empty($_COOKIE["ideashu"])){
			self::setSession();
			if(!isset($_SESSION['uid'])){setcookie("ideashu","",time() - 3600);echo "<script>location.reload();</script>";}
			$iname='cookie_'.self::jm(getStrSub(AUTO_STR).$_SESSION['uid']);
			if(self::jm($_SESSION['uid'])==$_COOKIE[$iname] && $_SESSION['password']!=""){
				$loginid=$_SESSION['uid'];
			}
		}
		return $loginid;
	}
	
	public static function getLogin($username,$password,$code='',$save=0){//登陆验证
		self::setSession();
		$password = setUTF8(self::jm($password));
		if(Control::get('login_code')){
			if(!isset($_SESSION['code'])){echo "<script>alert('非法操作！');</script>";mkDirect(IDEA_URL);exit;}
			if(strtolower($code)!=$_SESSION['code']){echo "<script>alert('验证码错误！');window.history.go(-1);</script>";exit;}
		}
		$conn=Conn::getConnect();
		$sql="SELECT * FROM `". DB_PRE ."user` where `username`='".$username."' or `email`='".$username."' or `tel`='".$username."';";
		$row = $conn->getOnce($sql);
		if(!empty($row)){
			$pass=setUTF8($row["password"]);
			if(self::checkPw($password,$pass)){
				$_SESSION['uid']=$row["id"];
				$_SESSION['uname']=$row["username"];
				$_SESSION['password']=$row["password"];
				$iname='cookie_'.self::jm(getStrSub(AUTO_STR).$_SESSION['uid']);
				if($save==1){
					setcookie("ideashu",session_id(),time()+3600*24*7);//保存七天
					setcookie($iname,self::jm($row["id"]),time()+3600*24*7);
				}else{
					setcookie("ideashu",session_id());
					setcookie($iname,self::jm($row["id"]));
				}
				if($row["role"]!= ROLE_ADMIN ){
					mkDirect(IDEA_URL);
				}else{
					mkDirect(IDEA_URL . ADMIN_TYPE);
				}
			}else{
				echo "<script>alert('密码错误！');window.history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('邮箱/手机/账户不存在！');window.history.go(-1);</script>";
		}
	}
	
	public static function checkPw($password,$pass){//密码验证
		if(version_compare(PHP_VERSION,'5.5.0', '<')){
			$password = setUTF8(self::jm($password));
			$repass = $password == $pass ? TRUE : FALSE ;
		}else{
			$repass = password_verify($password."ideashu",$pass);
		}
		return $repass;
	}
	
	public static function roleOk($role = ''){//权限认证
		if($role == ""||$role != ROLE_ADMIN){
			echo "<script>alert('权限不足！');</script>";
			mkDirect(IDEA_URL);exit;
		}
	}
	
	public static function LoginOut(){//退出登陆
		self::setSession();
		$iname='cookie_'.self::jm(getStrSub(AUTO_STR).$_SESSION['uid']);
		$_SESSION['uid']="";
		$_SESSION = array();
		setcookie("ideashu",'',time()-3600);
		setcookie($iname,'',time()-3600);
		session_destroy();
		echo "<script>location.href='". IDEA_URL ."';</script>";
	}
	
	static function checkSendId($sendId,$uid=''){//检测邮箱或手机号是否存在
		$db=Conn::getConnect();
		$sql="SELECT COUNT(*) AS total FROM `". DB_PRE ."user` WHERE (`email`='".$sendId."' OR `tel`='".$sendId."') ";
		if($uid!=''){$sql.=' AND `id`!='.$uid;}
		$userid=$db->getOnce($sql);
		return $userid['total']>0?1:0;
	}
	
	public static function jm($str){//加密
		return $str=md5($str."ideashu");
	}
	
	public static function hashjm($str){//hash加密
		if(version_compare(PHP_VERSION,'5.5.0', '<')){
			$str=setUTF8(self::jm($str));
		}else{
			$str=setUTF8(password_hash($str."ideashu",PASSWORD_DEFAULT));
		}
		return $str;
	}
	
	public static function getAjCode($num=6){//js异步验证码
		self::setSession();
		return $_SESSION['ajcode'] = getStr($num);
	}
	
	
	static function resetUser($sendType,$sendId,$pwd){//重置密码
		$conn=Conn::getConnect();
		$sql="UPDATE `". DB_PRE ."user` SET `password` = '".$pwd."' WHERE `".$sendType."`='".$sendId."';";
		if($conn->query($sql)){
			//updateCacheAll();
			echo "<script>alert('密码重置成功，请登录！');location.href='".Url::getActionUrl('login')."';</script>";
		}else{
			echo $sql;
		}
	}
	
	static function registerUser($data){//用户注册
		$conn=Conn::getConnect();
		$username=self::getUserName();
		$keystr='';
		$valstr='';
		foreach($data as $key => $value){
			$keystr.="`".$key."`,";
			$valstr.="'".$value."',";
		}
		$keystr=trim($keystr,',');
		$valstr=trim($valstr,',');
		$sql="INSERT INTO `". DB_PRE ."user` (`id`, `username`, ".$keystr.") VALUES (NULL, '".$username."',".$valstr.");";
		if($conn->query($sql)){
			updateCacheAll('sta');
			echo "<script>alert('注册成功，请登录！');location.href='".Url::getActionUrl('login')."';</script>";
		}
	}
	
	static function getUserName(){//自动生成用户名
		$pre=Control::get('userpre');
		$pre=$pre==''?'idea_':$pre;
		$str=uniqid($pre);
		return $str;
	}
	
	static function checkSendType($sendId){//检测是邮箱还是手机号
		$reset='';
		if(filter_var($sendId, FILTER_VALIDATE_EMAIL)){$reset='email';}
		if(preg_match("/^1[3456789]\d{9}$/",$sendId)){$reset='tel';}
		return $reset;
	}
	
	
	static function checkCode($code,$sendId){//检测验证码是否正确
		self::setSession();
		if(isset($_SESSION['code_'.$sendId])){
			$key = $_SESSION['code_'.$sendId]==$code?'1':'0';
			$_SESSION['code_'.$sendId]=='';
		}else{$key = '0';}
		return $key;
	}
	
	
	
	
	
	
	
	
	
}
?>