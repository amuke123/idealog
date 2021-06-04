<?php
/*
**系统操作
*/
class action_Control{
	function display($datas=array()){
		//print_r($datas);
		$cache=Conn::getCache();
		$sorts=$cache->readCache('sort');
		$system_cache=Control::getOptions();
		extract($system_cache);
		
		$do=$datas[1];
		if($do=='login'||$do=='register'||$do=='reset'){
			loginOk();
			if(isset($_POST['tj'])){
				action_Model::actionFc($do,$site_title);
			}else{
				$action=$do;
				include View::getViewA('login');
			}
		}else{
			action_Model::actionFc($do,$site_title);
		}
		
	}

}


?>