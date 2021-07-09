<?php
/*
**文章页面
*/
class art_Control{
	function disIndex($params=array()){
		//echo "首页<pre>";
		//print_r($params);
		$system_cache=Control::getOptions();
		extract($system_cache);
		$site_title = $seo_type!=3 ? $sitename : $seo_title ;
		$banners=Control::get('banner_list');
		
		
		include View::getView('header');
        include View::getView('index');
	}
	
	function display($params=array()){
		//print_r($params);
		$cache=Conn::getCache();
		$artalias_cache=$cache->readCache('artalias');
		$system_cache=Control::getOptions();
		extract($system_cache);
		
		$aid=0;
        if(isset($params[1])){
            if($params[1]=='post'){
                $aid=isset($params[2])?intval($params[2]):0;
            }else if(is_numeric($params[1])){
                $aid=intval($params[1]);
            }else{
                if(!empty($artalias_cache)) {
                    $alias=addslashes(urldecode(trim($params[1])));
                    $aid=array_search($alias,$artalias_cache);
                }
            }
        }
		if(!$aid){show_404();}
		$artData=art_Model::getlogArt($aid);
		if($artData === false){show_404();}
		extract($artData);
		
		switch($seo_type){
            case '1':$site_title=$art_title;break;
            case '2':$site_title=$art_title.'-'.$sitename;break;
            case '3':$site_title=$art_title.'-'.$site_title;break;
        }
		$des=$art_excerpt==''?strip_tags(htmlspecialchars_decode($art_content)):strip_tags($art_excerpt);
        $site_description = mb_substr(trim($des),0,90);
		if($art_key!=''){$site_key=$art_key.','.$site_key;}
        $tagsarr=$art_tags==''?'':tag_Model::getArtTagList($art_tags);
        if(!empty($tagsarr)){
            foreach($tagsarr as $valuetag) {
                $site_key.=','.$valuetag['tagname'];
            }
        }
		$site_key=str_replace('，',',',$site_key);
		
		$pnum=count($params)-1;
		$pageid = isset($params[$pnum-1])&&$params[$pnum-1]=='say-page'?abs(intval($params[$pnum])):1;

		$verifyCode=Control::get('say_code')=='1'? '<input type="text" name="imgcode" placeholder="验证码" tabindex="5"><img src="'.IDEA_URL .'include/core/code.php?ac=1" align="absmiddle" onclick="this.src=this.src+Math.floor(Math.random()*10);">' : '';
		$ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
        $ckmail = isset($_COOKIE['postermail']) ? htmlspecialchars($_COOKIE['postermail']) : '';
        $ckurl = isset($_COOKIE['posterurl']) ? htmlspecialchars($_COOKIE['posterurl']) : '';
		$allow_remark=$art_sayok;
		
		$sayok=Control::get('say_page');
		$order=Control::get('say_order')?"DESC":"ASC";
		if($sayok){
			$pagenum=Control::get('say_pnum');
			$startnum=$pagenum*($pageid-1);
			$comments=say_Model::getSays2($aid,'',$startnum,$pagenum,'0',$order);
		}else{
			$pagenum=0;
			$comments=say_Model::getSays2($aid,'',0,0,'0',$order);
		}
		//print_r($comments);
		
		$counts=say_Model::getSayNum($aid,'','0','1','1');
		$pages=$pagenum==0?0:ceil($counts/$pagenum);
		$urlpre=Url::saypre($aid);
		//echo $urlpre;
		$txtsub='条评论';
		
		$pagestr=action_Model::pagelist($counts,$pages,$pageid,$urlpre,$txtsub,'','0','#comments');
		//echo $pagestr;
		if($art_type=='a'){
			art_Model::upEyes($aid);
			$neighbour=art_Model::getNeighbour($art_date);
			include View::getView('header');
			include View::getView('article');
		}else if($art_type=='p'){
			$template=!empty($art_template)&&file_exists(TEMPLATE_PATH .$art_template.'.php')?$art_template:'page';
			include View::getView('header');
			include View::getView($template);
		}
	}
	
	function disPage($params=array()){
		//echo "首页文章分页<pre>";
		//print_r($params);
		$system_cache=Control::getOptions();
		extract($system_cache);
		
	}
	
	
	
}


?>