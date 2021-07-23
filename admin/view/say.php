<div class="main" id="main">
	<div class="content">
		<?php if($action=='edit'){$plname=say_Model::getUname($lineedit['posterid']);?>
		<div class="m_title">回复评论</div>
		<div class="m_add2">
			<form action="" method="post" name="sayadd" onSubmit="return yzSayAdd();" >
				<input type="hidden" name="id" value="<?php echo $lineedit['id']?>" />
				<input type="hidden" name="tid" value="<?php echo $lineedit['t_id']?>" />
				<input type="hidden" name="aid" value="<?php echo $lineedit['a_id']?>" />
				<p><b>评论人：</b><?php echo $plname;?></p>
				<p><b>时间：</b><?php echo !empty($lineedit['date'])?date("Y-m-d H:i:s",$lineedit['date']):'';?></p>
				<p><b>内容：</b><?php echo $lineedit['top_id']!='0'?"@".say_Model::getTopidUname($lineedit['top_id']).'：':'';echo mb_substr(strip_tags($lineedit['content']),0,40);?></p>
				<p><textarea name="description" class='formtext2' placeholder="回复内容"></textarea></p>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='保存' /><input type="button" onclick="window.history.back();" class="m_but2" value='取消' /></p>
			</form>
		</div>
		<?php }else{?>
		<div class="m_title">评论</div>
		<div class="m_tab">
			<ul>
				<li><?php echo $god==0||$good==0||$examine==0?'<a href="'. ADMIN_URL .'say.php">全部评论</a>':'<span>全部评论</span>';?></li>
				<li><?php echo $examine==1?'<a href="?examine=0">审核</a>':'<span>审核</span>';?></li>
				<li><?php echo $good==1?'<a href="?good=0">精评</a>':'<span>精评</span>';?></li>
				<li><?php echo $god==1?'<a href="?god=0">神评</a>':'<span>神评</span>';?></li>
			</ul>
		</div>
		<div class="m_content">
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>内容</b><b>评论者</b><b>文章</b><b>赞</b><b>踩</b><b>显示</b></p>
					<?php 
					foreach($says as $value){
						$uname=say_Model::getUname($value['posterid']);
					?>
					<p>
						<span><input type="checkbox" name="artck[]" value="<?php echo $value['id'];?>" /></span>
						<span class="tleft linesort">
							<?php if($god=='1'&&$examine=='1'){echo $value['top_id']!='0'?'@ '.say_Model::getTopidUname($value['top_id']).' ':'';}?>
							<a title="点击评论回复" href="?action=edit&id=<?php echo $value['id'];?>"><?php echo mb_substr($value['content'],0,40,'utf-8');?></a> 
							<?php echo $value['check']=="0"?"<img class='iconpic' title='未审核' src='". TEMPLATE_URLA ."static/images/weishen.png' />":"";?> 
							<?php echo $value['mark']=="1"?"<img class='iconpic' title='加精' src='". TEMPLATE_URLA ."static/images/jing.png' />":"";?> 
							<?php echo $value['mark']=="2"?"<img class='iconpic' title='神评' src='". TEMPLATE_URLA ."static/images/shen.png' />":"";?> 
							<br />
							<?php $dtime = $value['date']!=""?$value['date']:'0';?>
							<?php echo date("Y-m-d H:i:s",$dtime);?>
						</span>
						<span class="tleft linesort"><a target="_blank" href="<?php echo $value['url'];?>"><?php echo $uname;?></a> <?php echo $value['mail']!=''?"(".$value['mail'].")":'';?><br />来自：<?php echo $value['ip'];?> </span>
						<span><a target="_blank" href="<?php echo Url::log($value['a_id']);?>"><?php echo art_Model::getOnceArt($value['a_id'],'title');?></a></span>
						<span><?php echo $value['good'];?></span><span><?php echo $value['bad'];?></span>
						<span><a href="javascript:showOrHide('<?php echo $value['id']."','".IDEA_URL."','";echo $value['show']==0?'1':'0';?>','comment','<?php echo $value['a_id'];?>');"><?php echo $value['show']==0?'<img title="隐藏" src="'. TEMPLATE_URLA .'static/images/plugin_inactive.gif" />':'<img title="显示" src="'. TEMPLATE_URLA .'static/images/plugin_active.gif" />';?></a></span>
					</p>
					<?php }?>
				</div>
				<div class="m_set">
					<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：
					<?php echo $good=='0'||$god=='0'?'':"<a class=\"red\" href=\"javascript:delSay('". IDEA_URL ."');\">删除</a>";?>
					<?php echo $examine=='0'?" | <a href=\"javascript:setSayCheck('". IDEA_URL ."');\">审核并显示</a>":'';?>
					<?php echo $god=='1'&&$good=='1'&&$examine=='1'?" | <a href=\"javascript:setSayGood('". IDEA_URL ."','1');\">加精</a>":'';?>
					<?php echo $god=='1'&&$good=='1'&&$examine=='1'?" | <a href=\"javascript:setSayGood('". IDEA_URL ."','2');\">设为神评</a>":'';?>
					<?php echo $god=='1'?"":"<a href=\"javascript:setSayGood('". IDEA_URL ."','0');\">取消神评</a> | <a href=\"javascript:setSayGood('". IDEA_URL ."','1');\">改为加精</a>";?>
					<?php echo $good=='1'?"":"<a href=\"javascript:setSayGood('". IDEA_URL ."','0');\">取消加精</a> | <a href=\"javascript:setSayGood('". IDEA_URL ."','2');\">设为神评</a>";?>
				</div>
				<div class="m_page">
					<?php echo $pagestr;?>
				</div>
			</form>
		</div>
		<?php }?>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('ulist','say');
}
</script>