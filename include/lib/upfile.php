<?php
class Upfile{
	private $db;
	private $save_path;
	private $save_url;
	private $ext_arr;
	private $max_size;
	private $img_arr;
	//ini_get('upload_max_filesize');
	function __construct(){
        $this->db = Conn::getConnect();
		$this->save_path = IDEA_ROOT . '/content/uploadfile/';
		$this->save_url =  'content/uploadfile/';
		$this->ext_arr = explode(',',Control::get('file_type'));
		$this->max_size = (Control::get('file_maxsize')*1024)*1024;
		$this->img_arr = array("jpg","jpeg","gif","png");
    }
	
	function getFileList($filedata){//多文件格式化
		$files=array();
		if(count($filedata['file']['name'])>1){
			$num=count($filedata['file']['name']);
			for($i=0;$i<$num;$i++){
				$files[$i]['name']=$filedata['file']['name'][$i];
				$files[$i]['type']=$filedata['file']['type'][$i];
				$files[$i]['tmp_name']=$filedata['file']['tmp_name'][$i];
				$files[$i]['error']=$filedata['file']['error'][$i];
				$files[$i]['size']=$filedata['file']['size'][$i];
			}
		}else{
			if(!empty($filedata['file']['name'][0])){
				$files[0]['name']=$filedata['file']['name'][0];
				$files[0]['type']=$filedata['file']['type'][0];
				$files[0]['tmp_name']=$filedata['file']['tmp_name'][0];
				$files[0]['error']=$filedata['file']['error'][0];
				$files[0]['size']=$filedata['file']['size'][0];
			}
		}
		return $files;
	}
	
	function upload($file,$aid='',$dir_name='',$tem = 0,$fhtem=0){//file 文件，aid 所属文章，dir_name 非文章分类,$tem 保存到附件库,$fhtem 返回缩略图开关
		$this->save_path = IDEA_ROOT . '/content/uploadfile/';
		$this->save_url =  'content/uploadfile/';
		
		$file_name = $file['name'];//原文件名
		$tmp_name = $file['tmp_name'];//服务器上临时文件名
		$file_size = $file['size'];//文件大小
		
		if($file['error'] == 1){return "上传文件大小超过系统".ini_get('upload_max_filesize')."限制。";}
		
		if(!$file_name){return $file_name."请选择文件。";}//检查文件名
		if(@is_dir($this->save_path) === false){return $file_name."上传目录不存在。";}//检查目录
		if(@is_writable($this->save_path) === false){return $file_name."上传目录没有写权限。";}//检查目录写权限
		if(@is_uploaded_file($tmp_name) === false){return $file_name."上传失败。";}//检查是否已上传
		if($file_size > $this->max_size){return $file_name."上传文件大小超过限制。";}//检查文件大小
		//获得文件扩展名
		$temp_arr = explode(".",$file_name);
		$file_ext = array_pop($temp_arr);
		$file_ext = trim($file_ext);
		$file_ext = strtolower($file_ext);
		if(in_array($file_ext,$this->ext_arr) === false){return $file_name."上传文件类型不被允许。";}//检查扩展名
		//创建文件夹
		if($dir_name != ''){
			$this->save_path .= $dir_name . "/";
			$this->save_url .= $dir_name . "/";
			$tmp_pre = $dir_name."_";
		}else{
			$ymd = date("Ymd");
			$this->save_path .= $ymd . "/";
			$this->save_url .= $ymd . "/";
			$tmp_pre = '';
		}
		if(!file_exists($this->save_path)){mkdir($this->save_path);}
		$new_path=$this->save_path;//新路径
		$new_url=$this->save_url;//新链接
		$new_file_name = $tmp_pre.time().rand(10000,99999).'.'.$file_ext;//新文件名
		//移动文件
		$file_path = $new_path . $new_file_name;
		if(move_uploaded_file($tmp_name,$file_path) === false){return $file_name."上传文件失败。";}
		@chmod($file_path,0644);
		$file_url = $new_url . $new_file_name;
		if($tem){
			$temp_name='';
			foreach($temp_arr as $value){
				$temp_name.= $value.".";
			}
			$temp_name=trim($temp_name,'.');
			
			$filedata=array();
			$filedata['a_id']= $aid;
			$filedata['name']= $temp_name;
			$filedata['size']= $file_size;
			$filedata['path']= "../".$file_url;
			$filedata['addtime']= time();
			$filedata['type']= $file["type"];
			//图片文件获取尺寸
			$temp_w=-1;
			$temp_h=-1;
			if(in_array($file_ext,$this->img_arr)){
				$sizearr=getimagesize(IDEA_URL .$file_url);
				$temp_w=$sizearr[0];
				$temp_h=$sizearr[1];
			}
			$filedata['width'] = $temp_w;
			$filedata['height'] = $temp_h;
			$filedata['top_id'] = "0";
			$fhz=$this->set_db($filedata,$new_path,$new_url,$file_ext,$tmp_pre);
			$fhz=$fhz==''?$filedata['path']:$fhz;
		}else{
			$fhz="../".$file_url;
		}
		return $fhtem=='0'?"../".$file_url:$fhz;//返回原图，$fhz 缩略图
	}
	function set_db($datas,$new_path='',$new_url='',$file_ext='',$tmp_pre=''){
		$tags='';
		$values='';
		foreach($datas as $key => $val){
			$tags .= '`'.$key.'`,';
			$values .= "'".$val."',";
		}
		$tags=trim($tags,',');
		$values=trim($values,',');
		$sql="INSERT INTO `". DB_PRE ."file` (`id`,".$tags.") VALUES (NULL,".$values.")";
		$this->db->query($sql);
		$fhz='';
		if(Control::get('thumbnailok')&&$datas['top_id']==0){
			$czid=$this->db->last_insert_id();
			$_w=$datas['width'];
			$_h=$datas['height'];
			if($this->checkImg($_w,$_h)){
				$fhz=$this->setThem($datas,$new_path,$new_url,$file_ext,$tmp_pre,$czid);
			}
		}
		return $fhz;
	}
	
	function setThem($datas,$new_path,$new_url,$file_ext,$tmp_pre,$czid){
		$im=str_replace('../',IDEA_URL,$datas['path']);
		$_w=$datas['width'];
		$_h=$datas['height'];
		$thum_w=Control::get('thum_imgmaxw');
		$thum_h=Control::get('thum_imgmaxh');
		echo $thum_w."-".$thum_h;
		if(($thum_w*$_h)/$thum_h > $_w){
			$new_h=$thum_h;
			$new_w=($new_h*$_w)/$_h;
		}else{
			$new_w=$thum_w;
			$new_h=($_h*$new_w)/$_w;
		}
		$new_them_name = 'them_';
		$new_them_name .= $tmp_pre;
		$new_them_name .= time().rand(10000,99999).'.'.$file_ext;
		$savePath=$new_path.$new_them_name;
		
		$new_im=imagecreatetruecolor($new_w,$new_h);
		
		$iminfor=getimagesize($im);
		switch($iminfor['mime']){
			case 'image/jpeg' : $img=imagecreatefromjpeg($im);break;
			case 'image/png' : $img=imagecreatefrompng($im);break;
			case 'image/gif' : $img=imagecreatefromgif($im);break;
			default : $img='';break;
		}
		if($img!=''){
			imagecopyresized($new_im,$img,0,0,0,0,$new_w,$new_h,$_w,$_h);
			
			switch($iminfor['mime']){
				case 'image/jpeg' : imagejpeg($new_im,$savePath);break;
				case 'image/png' : imagepng($new_im,$savePath);break;
				case 'image/gif' : imagegif($new_im,$savePath);break;
				default : break;
			}
			
			$datas2=array();
			$datas2['a_id']= $datas['a_id'];
			$datas2['name']= 'thum_'.$datas['name'];
			$datas2['size']= filesize($savePath);
			$datas2['path']= "../".$new_url.$new_them_name;
			$datas2['addtime']= time();
			$datas2['type']= $datas['type'];
			$datas2['width'] = $new_w;
			$datas2['height'] = $new_h;
			$datas2['top_id'] = $czid;
			$this->set_db($datas2);
			$fhz=$datas2['path'];
		}else{
			$fhz=='';
		}
		return $fhz;
	}
	
	function checkImg($_w,$_h){
		$thum_w=Control::get('thum_imgmaxw');
		$thum_h=Control::get('thum_imgmaxh');
		return ($_w>$thum_w || $_h>$thum_h)?'1':'0';
	}
	
}
?>