<?php
class Control{
	
	const IDEA_VERSION = '1.0';//版本编号
	
	static function get($option){
		$cache = Conn::getCache();
		$op_cache = $cache->readCache('options');
		if(isset($op_cache[$option])) {
			switch ($option) {
				case 'plugins_list':
				case 'banner_list':
				case 'link_list':
				case 'side':
					if(!empty($op_cache[$option])) {
						return @unserialize($op_cache[$option]);
					}else{
						return array();
					}
					break;
				default:
					return $op_cache[$option];
					break;
			}
		}
	}
	
	static function set($data){
		$db = Conn::getConnect();
		foreach($data as $keys => $vals){
			$sql2="UPDATE `". DB_PRE . "options` SET `value`='".$vals."' WHERE `key`='".$keys."'";
			$db->query($sql2);
		}
	}
	
	static function getOptions(){
        $cache = Conn::getCache();
		$op_cache = $cache->readCache('options');

        $op_cache['site_title'] = $op_cache['seo_title'] ? $op_cache['seo_title'] : $op_cache['sitename'];
        $op_cache['site_description'] = $op_cache['seo_description'] ? $op_cache['seo_description'] : $op_cache['siteinfo'];
		$op_cache['site_key'] = $op_cache['seo_key'];

        return $op_cache;
    }

	static function getRoute(){//获取路由
		$acstr = self::getAcStr(self::getActions());
        $routes = array(
			array(//系统控制器
				'model'=>'action_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?action=('.$acstr.')([\?&].*)?$}',
				'reg'=>'{^.*/('.$acstr.')(\.html)?$}',
			),
			array(//分类控制器
				'model'=>'sort_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?(sort)=(\d+)(&(page)=(\d+))?([\?&].*)?$}',
				'reg'=>'{^.*/(sort)/([^\./\?=]+)/?([^\./\?=]+)?/?([^\./\?=]+)?/?([^\./\?=]+)?/?((page)/(\d+))?/?([\?&].*)?$}',
			),
			array(//标签控制器
				'model'=>'tag_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?(tag)=([^&]+)(&(page)=(\d+))?([\?&].*)?$}',
				'reg'=>'{^.*/(tag)/([^/?]+)/?((page)/(\d+))?/?([\?&].*)?$}',
			),
			array(//作者控制器
				'model'=>'author_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?(author)=(\d+)(&(page)=(\d+))?([\?&].*)?$}',
				'reg'=>'{^.*/(author)/([^\./\?=]+)/?((page)/(\d+))?/?([\?&].*)?$}',
			),
			array(//搜索控制器
				'model'=>'search_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?(keyword)=([^/&]+)(&(page)=(\d+))?([\?&].*)?$}',
			),
			array(//个人中心控制器
				'model'=>'person_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/(person)/?([^\./\?=]+)?/?((page)/(\d+))?([\?&].*)?$}',
			),
			array(//设置中心控制器
				'model'=>'setting_Control',
				'method'=>'display',
				'reg_1'=>'{^.*/(setting)/?([^\./\?=]+)?/?([\?&].*)?$}',
			),
			array(//主页分页控制器
				'model'=>'art_control',
				'method'=>'disPage',
				'reg_1'=>'{^.*/\?(page)=(\d+)([\?&].*)?$}',
				'reg'=>'{^.*/(page)/(\d+)/?([\?&].*)?$}',
			),
			array(//文章控制器
				'model'=>'art_control',
				'method'=>'display',
				'reg_1'=>'{^.*/\?post=(\d+)(&(say-page)=(\d+))?([\?&].*)?$}',
				'reg_2'=>'{^.*/post-(\d+)\.html(/(say-page)-(\d+))?/?([\?&].*)?$}',
				'reg_3'=>'{^.*?/([^\./\?=]+)(\.html)?(/(say-page)-(\d+))?/?([\?&].*)?$}',
			),
			array(//主页
				'model' => 'art_control',
				'method' => 'disIndex',
				'reg_1' => '{^/?([\?&].*)?$}',
			),
		);
		return $routes;
    }
	
	static function getActions(){//获取系统项
		$cache = Conn::getCache();
		$navs = $cache->readCache('nav');
		$actions = array('login','reset','register','goout','setcache','comments');
		foreach($navs as $nval){
			if($nval['type']==2||$nval['type']==3){$actions[]=$nval['url'];}
		}
        return $actions;
    }
	static function getAcStr($actions){//生成系统项正则‘或’串
		$str=implode("|",$actions);
        return $str;
    }
	
    static function getFileType(){//获取允许上传的附件类型
        return explode(',',self::get('file_type'));
    }

    static function getFileMaxSize(){//获取附件最大限制,单位字节
        return self::get('file_maxsize') * 1024;
    }
	
	static function setOptions($name,$value){//更新配置选项
        $DB = Conn::getConnect();
        $DB->query("UPDATE `". DB_PRE ."options` SET `value`=$value where `key`='$name'");
    }

	static function getRoles(){
		$roles = array('admin'=>'管理员','visitor'=>'访客','writer'=>'作者','vip1'=>'VIP1','vip2'=>'VIP2','vip3'=>'VIP3','vip4'=>'VIP4','vip5'=>'VIP5','vip6'=>'VIP6','vip7'=>'VIP7');
		return $roles;
	}
	
	static function getAlist(){
		$alist = array(
			'write_art'=>array('name'=>'写笔记|write'),
			'article'=>array('name'=>'笔记列表|edit'),
			'sort'=>array('name'=>'分类|list'),
			'bookmark'=>array('name'=>'功能|bookmark','child'=>array('page'=>'页面|page','tag'=>'标签|tag','link'=>'友链|link','file'=>'资源|side')),
			'ulist'=>array('name'=>'用户|user','child'=>array('user'=>'用户|user2','say'=>'评论|chat')),
			'eye'=>array('name'=>'外观|eye','child'=>array('nav'=>'导航|fied','template'=>'模板|tian','banner'=>'轮换图|class')),
			'sys'=>array('name'=>'系统|pass','child'=>array('system'=>'设置|set','data'=>'数据|data','plugin'=>'插件|plugin','store'=>'应用|store')),
		);
		$plist=array();
		$path=IDEA_ROOT .'/content/plugins/';
		$plist['name']='扩展|code';
		$plugins=Control::get('plugins_list');
		foreach($plugins as $val){
			$purl = $path.$val.'/'.$val.'.php';
			$purlset = $path.$val.'/'.$val.'_setting.php';
			if(file_exists($purl)){
				$nonceTplData = @implode('', @file($purl));
				preg_match("/PluginName:(.*)/i", $nonceTplData,$name);//模板名称（缺省文件名命名）
				$temname = !empty($name[1])?trim($name[1]):$val;
				if(file_exists($purlset)){$plist['child']['more_'.$val]=$temname.'|more';}
			}
		}
		$alist['extend']=$plist;
		
		return $alist;
	}
	
	static function gettime(){//时区列表
		$timelist = array(
			'PRC'					=>	'中华人民共和国·北京时间(PRC)',
			'Etc/GMT'				=>	'格林威治(子午线)标准时间 (GMT)',
			'Europe/Berlin'			=>	'中欧标准时间 阿姆斯特丹,荷兰,法国 (GMT +1)',
			'Europe/Bucharest'		=>	'东欧标准时间 布加勒斯特,雅典,希腊 (GMT +2)',
			'Europe/Moscow'			=>	'莫斯科时间 伊拉克,埃塞俄比亚,马达加斯加 (GMT +3)',
			'Asia/Tbilisi'			=>	'第比利斯时间 阿曼,毛里塔尼亚,留尼汪岛 (GMT +4)',
			'Asia/Karachi'			=>	'新德里时间 巴基斯坦,马尔代夫 (GMT +5)',
			'Asia/Novosibirsk'		=>	'科伦坡时间 孟加拉 (GMT +6)',
			'Asia/Bangkok'			=>	'曼谷雅加达 柬埔寨,苏门答腊,老挝 (GMT +7)',
			'Asia/Shanghai'			=>	'北京时间 上海,台北,香港,新加坡,越南 (GMT +8)',
			'Asia/Tokyo'			=>	'东京平壤时间 西伊里安,摩鹿加群岛 (GMT +9)',
			'Pacific/Port_Moresby'	=>	'悉尼关岛时间 塔斯马尼亚岛,新几内亚 (GMT +10)',
			'Pacific/Guadalcanal'	=>	'所罗门群岛 库页岛 (GMT +11)',
			'Pacific/Auckland'		=>	'惠灵顿时间 新西兰,斐济群岛 (GMT +12)',
			'Atlantic/Azores'		=>	'佛德尔群岛 亚速尔群岛,葡属几内亚 (GMT -1)',
			'Atlantic/Cape_Verde'	=>	'(UTC-01:00)佛得角群岛',
			'Etc/GMT+2'				=>	'大西洋中部时间 格陵兰 (GMT -2)',
			'America/Buenos_Aires'	=>	'布宜诺斯艾利斯 乌拉圭,法属圭亚那 (GMT -3)',
			'America/Halifax'		=>	'智利巴西 委内瑞拉,玻利维亚 (GMT -4)',
			'America/New_York'		=>	'纽约渥太华 古巴,哥伦比亚,牙买加 (GMT -5)',
			'America/Guatemala'		=>	'墨西哥城时间 洪都拉斯,危地马拉,哥斯达黎加 (GMT -6)',
			'America/Denver'		=>	'美国丹佛时间 (GMT -7)',
			'America/Santa_Isabel'	=>	'美国旧金山时间 (GMT -8)',
			'America/Anchorage'		=>	'阿拉斯加时间 (GMT -9)',
			'Pacific/Honolulu'		=>	'夏威夷群岛 (GMT -10)',
			'Etc/GMT+11'			=>	'东萨摩亚群岛 (GMT -11)',
			'Etc/GMT+12'			=>	'艾尼威托克岛 (GMT -12)',
		);
		return $timelist;
	}
	
}
?>