<?php
class Sitemap{
	
	static function setXml($sitemap_name,$key=false){
		$data = self::getData();
		$path = IDEA_ROOT .'/'.$sitemap_name.'.xml';
		$path2 = IDEA_ROOT .'/'.$sitemap_name.'.html';
		$path3 = IDEA_ROOT .'/'.$sitemap_name.'.txt';
		
		$xml = self::buildXML($data);
		$html = self::buildHTML($data);
		$txt = self::buildTXT($data);
		
		/**if(!is_file($path)||(time()-24*3600)>filemtime($path)){
			@file_put_contents($path,$xml);
		}
		if(!is_file($path2)||(time()-24*3600)>filemtime($path2)){
			@file_put_contents($path2,$html);
		}
		if(!is_file($path3)||(time()-24*3600)>filemtime($path3)){
			@file_put_contents($path3,$txt);
		}**/
		//if($key){}
		@file_put_contents($path,$xml);
		@file_put_contents($path2,$html);
		@file_put_contents($path3,$txt);
	}
	static function getData(){
		$cache = Conn::getCache();
		$db=Conn::getConnect();
		$lastSayTime = self::getLastSayTime();
		$data = array();
		$data[] = array('url'=>IDEA_URL,'lastmod'=>time(),'changefreq'=>'always','priority'=>'1.0');
		//笔记
		$query = $db->getlist("SELECT `id`,`date` FROM `". DB_PRE ."article` WHERE `type`='a' AND `show`='1' AND `check`='1' ORDER BY `date` DESC");
		if(!empty($query)){foreach($query as $row){
			$lastmod = isset($lastSayTime[$row['id']])?$lastSayTime[$row['id']]:($row['date']==''?time():$row['date']);
			$data[] = array('url'=>Url::log($row['id']),'lastmod'=>$lastmod,'changefreq'=>'weekly','priority'=>'0.8');
		}}
		//页面
		$query = $db->getlist("SELECT `id`,`date` FROM `". DB_PRE ."article` WHERE `type`='p' AND `show`='1' AND `check`='1' ORDER BY date DESC");
		if(!empty($query)){foreach($query as $row){
			$lastmod = isset($lastSayTime[$row['id']])?$lastSayTime[$row['id']]:($row['date']==''?time():$row['date']);
			$data[] = array('url'=>Url::log($row['id']),'lastmod'=>$lastmod,'changefreq'=>'daily','priority'=>'0.8');
		}}
		//分类
		foreach($cache->readCache('sort') as $value){
			$data[] = array('url'=>Url::sort($value['id']),'lastmod'=>time(),'changefreq'=>'daily','priority'=>'0.8');	
		}
		//标签
		foreach($cache->readCache('tags') as $value){
			$data[] = array('url'=>Url::tag($value['tagurl']),'lastmod'=>time(),'changefreq'=>'daily','priority'=>'0.8');
		}
		//导航
		foreach($cache->readCache('nav') as $value){
			if($value['show']=='1'&&$value['type']!='1'){$data[] = array('url'=>Url::nav($value['type'],$value['typeId'],$value['url']),'lastmod'=>time(),'changefreq'=>'daily','priority'=>'0.8');}
		}
		//作者
		$query = $db->getlist("SELECT `id`,`date`,`lastdate` FROM `". DB_PRE ."user` WHERE `check`='1' ORDER BY `lastdate` DESC,`date` DESC");
		if(!empty($query)){foreach($query as $row){
			$lastmod = !empty($row['lastdate'])?$row['lastdate']:($row['date']==''?time():$row['date']);
			$data[] = array('url'=>Url::author($row['id']),'lastmod'=>$lastmod,'changefreq'=>'daily','priority'=>'0.8');
		}}
		
		return $data;
	}
	static function buildTXT($data){
		$txt = "";
		foreach($data as $value){
			extract($value);
			$txt .= htmlspecialchars($url)."\n";
		}
		return $txt;
	}

	static function buildHTML($data){
		$html = "<html><head><meta charset='utf-8'><title>". SITE_NAME ." - 站点地图</title></head><body><h1>". SITE_NAME ." - 站点地图</h1>";
		foreach($data as $value) {
			extract($value);
			$html .= self::generate2($url);
		}
		$html .= '</body></html>';
		return $html;
	}
	static function generate2($url) {
		$url = htmlspecialchars($url);
		return '<p><a href="'.$url.'">'.$url.'</a></p>';
	}
	static function buildXML($data){
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach($data as $value) {
			extract($value);
			$xml .= self::generate($url,$lastmod,$changefreq,$priority);
		}
		$xml .= '</urlset>';
		return $xml;
	}
	static function generate($url,$lastmod,$changefreq,$priority) {
		$url = htmlspecialchars($url);
		$lastmod = gmdate('c',$lastmod);
		return "<url>\n<loc>$url</loc>\n<lastmod>$lastmod</lastmod>\n<changefreq>$changefreq</changefreq>\n<priority>$priority</priority>\n</url>\n";
	}
	static function getLastSayTime(){
		$db=Conn::getConnect();
		$query = $db->getlist("SELECT a_id,max(date) as date FROM ". DB_PRE ."comment	WHERE check='1' and show='1' GROUP BY a_id");
		$lastSayTime = array();
		if(!empty($query)){
			foreach($query as $row){
				$lastSayTime[$row['a_id']] = $row['date'];
			}
		}
		return $lastSayTime;
	}
}
?>