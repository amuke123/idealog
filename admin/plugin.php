<?php
include_once 'global.php';

Control::getAlist();
$path=IDEA_ROOT .'/content/plugins/';
$pluginlist=getPlugDir($path);

$plugins=Control::get('plugins_list');

$plugin=isset($_GET['plugin'])?$_GET['plugin']:'';


$preopin='sys';
$nextopin='plugin';
if($plugin){
	$preopin='extend';
	$nextopin='more_'.$plugin;
	$purlset = $path.$plugin.'/'.$plugin.'_setting.php';
	if(file_exists($purlset)){
		require_once $purlset;
		if(empty($_POST)){
			$mathe='plugin_setting_view';
		}else{
			$mathe='plugin_setting';
		}
	}
}



if(isset($_POST['add'])){
	$file = $_FILES['pluzip'];
	if(!empty($file["name"])){
		if($file['type']=='application/zip'||$file['type']=='application/x-zip-compressed'||$file['type']=='application/x-zip'){
			$filename = $file['name'];
			$filepath = $path.$filename;
			$res = move_uploaded_file($file['tmp_name'],$filepath);
			$zip = new ZipArchive();
			if($zip->open($filepath) === true){
				$temlist2=getDir($path);
				$wjj=$zip->statIndex(0);
				$wjjname=trim($wjj['name'],'/');
				if($wjjname!=strstr($filename,'.',true)){
					$tstxt="安装的插件错误或不完整";
					$tsurl=ADMIN_URL ."plugin.php";
				}else{
					if(in_array($wjjname,$temlist2)){
						$tstxt="安装失败，插件命名冲突或安装的插件已存在";
						$tsurl=ADMIN_URL ."plugin.php";
					}else{
						$files1=array($wjjname.'/');
						$files2=array();
						$filearr=array($wjjname);
						foreach($filearr as $vfas){
							$files1[] = $wjj['name'].$vfas.'.php';
						}
						for($i=0;$i<$zip->numFiles;$i++){
							$files2[] = $zip->statIndex($i)['name'];
						}
						$flag = 1;
						foreach($files1 as $va){
							if(in_array($va,$files2)){continue;}else{$flag = 0;break;}
						}
						if($flag){
							$zip->extractTo($path);
							$tstxt="模板安装成功";
							$tsurl=ADMIN_URL ."plugin.php";
						}else{
							$tstxt="安装的模板错误或不完整";
							$tsurl=ADMIN_URL ."plugin.php";
						}
					}
				}
			}else{
				$tstxt="安装模板失败";
				$tsurl=ADMIN_URL ."plugin.php?action=install";
			}
			$zip->close();
			unlink($filepath);
		}else{
			$tstxt="格式错误，请上传压缩格式为zip的模板安装包";
			$tsurl=ADMIN_URL ."plugin.php?action=install";
		}
	}else{
		$tstxt="请先选择模板";
		$tsurl=ADMIN_URL ."plugin.php?action=install";
	}
	echo "<script>alert('".$tstxt."');location.href='".$tsurl."';</script>";
}




include View::getViewA('header');
require_once(View::getViewA('plugin'));
include View::getViewA('footer');
View::output();

?>