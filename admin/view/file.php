<div class="main" id="main">
	<div class="content">
		<div class="m_title">资源管理</div>
		<?php $code=Checking::getAjCode(12);?>
		<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
		<div class="m_tab">
			<ul>
				<li><?php echo $type!=''?'<a href="file.php'.$urlhz.'">全部资源</a>':'<span>全部资源</span>';?></li>
				<li><?php echo $type!='image'?'<a href="?type=image'.$urlsub.'">图片</a>':'<span>图片</span>';?></li>
				<li><?php echo $type!='audio'?'<a href="?type=audio'.$urlsub.'">音频</a>':'<span>音频</span>';?></li>
				<li><?php echo $type!='video'?'<a href="?type=video'.$urlsub.'">视频</a>':'<span>视频</span>';?></li>
				<li><?php echo $type!='other'?'<a href="?type=other'.$urlsub.'">其他文件</a>':'<span>其他文件</span>';?></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div class="m_li">
			<?php if(!empty($list)){?>
			<ul>
				<?php 
				foreach($list as $val){
					if(strstr($val['type'],'image/')){$types='image';}
					else if(strstr($val['type'],'audio/')){$types='audio';}
					else if(strstr($val['type'],'video/')){$types='video';}
					else{$types='file';}
				?>
				<li>
					<div class="m_li_img m_bg<?php echo $types;?>"><b><?php echo strtoupper($types);?></b><?php if($types=='image'){?><img src="<?php echo $val['path'];?>" /><?php }?></div>
					<div class="m_li_desc">
						<p><strong><?php echo $val['name'];?></strong></p>
						<p>
							<span><b>创建时间：</b><?php echo date("Y-m-d H:i:s",$val['addtime']);?></span>
							<span><b>文件大小：</b><?php echo round($val['size']/1024,2) ." KB";?></span>
							<?php if($types=='image'){?>
								<span><b>图片尺寸：</b><?php echo $val['width']."×".$val['height'];?></span>
							<?php }else{?>
								<span><b>文件类型：</b><?php echo strstr($val['type'],'/',true);?></span>
							<?php }?>
						</p>
						<p class="m_li_link"><input type="hidden" name="pathurl" value="<?php echo str_replace('../',IDEA_URL,$val['path']);?>" /><a href="javascript:void(0);" onclick="copyurl(this);">复制链接</a><a href="javascript:void(0);" onclick="delfiles('<?php echo IDEA_URL;?>','<?php echo $val['id'];?>');">删除</a></p>
					</div>
				</li>
				<?php }?>
				<?php for($i=0;$i<$spannum;$i++){echo "<span></span>";}?>
			</ul>
			<?php }else{?>
			<p class="none">暂无相关资源！</p>
			<?php }?>
		</div>
		<div class="m_page">
			<?php echo $pagestr;?>
		</div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('bookmark','file');
}
</script>