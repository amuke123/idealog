<?php
class Cache{
	private $db;
	function __construct(){
        $this->db = Conn::getConnect();
    }
	
	function updateCache($cacheDB = null){//更新缓存
		if(is_string($cacheDB)) {
            if(method_exists($this,'ch_'.$cacheDB)){
                call_user_func(array($this,'ch_'.$cacheDB));
            }
            return;
        }
		if(is_array($cacheDB)){
            foreach($cacheDB as $name){
                if(method_exists($this,'ch_'.$name)){
                    call_user_func(array($this,'ch_'.$name));
                }
            }
            return;
        }
		if($cacheDB == ''){
            $cacheDB = get_class_methods($this);
            foreach($cacheDB as $method){
                if(preg_match('/^ch_/',$method)){
                    call_user_func(array($this,$method));
                }
            }
        }
	}
	
	private function ch_options() {//系统配置缓存
        $options_cache = array();
        $sql = "SELECT * FROM " . DB_PRE . "options";
		$row = $this->db->getlist($sql);
		foreach($row as $val){
            if (in_array($val['key'], array('site_key', 'blogname', 'bloginfo', 'blogurl', 'icp'))) {
                $val['value'] = htmlspecialchars($val['value']);
            }
            $options_cache[$val['key']] = $val['value'];
        }
        $cacheData = serialize($options_cache);
        $this->cacheWrite($cacheData, 'options');
    }
	
	private function ch_sort(){//分类缓存
        $sort_cache = array();
        $query = $this->db->getlist("SELECT * FROM `". DB_PRE ."sort` ORDER BY `top_id` ASC,`index` ASC");
        foreach($query as $row){
            $data = $this->db->getOnce("SELECT COUNT(*) AS total FROM `". DB_PRE ."article` WHERE `s_id`=". $row['id'] ." AND `show`='1' AND `check`='1' AND type='a'");
            $logNum = $data['total'];
            $sortData = array(
                'artnum' => $logNum,
                'sortname' => htmlspecialchars($row['name']),
                'description' => htmlspecialchars($row['description']),
				'key' => htmlspecialchars($row['key']),
                'alias' =>$row['alias'],
                'id' => intval($row['id']),
                'group' => intval($row['group']),
                'index' => intval($row['index']),
                'top_id' => intval($row['top_id']),
                'template' => htmlspecialchars($row['template']),
				'pic' => htmlspecialchars($row['pic']),
            );
			if($row['top_id']==0){
				$sortData['children'] = array();
			}else if(isset($sort_cache[$row['top_id']])){
				$sort_cache[$row['top_id']]['children'][]=$row['id'];
			}
            $sort_cache[$row['id']] = $sortData;
        }
        $cacheData = serialize($sort_cache);
        $this->cacheWrite($cacheData, 'sort');
    }
	
	private function ch_tags(){//标签缓存
        $tag_cache = array();
        $hideAids = array();
		$hidesql="SELECT `id` FROM `". DB_PRE ."article` where (`show`='0' or `check`='0') and type='a'";
        $hiderow = $this->db->getlist($hidesql);
        foreach($hiderow as $hideval){
            $hideAids[] = $hideval['id'];
        }
        $tagrow = tag_Model::getAllTags();
		foreach($tagrow as $show_tag){
            foreach ($hideAids as $hval) {
                $show_tag['a_id'] = str_replace(','.$hval.',', ',' , $show_tag['a_id']);
				$show_tag['a_id'] = str_replace($hval.',', '' , $show_tag['a_id']);
				$show_tag['a_id'] = str_replace(','.$hval, '' , $show_tag['a_id']);
				$show_tag['a_id'] = str_replace($hval, '' ,$show_tag['a_id']);
            }
            if($show_tag['a_id'] == ''){continue;}
            $artnum = substr_count($show_tag['a_id'],',') + 1;
            $tag_cache[$show_tag['id']] = array(
				'tagurl' => urlencode($show_tag['name']),
				'tagname' => htmlspecialchars($show_tag['name']),
				'color' => "rgb(".mt_rand(100,200).",".mt_rand(100,200).",".mt_rand(100,200).")",
				'artnum' => $artnum,
				'id' => $show_tag['id'],
				'a_id' => $show_tag['a_id'],
            );
        }
        $cacheData = serialize($tag_cache);
        $this->cacheWrite($cacheData, 'tags');
    }
	
	private function ch_userdiy(){//用户个性域名缓存
		$sql = "SELECT `id`,`diyurl` FROM `". DB_PRE ."user` where `diyurl`!=''";
        $row = $this->db->getlist($sql);
        $useralias_cache = array();
        foreach($row as $val){
            $useralias_cache[$val['id']]=htmlspecialchars($val['diyurl']);
        }
        $cacheData = serialize($useralias_cache);
        $this->cacheWrite($cacheData, 'userdiy');
	}
	
	private function ch_artalias(){//笔记别名缓存
		$sql = "SELECT `id`,`alias` FROM `". DB_PRE ."article` where `alias`!=''";
        $row = $this->db->getlist($sql);
        $artalias_cache = array();
        foreach($row as $val){
            $artalias_cache[$val['id']]=$val['alias'];
        }
        $cacheData = serialize($artalias_cache);
        $this->cacheWrite($cacheData, 'artalias');
	}
	
	private function ch_artsort(){//笔记分类缓存
        $sql = "SELECT `id`,`s_id` FROM `". DB_PRE ."article` where `type`='a'";
        $row = $this->db->getlist($sql);
        $artsort_cache = array();
        foreach($row as $val){
            if($val['s_id'] > 0){
				$sql1="SELECT `id`,`name`,`alias` FROM `". DB_PRE ."sort` where `id`=". $val['s_id'];
                $srow = $this->db->getOnce($sql1);
                $artsort_cache[$val['id']] = array(
                    'name' => htmlspecialchars($srow['name']),
                    'id' => $srow['id'],
                    'alias' => htmlspecialchars($srow['alias']),
                );
            }
        }
        $cacheData = serialize($artsort_cache);
        $this->cacheWrite($cacheData, 'artsort');
    }
	
	private function ch_nav(){//导航缓存
        $nav_cache = array();
        $navlist = $this->db->getlist("SELECT * FROM `". DB_PRE ."nav` ORDER BY `group` ASC,`top_id` ASC,`index` ASC,`id` DESC");
        $sorts = $this->readCache('sort');
        foreach($navlist as $row){
            $children = array();
            if($row['type'] == nav_Model::navtype_sort && !empty($sorts[$row['type_id']]['children'])){
                foreach($sorts[$row['type_id']]['children'] as $sortid){
                    $children[] = $sorts[$sortid];
                }
            }
            $navData = array(
				'id' => intval($row['id']),
				'name' => htmlspecialchars(trim($row['name'])),
				'url' => htmlspecialchars(trim($row['url'])),
				'pic' => htmlspecialchars(trim($row['pic'])),
				'blank' => intval($row['blank']),
				'change' => intval($row['change']),
				'type' => intval($row['type']),
				'typeId' => intval($row['type_id']),
				'index' => intval($row['index']),
				'show' => intval($row['show']),
				'top_id' => intval($row['top_id']),
				'group' => intval($row['group']),
				'children' => $children,
            );
            if($row['type'] == nav_Model::navtype_custom) {
                if($navData['top_id'] == 0) {
                    $navData['childnav'] = array();
                }else if(isset($nav_cache[$row['top_id']])){
                    $nav_cache[$row['top_id']]['childnav'][] = $row['id'];
                }
            }
            $nav_cache[$row['id']] = $navData;
        }
        $cacheData = serialize($nav_cache);
        $this->cacheWrite($cacheData, 'nav');
    }
	
	private function ch_sta(){//站点统计缓存
		$sta_cache = array();
		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE `type`='a' AND `show`='1' AND `check`='1' ");
		$artnum = $data['total'];//显示且已审核的笔记

		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE `type`='a' AND `show`='0'");
		$hidenum = $data['total'];//隐藏的笔记

		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE `type`='a' AND `show`='1' AND `check`='0' ");
		$checknum = $data['total'];	//显示但未审核的笔记

		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `show`='1' AND `check`='1' ");
		$saynum = $data['total'];//显示且已审核的评论

		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `show`='0' ");
		$hidesay = $data['total'];//隐藏的评论
		
		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `show`='1' AND `check`='0' ");
		$checksay = $data['total'];//显示但未审核的评论

		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `show`='1' AND `check`='1' AND `mark`='2' ");
		$godsay = $data['total'];//神评
		
		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `show`='1' AND `check`='1' AND `mark`='1' ");
		$topsay = $data['total'];//精评
		
		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "user ");
		$usernum = $data['total'];//注册用户
		
		$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "tags ");
		$tagsnum = $data['total'];//标签

		$sta_cache = array(
			'artnum' => $artnum,
			'hidenum' => $hidenum,
			'checknum' => $checknum,
			'sayall' => $saynum+$hidesay+$checksay,
			'saynum' => $saynum,
			'hidesay' => $hidesay,
			'checksay' => $checksay,
			'godsay' => $godsay,
			'topsay' => $topsay,
			'usernum' => $usernum,
			'tagsnum' => $tagsnum,
		);

		$reset = $this->db->getlist("SELECT `id` FROM " . DB_PRE . "user ");
		foreach($reset as $row){
			$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE author='".$row['id']."' AND `type`='a' AND `show`='1' AND `check`='1' ");
			$artnumA = $data['total'];//显示并通过审核的笔记
			
			$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE author='".$row['id']."' AND `type`='a' AND `show`='1' AND `check`='0' ");
			$checknumA = $data['total'];//显示但未通过审核的笔记

			$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "article WHERE author='".$row['id']."' AND `type`='a' AND `show`='0'");
			$hidenumA = $data['total'];//隐藏的笔记

			$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment AS s," . DB_PRE . "article AS a WHERE s.`a_id` = a.`id` AND a.`author`='".$row['id']."' ");
			$getsayA = $data['total'];//收到的评论

			$data = $this->db->getOnce("SELECT COUNT(*) AS total FROM " . DB_PRE . "comment WHERE `posterid`='".$row['id']."' ");
			$sendsayA = $data['total'];//发出的评论

			$sta_cache[$row['id']] = array(
				'artnum' => $artnumA,
				'checknum' => $checknumA,
				'hidenum' => $hidenumA,
				'getsaynum' => $getsayA,
				'sendsaynum' => $sendsayA,
			);
		}
		$cacheData = serialize($sta_cache);
		$this->cacheWrite($cacheData, 'sta');
	}
	
    function cacheWrite($cacheData, $cacheName){//写入缓存
        $cachefile = IDEA_ROOT .'/content/cache/mc_'.$cacheName.'.php';
        $cacheData = "<?php exit;//" . $cacheData;
        @ $fp = fopen($cachefile,'wb') OR mkMsg('读取缓存失败。请修改目录 (content/cache) 读写权限');
        @ $fw = fwrite($fp,$cacheData) OR mkMsg('写入缓存失败，缓存目录 (content/cache) 不可写');
        fclose($fp);
    }

    function readCache($cacheName){//读取缓存
		$cachefile = IDEA_ROOT .'/content/cache/mc_'.$cacheName.'.php';
		// 如果缓存文件不存在则自动生成缓存文件
		if(!is_file($cachefile) || filesize($cachefile) <= 0){
			$this->updateCache($cacheName);
		}
		if((time()-3600)>filemtime($cachefile)){//更新间隔1个小时,7*24*3600为七天
			$this->updateCache($cacheName);
		}
		if($fp = fopen($cachefile,'r')){
			$data = fread($fp, filesize($cachefile));
			fclose($fp);
			clearstatcache();
			$cacheDate = unserialize(str_replace("<?php exit;//", '', $data));
			return $cacheDate;
		}
    }

}

?>