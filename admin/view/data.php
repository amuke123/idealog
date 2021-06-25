<div class="main" id="main">
	<div class="content">
		<?php $code=Checking::getAjCode(12);?>
		<div class="m_title">数据管理</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>备份文件</b><b>备份时间</b><b>文件大小</b><b>操作</b></p>
					<?php foreach($dblist as $value){?>
						<p>
						<span><input type="checkbox" name="artck[]" value="<?php echo urlencode($value['name']);?>" /></span>
						<span class="tleft"><?php echo $value['name'];?></span>
						<span><?php echo $value['date'];?></span>
						<span><?php echo round($value['size']/1024,2) ." KB";?></span>
						<span><a href="<?php echo $value['url'].$value['name'];?>">下载</a> <a href="javascript:void(0);" onclick="setdbname(this)">导入</a></span>
						</p>
					<?php }?>
				</div>
				<div class="m_set">
					<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：<a class="red" href="javascript:delbak('<?php echo IDEA_URL;?>');">删除</a> 
				</div>
			</form>
		</div>
		<div class="m_content">
			<div class="navlist" id="navlist">
				<ul>
					<li><a href="javascript:void(0);" onclick="changeSet(1)">备份数据库+</a></li>
					<li><a href="javascript:void(0);" onclick="changeSet(2)">导入本地备份+</a></li>
					<li><a href="javascript:void(0);" onclick="changeSet(3)">更新缓存+</a></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="cont mc_data">
				<div class="cont3" id="cont1">
					<p><span>将站点所使用的数据表备份到服务器空间，备份时将会通过表前缀过滤掉无当前表前缀的数据表（表前缀为空时备份整个数据库）。</span></p>
					<p><span>当前数据库表前缀：<?php echo DB_PRE;?></span></p><p></p>
					<p><a href="javascript:databak('<?php echo $code;?>');">开始备份</a></p>
				</div>
				<div class="cont3" id="cont2">
					<p><span>仅可导入同版本ideslog导出的数据库备份文件，且数据库表前缀需保持一致。</span></p>
					<p><span>当前数据库表前缀：<?php echo DB_PRE;?></span></p><p></p>
					<form action="?action=import" enctype="multipart/form-data" method="post" name="myimport">
						<div class="group"><p><input type="file" class="formfile" required name="file" /></p></div>
						<input type="hidden" name="dbname" id="dbname" />
						<input type="hidden" name='token' value="<?php echo $code;?>" />
						<p class="m_button"><input type="submit" class="m_sub" value="导入"></p>
					</form>
				</div>
				<div class="cont3" id="cont3">
					<p><span>缓存可以加快站点的加载速度。通常系统会自动更新缓存，无需手动。有些特殊情况，比如缓存文件被修改、手动修改过数据库、页面出现异常等才需要手动更新。</span></p><p></p>
					<p><a href="<?php echo Url::getActionUrl('setcache');?>">更新缓存</a></p>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('sys','data');
	changeSet(1);
}
</script>