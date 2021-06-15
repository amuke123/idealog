<div class="main" id="main">
	<div class="content">
		<div class="m_tab">
			<ul>
				<li><?php echo $draft==0||$examine==0?'<a href="'. ADMIN_URL .'article.php">笔记</a>':'<span>笔记</span>';?></li>
				<li><?php echo $draft==1?'<a href="?draft=0">草稿</a>':'<span>草稿</span>';?></li>
				<?php if(ROLE==ROLE_ADMIN){?>
				<li><?php echo $examine==1?'<a href="?examine=0">审核</a>':'<span>审核</span>';?></li>
				<?php }?>
			</ul>
		</div>
		<div class="m_content">
			<div class="m_set">
				<div class="left">
					<select name="novesort" onChange="jumpMenu('parent',this,0)">
						<option value="<?php echo ADMIN_URL ."article.php?sortid=".$urlsub;?>">全部分类笔记..</option>
						<?php echo sort_Model::getSortUrl($sorts,$sidthem,$urlsub);?>
						<option value="<?php echo ADMIN_URL ."article.php?sortid=0".$urlsub;?>" <?php echo $sidthem=="0"?'selected':'';?> >未分类</option>
					</select>
				</div>
				<div class="right">
					<form action="" method="get" name="myso">
						<?php
						if($draft=='0'){echo '<input type="hidden" name="draft" value="0" >';}
						if($examine=='0'){echo '<input type="hidden" name="examine" value="0" >';}
						?>
						<input type="text" name="keyword" class="formc" placeholder="搜索文章">
					</form>
				</div>
				<div class="clear"></div>
			</div>
			<form action="" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b></b><b>标题</b><b>作者</b><b>分类</b><b>查看</b><b>时间</b><b>评论</b><b>阅读</b><b>赞</b><b>踩</b></p>
					<?php 
					if(!empty($arts)){foreach($arts as $value){
						$marks=explode(',',$value['mark']);
					?>
					<p>
						<span><input type="checkbox" name="artck[]" value="<?php echo $value['id'];?>" /></span>
						<span class="tleft">
							<a title="点击标题编辑笔记" href="<?php echo  ADMIN_URL ."write_art.php?artid=".$value['id'];?>"><?php echo $value['title']==''?'无标题':$value['title'];?></a>
							<?php echo in_array('T',$marks)?'<img src="'. ADMIN_URL .'view/static/images/top.png" title="首页置顶" />':'';?>
							<?php echo in_array('ST',$marks)?'<img src="'. ADMIN_URL .'view/static/images/sortop.png" title="分类置顶" />':'';?>
							<?php echo $value['filenum']!=0?'<img src="'. ADMIN_URL .'view/static/images/att.gif" title="附件数：'.$value['filenum'].'" />':'';?>
						</span>
						<?php if($value['author']!='0'){$authors=user_Model::getInfo($value['author']);};$userid=$value['author']!='0'?$authors['id']:'0';?>
						<span><a href="<?php echo ADMIN_URL ."article.php?author=".$userid.$urlsub;?>"><?php echo $value['author']!='0'?$authors['name']:'佚名';?></a></span>
						<?php $sortid=$value['s_id']>0?$sorts[$value['s_id']]['id']:'0';?>
						<span><a href="<?php echo ADMIN_URL ."article.php?sortid=".$sortid.$urlsub;?>"><?php echo $value['s_id']>0?$sorts[$value['s_id']]['sortname']:'未分类';?></a></span>
						<span><a target="_blank" href="<?php echo Url::log($value['id']);?>"><img title='查看' src='<?php echo ADMIN_URL . "/view/static/images/eye.png";?>' /></a></span>
						<span><?php echo $value['date']!=''?date("Y-m-d H:i:s",$value['date']):'';?></span>
						<span><a href="<?php echo  ADMIN_URL ."say.php?artid=".$value['id'];?>"><?php echo $value['saynum'];?></a></span>
						<span><?php echo $value['eyes'];?></span>
						<span><?php echo $value['goodnum'];?></span>
						<span><?php echo $value['badnum'];?></span>
					</p>
					<?php }
					}
					?>
				</div>
				<div class="m_set">
					<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：<a class="red" href="javascript:delList('<?php echo IDEA_URL;?>','article');">删除</a> | <?php if($draft=='1' && $examine=='1'){?><a href="javascript:setDraft('<?php echo IDEA_URL;?>','article');">放入草稿箱</a> |<?php }if($draft=='0'){?><a href="javascript:release('<?php echo IDEA_URL;?>','article');">发布</a> <?php }?> <?php if($examine=='0'){?> <a href="javascript:examine('<?php echo IDEA_URL;?>','article');">审核</a> <?php }?>
					<?php if($draft=='1' && $examine=='1'){?>
						<select name="top" onChange="setTop(this,'<?php echo IDEA_URL;?>');">
							<option value="">置顶操作..</option>
							<option value="T">首页置顶</option>
							<option value="ST">分类置顶</option>
							<option value="0">取消置顶</option>
						</select> 
						<select name="novesort" onChange="moveSort(this,'<?php echo IDEA_URL;?>');" >
							<option value="">移动分类..</option>
							<?php echo sort_Model::getSortList($sorts)?>
							<option value="0">未分类</option>
						</select>
					<?php }?>
				</div>
			</form>
		</div>
		<div class="m_page">
			<?php echo $pagestr;?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('article');
	showurl("0");
}
</script>