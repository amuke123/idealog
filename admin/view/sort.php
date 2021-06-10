<div class="main" id="main">
	<div class="content">
		<div class="m_title">分类管理</div>
		<div class="m_content">
			<?php $code=Checking::getAjCode(12);?>
			<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
			<div class="m_list" id="m_list">
				<p><b>序号</b><b>名称</b><b>描述</b><b>关键字</b><b>图片</b><b>别名</b><b>模板</b><b>查看</b><b>文章</b><b>操作</b></p>
				<?php 
				foreach($sorts as $value){
					if($value['top_id']==0){
						$picpath=$value['pic']==""?TEMPLATE_URLA .'static/images/img.gif':str_replace('../',IDEA_URL,$value['pic']);
					?>
					<p>
						<span><input type="text" name="num[]" alt="<?php echo $value['id'];?>" value="<?php echo $value['index'];?>" /></span>
						<span class="tleft"><a href="?id=<?php echo $value['id'];?>"><?php echo $value['sortname'];?></a></span>
						<span><?php echo $value['description'];?></span>
						<span><?php echo $value['key'];?></span>
						<span><a <?php echo $value['pic']==""?'':'target="_blank" class="listimg" ';?> title="<?php echo $value['pic']==""?'无图':'点击图片可查看原图';?>" href="<?php echo $value['pic']==""?'':$picpath;?>"><img src="<?php echo $picpath;?>" /></a></span>
						<span><?php echo $value['alias'];?></span>
						<span><?php echo $value['template'];?></span>
						<span><a target="_blank" href="<?php echo Url::sort($value['id']);?>"><img title='查看' src='<?php echo TEMPLATE_URLA . "static/images/eye.png";?>' /></a></span>
						<span><a href="<?php echo ADMIN_URL ."article.php?sortid=".$value['id'];?>"><?php echo $value['artnum'];?></a></span>
						<span><a href="javascript:delLine('<?php echo $value['id']."','".IDEA_URL;?>','sort');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a></span>
					</p>
					<?php
						$children=$value['children'];
						foreach($children as $val){
							$picpath2=$sorts[$val]['pic']==""?TEMPLATE_URLA .'static/images/img.gif':str_replace('../',IDEA_URL,$sorts[$val]['pic']);
					?>
							<p>
								<span><input type="text" name="num[]" alt="<?php echo $sorts[$val]['id'];?>" value="<?php echo $sorts[$val]['index'];?>" /></span>
								<span class="tleft"><a href="?id=<?php echo $sorts[$val]['id'];?>">---- <?php echo $sorts[$val]['sortname'];?></a></span>
								<span><?php echo $sorts[$val]['description'];?></span>
								<span><?php echo $sorts[$val]['key'];?></span>
								<span><a <?php echo $sorts[$val]['pic']==""?'':'target="_blank" class="listimg" ';?> title="<?php echo $sorts[$val]['pic']==""?'无图':'点击图片可查看原图';?>" href="<?php echo $sorts[$val]['pic']==""?'':$picpath2;?>"><img src="<?php echo $picpath2;?>" /></a></span>
								<span><?php echo $sorts[$val]['alias'];?></span>
								<span><?php echo $sorts[$val]['template'];?></span>
								<span><a target="_blank" href="<?php echo Url::sort($sorts[$val]['id']);?>"><img title='查看' src='<?php echo TEMPLATE_URLA . "static/images/eye.png";?>' /></a></span>
								<span><a href="<?php echo ADMIN_URL ."article.php?sortid=".$value['id'];?>"><?php echo $sorts[$val]['artnum'];?></a></span>
								<span><a href="javascript:delLine('<?php echo $sorts[$val]['id']."','".IDEA_URL;?>','sort');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a></span>
							</p>
						<?php
							if(isset($sorts[$val]['children'])){
								foreach($sorts[$val]['children'] as $v){
									$picpath3=$sorts[$v]['pic']==""?TEMPLATE_URLA .'static/images/img.gif':str_replace('../',IDEA_URL,$sorts[$v]['pic']);
						?>
									<p>
										<span><input type="text" name="num[]" alt="<?php echo $sorts[$v]['id'];?>" value="<?php echo $sorts[$v]['index'];?>" /></span>
										<span class="tleft"><a href="?id=<?php echo $sorts[$v]['id'];?>">---- ---- <?php echo $sorts[$v]['sortname'];?></a></span>
										<span><?php echo $sorts[$v]['description'];?></span>
										<span><?php echo $sorts[$v]['key'];?></span>
										<span><a <?php echo $sorts[$v]['pic']==""?'':'target="_blank" class="listimg" ';?> title="<?php echo $sorts[$v]['pic']==""?'无图':'点击图片可查看原图';?>" href="<?php echo $sorts[$v]['pic']==""?'':$picpath3;?>"><img src="<?php echo $picpath3;?>" /></a></span>
										<span><?php echo $sorts[$v]['alias'];?></span>
										<span><?php echo $sorts[$v]['template'];?></span>
										<span><a target="_blank" href="<?php echo Url::sort($sorts[$v]['id']);?>"><img title='查看' src='<?php echo TEMPLATE_URLA . "static/images/eye.png";?>' /></a></span>
										<span><a href="<?php echo ADMIN_URL ."article.php?sortid=".$value['id'];?>"><?php echo $sorts[$v]['artnum'];?></a></span>
										<span><a href="javascript:delLine('<?php echo $sorts[$v]['id']."','".IDEA_URL;?>','sort');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a></span>
									</p>
						<?php
								}
							}
						}
					}
				}
				?>
			</div>
			<div class="clear"></div>
			<div class="m_button">
				<input type="button" onclick="change_index('<?php echo IDEA_URL;?>','sort');" class="m_sub" name="tj" value="更改排序">
				<input type="button" onclick="show_add('sort_add');" class="m_but" name="add" value="添加分类 +">
			</div>
		</div>
		<div class="clear"></div>
		<div class="m_add" id="sort_add">
			<form action="" method="post" name="sortadd" enctype="multipart/form-data" >
				<p><input type="text" class="formin" name="index" placeholder="序号" /></p>
				<p><input type="text" class="formput" name="name" required placeholder="名称" /></p>
				<p><input type="text" class="formput" name="alias" required placeholder="别名" /></p>
				<p><input type="text" class="formput" name="template" placeholder="模板" /></p>
				<p>
					<select name="top_id" class="formsele" >
						<option value='0'>无上级分类</option>
						<?php echo sort_Model::getSortList($sorts);?>
					</select>
				</p>
				<div class="group">
					<p><b>分类图片</b></p>
					<p><input type="file" class="formfile" name="pic" placeholder="分类图片" /></p>
				</div>
				<p><input type="text" class="formput" name="key" placeholder="关键字" /></p>
				<p><textarea name="description" class='formtext2' placeholder="分类描述"></textarea></p>
				<p>
					<select name="group" class="formsele">
						<option value='0'>笔记</option>
						<option value='1'>图集</option>
					</select>
				</p>
				<p class="m_button"><input type="submit" class="m_sub" name='add' value='创建新分类' /></p>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('sort');
	showurl("0");
}
</script>