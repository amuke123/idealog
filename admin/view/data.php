<div class="main" id="main">
	<div class="content">
		<div class="m_title">数据</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>备份文件</b><b>备份时间</b><b>文件大小</b><b></b></p>
					<?php foreach($dblist as $value){?>
						<p>
						<span><input type="checkbox" name="artck[]" value="<?php echo $value['name'];?>" /></span>
						<span><a href="<?php echo $value['url'].$value['name'];?>"><?php echo $value['name'];?></a></span>
						<span><?php echo $value['date'];?></span>
						<span><?php echo $value['size']/1024 ." KB";?></span>
						<span><a href="#">导入</a></span>
						</p>
					<?php }?>
				</div>
				<div class="m_set">
					<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：<a class="red" href="javascript:delArt('<?php echo IDEA_URL;?>');">删除</a> 
				</div>
			</form>
		</div>
		<div class="m_content">
			<div class="navlist" id="navlist">
				<ul>
					<li><a href="javascript:void(0);" onclick="changeSet(1)">备份数据库+</a></li>
					<li><a href="javascript:void(0);" onclick="changeSet(2)">导入本地备份+</a></li>
					<li><a href="javascript:void(0);" onclick="changeSet(3)">更新缓存+</a></li>
					<li><a href="javascript:void(0);" onclick="changeSet(4)"></a></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="cont mc_data">
				<div class="cont3" id="cont1">
					<p>将站点内容数据库备份到服务器空间</p>
					<p><a href="">开始备份</a></p>
				</div>
				<div class="cont3" id="cont2">
					<p>仅可导入相同版本ideashu导出的数据库备份文件，且数据库表前缀需保持一致。</p>
					<p>当前数据库表前缀：<?php echo DB_PRE;?></p>
					<p><a href="">导入</a></p>
				</div>
				<div class="cont3" id="cont3">
					<p>缓存可以加快站点的加载速度。通常系统会自动更新缓存，无需手动。有些特殊情况，比如缓存文件被修改、手动修改过数据库、页面出现异常等才需要手动更新。</p>
					<p><a href="<?php echo Url::getActionUrl('setcache');?>">更新缓存</a></p>
				</div>
				<div class="cont3" id="cont4"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('sys','data');
	showurl("0");
}
</script>