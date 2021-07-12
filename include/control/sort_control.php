<?php
/*
**分类页面
*/
class sort_Control{

	function display($params=array()){
		$cache=Conn::getCache();
		$sorts=$cache->readCache('sort');
		//print_r($params);
		$system_cache=Control::getOptions();
		extract($system_cache);
		
		$pnum=count($params)-1;
		$pagenum = Control::get('art_num');
		$pageid = isset($params[$pnum-1])&&$params[$pnum-1]=='page'?abs(intval($params[$pnum])):1;
		$startnum = $pagenum*($pageid-1);
		
		$sortid = '';
        if(!empty($params[2])){
            if(is_numeric($params[2])){
                $sortid=intval($params[2]);
            }else{
                foreach($sorts as $key => $value) {
                    $alias=addslashes(urldecode(trim($params[2])));
                    if(array_search($alias,$value,true)=='alias'){
                        $sortid=$key;break;
                    }
                }
            }
        }
		
		if(!isset($sorts[$sortid])){show_404();}
		
		$sort=$sorts[$sortid];
        $sortName = $sort['sortname'];
        $site_title = $sortName.'-'.$site_title;
		if(!empty($sort['description'])){$site_description=$sort['description'];}
		if(!empty($sort['key'])){$site_key=$sort['key'].','.$site_key;}
		
		if(empty($sort['children'])){
			$rolestr = " AND `s_id`='".$sortid."' ";
		}else{
			$sortids = array_merge(array($sortid),$sort['children']);
			foreach($sort['children'] as $valcd){
				if(!empty($sorts[$valcd]['children'])){
					$sortids = array_merge($sortids,$sorts[$valcd]['children']);
				}
			}
			$rolestr = " AND `s_id` in (". implode(',', $sortids) .")";
        }
		
		$toparts=art_Model::getArtList(1,1,$rolestr." AND mark like '%ST%' ",'',0,4);
		
		$arts=art_Model::getArtList(1,1,$rolestr,'',$startnum,$pagenum);
		$artnumb=art_Model::getArtsNum(1,1,$rolestr,'');
		$pages=ceil($artnumb/$pagenum);
		$urlpre=Url::sort($sortid,$pageid);
		$txtsub='篇笔记';
		
		$pagestr=action_Model::pagelist($artnumb,$pages,$pageid,$urlpre,$txtsub,'');
		
		$template = !empty($sort['template'])&&file_exists(TEMPLATE_PATH .$sort['template'].'.php')?$sort['template']:'list';
		
		include View::getView('header');
        include View::getView($template);
	}
	
}


?>