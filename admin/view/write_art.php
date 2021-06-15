<div class="main" id="main">
	<div class="content">
		<div class="m_title"><?php echo $aid?'编辑笔记':'写笔记';?></div>
		<form action="" name="add_art" method='post'>
			<?php $code=Checking::getAjCode(12);?>
			<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
			<div class="m_contents left">
				<input type="hidden" name='arttype' id='arttype' value="a" />
				<input type="hidden" name="fb" id="fb" value="<?php echo $aid?$art['id']:'';?>" />
				<input type="hidden" name="id" id="aid" value="<?php echo $aid?$art['id']:'';?>" />
				<input type="hidden" name="filenum" id="filenum" value="<?php echo $aid?$art['filenum']:'0';?>"/>
				<input type="hidden" name="saynum" value="<?php echo $aid?$art['saynum']:'0';?>" />
				<p title="标题"><input type="text" name="title" value="<?php echo $aid?$art['title']:'';?>" required class="formtitle" placeholder="请在这里输入标题" /></p>
				<p><textarea class="formtext" name="content" id="editor"><?php echo $aid?$art['content']:'';?></textarea></p>
				<p>
					<input type="radio" name="getsite" onclick="showurl(1);" <?php if($aid){echo $art['getsite']=='原创'?'checked':'';}?> value="原创" /><span class="m_mar">原创</span>
					<input type="radio" name="getsite" onclick="showurl(2);" <?php if($aid){echo $art['getsite']=='网络'?'checked':'';}?> value="网络" /><span class="m_mar">转载</span>
					<?php if($aid){$getsitestr=$art['getsite']=='原创'?'1':'2';}else{$getsitestr='0';}?>
					<span id="ycxz">
						<span class="m_mar"><input type="checkbox" <?php if($aid){echo $art['copyrights']=='0'?'checked':'';}?> name="copyrights" value="0" /><span class="m_mar">禁止转载</span></span>
						<a class="m_mar" href="<?php echo IDEA_URL .'/original.html'?>" target="_blank">文章原创声明须知</a>
					</span>
					<span id="geturl" class="m_mar m_medium"><input type="text" name="geturl" value="<?php echo $aid?$art['geturl']:'';?>" class="formlong" placeholder="原文链接" /></span>
				</p>
				<div class="m_line">
					<input type="hidden" name="pic" value="<?php echo $aid?$art['pic']:'';?>" id="pic" />
					<?php ?>
					<?php if($aid){$imgs=$art['pic']!=''?'<img src="'.str_replace("../",IDEA_URL,$art['pic']).'" /><a href="'.str_replace("../",IDEA_URL,getImgPath($art['pic'])).'" title="点击查看原图" target="_blank">查看原图</a><a href="javascript:autoSave(\''.IDEA_URL .'\',\'1\');" title="点击更改图片">更改图片</a>':'<p onClick=\'autoSave("'.IDEA_URL .'","1");\'><b>+</b><br/>选择主图</p>';}else{$imgs='<p onClick=\'autoSave("'.IDEA_URL .'","1");\'><b>+</b><br/>选择主图</p>';}?>
					<div class="left m_pic"><span id="m_pic"> <?php echo $imgs;?></span></div>
					<div class="right m_exc"><textarea name="excerpt" placeholder="摘要：选填，如不填写则可后台设置自动抓取"><?php echo $aid?$art['excerpt']:'';?></textarea></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="m_side right">
				<p>
					<select name="sort" class="formlong">
						<option value="0">选择分类...</option>
						<?php $sortid=$aid?$art['s_id']:0;echo sort_Model::getSortList($sorts,$sortid);?>
					</select>
				</p>
				<p class="m_tags_style">
					<input type="text" id="tags" name="tags" value="<?php echo $aid?$tagnamestr:'';?>" class="formlong" placeholder="标签，使用逗号分隔" />
					<a href="javascript:showTags('m_tags');">已有标签+</a>
					<span class="m_tags2" id="m_tags">
						<?php foreach($tags as $value){?>
							<a href="javascript:addTags('<?php echo $value['tagname'];?>');"><?php echo $value['tagname'];?></a>
						<?php }?>
					</span>
				</p>
				<?php if($aid){$dates=$art['date']!=''?date("Y-m-d H:i:s",$art['date']):date("Y-m-d H:i:s",time());}else{$dates=date("Y-m-d H:i:s",time());}?>
				<p><input type="text" name="date" class="formlong" value='<?php echo $dates;?>' /></p>
				<p><input type="text" name="alias" class="formlong" value="<?php echo $aid?$art['alias']:'';?>" placeholder="链接别名" /></p>
				<p><input type="text" name="key" class="formlong" value="<?php echo $aid?$art['key']:'';?>" placeholder="SEO关键字" /></p>
				<p><input type="text" name="password" class="formlong" value="<?php echo $aid?$art['password']:'';?>" placeholder="访问密码" /></p>
				<div class="m_line">
					<span class="m_tags_style"><a href="javascript:showTags('m_data');">初始化数据+</a></span>
					<span id="m_data">
						<p>
							<input type="text" name="eyes" value="<?php echo $aid?$art['eyes']:'0';?>" class="formshort2" title="阅读量" placeholder="阅读量" />
							<input type="text" name="goodnum" value="<?php echo $aid?$art['goodnum']:'0';?>" class="formshort2" title="点赞数" placeholder="点赞数" />
							<input type="text" name="badnum" value="<?php echo $aid?$art['badnum']:'0';?>" class="formshort2" title="反对数" placeholder="反对数" />
						</p>
					</span>
				</div>
				<p>
					<span class="m_mar"><input type="checkbox" name="sayok" <?php if($aid){echo $art['sayok']=='1'?'checked':'';}else{echo 'checked';}?> value="1" /><span class="m_mar">允许评论</span></span>
					<?php if($aid){$marks=$art['mark'];$markarr = explode(',',$marks);}?>
					<span class="m_mar"><input type="checkbox" name="marktop" <?php if($aid){echo in_array("T",$markarr)?'checked':'';}?> value="1" /><span class="m_mar">首页置顶</span></span>
					<span class="m_mar"><input type="checkbox" name="marksorttop" <?php if($aid){echo in_array("ST",$markarr)?'checked':'';}?> value="1" /><span class="m_mar">分类置顶</span></span>
				</p>
				<div class="m_button">
					<input type="submit" class="m_sub" name='tj' value='<?php echo $aid?'保存并返回':'发布文章';?>' />
					<input type="button" onClick="javascript:autoSave('<?php echo IDEA_URL;?>');" class="m_but" name='add' value='<?php echo $aid?'保存':'保存草稿';?>' />
					<?php if($aid){if($art['show']=='0'){?>
					<input type="button" onClick="javascript:fb_art(add_art,editor);" class="m_sub" name='tj2' value='发布' />
					<?php }}?>
				</div>
			</div>
			<div class="clear"></div>
		</form>
		<div class="imagelist" id="imagebox">
			<div class="il_top"><p><b>文件库</b><a class="right" href="javascript:ycbox();"> X </a></p></div>
			<div class="il_cont" id="imagelist"></div>
			<div class="il_botton">
				<strong>上传图片</strong>
				<input type="file" multiple="multiple" name="file[]" id="il_upimage" class="il_up" onchange="upFileFc2('<?php echo IDEA_URL;?>','il_upimage');">
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
var editor = MK.getEditor('editor',{
	uploadKey:true,
	uploadUrl:'include/action/actiondo.php',
	uploadPath:'content/uploadfile',
});
</script>
<script>
window.onload=function(){
	autoShow('write_art');
	showurl("0");
}
</script>