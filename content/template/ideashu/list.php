<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>

<section>
	<div class="content">
		<div class="main_top">
			<div class="center">
				<div class="list_top">
					<p><i></i><b><?php echo $sortName;?></b></p>
					<p><span><?php echo $sort['description'];?></span></p>
				</div>    
			</div>
			<div class="clear"></div>
		</div>
	</div>
</section>
<?php if(!empty($toparts)){?>
<section>
	<div class="content">
		<div class="sorts">
			<div class="center">
				<ul class="sortlist">
					<?php foreach($toparts as $topval){?>
						<li><a href="<?php echo Url::log($topval['id']);?>"><img src="<?php echo $topval['pic']!=''?str_replace('../',IDEA_URL,$topval['pic']):getImg($topval['id']);?>" /><p><b><?php echo $topval['title'];?></b></p></a></li>
					<?php }?>
					<?php for($i=0;$i<(4-count($toparts));$i++){?>
					<span></span>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>
</section>
<?php }?>

<section>
	<div class="content">
		<div class="c_cont">
			<div class="center">
				<div class="c_cont_left left">
					<div class="c_cl_top"><p><?php echo $sortName;?></p></div>
					<div class="artlist">
					<?php if(!empty($arts)){foreach($arts as $value){?>
						<li>
							<div class="list_left">
								<a href="<?php echo Url::log($value['id']);?>"><img src="<?php echo $value['pic']!=''?str_replace('../',IDEA_URL,$value['pic']):getImg($value['id']);?>"></a>
							</div>
							<div class="list_right">
								<h2><a href="<?php echo Url::log($value['id']);?>"><?php echo $value['title'];?></a></h2>
								<?php $excerpt=$value['excerpt']==''?strip_tags(htmlspecialchars_decode($value['content'])):strip_tags($value['excerpt']);?>
								<p><?php echo mb_substr(trim($excerpt),0,100);?>...</p>
								<div class="art_info"><span class="left"><?php echo date("Y-m-d",$value['date']);?></span><span>阅读：<a href="<?php echo Url::log($value['id']);?>"><?php echo $value['eyes'];?></a></span><span>赞同：<a href="<?php echo Url::log($value['id']);?>"><?php echo $value['goodnum'];?></a></span><span>评论：<a href="<?php echo Url::log($value['id']);?>#comments"><?php echo $value['saynum'];?></a></span></div>
							</div>
							<div class="clear"></div>
						</li>
					<?php }}?>
					</div>
					<div class="list_page">
						<p><?php echo $pagestr;?></p>
					</div>
				</div>
				<div class="c_cont_hot right">
					<div class="c_cr_top">
						<p><b>热门排行</b></p>
					</div>
					<div class="c_cr_hot">
						<p><b><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg"></b></p>
						<?php if(!empty($hotart)){$ii=1;foreach($hotart as $hotval){?>
						<li><i <?php echo $ii<4?'class="hot"':'';?>><?php echo $ii++;?></i><a href="<?php echo $hotval['arturl'];?>" title="<?php echo $hotval['title'];?>"><?php echo $hotval['title'];?></a></li>
						<?php }}?>
					</div>
					<div class="c_cr_ad">
						<p><b><img src="<?php echo TEMPLATE_URL;?>images/pic2.jpg"></b></p>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</section>

<?php
include View::getView('footer');
?>