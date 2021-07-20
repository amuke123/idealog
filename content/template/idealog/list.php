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
								<div class="art_info"><span class="left"><?php echo date("Y-m-d",$value['date']);?></span><span>阅读：<a href="<?php echo Url::log($value['id']);?>"><?php echo $value['eyes'];?></a></span></div>
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
						<p><b>一周热点</b></p>
					</div>
					<div class="c_cr_hot">
						<p><b><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg"></b></p>
						<li><i class="hot">1</i><a href="#">网页设计需要了解的网页设计技巧</a></li>
						<li><i class="hot">2</i><a href="#">centos搭建Apache+php+mysql+phpmyadmin等Web服务器环境</a></li>
						<li><i class="hot">3</i><a href="#">访客最讨厌的3种网站交互方式</a></li>
						<li><i>4</i><a href="#">手工制作可帮助您缓解睡眠或疲劳的眼睛的镇静眼枕</a></li>
						<li><i>5</i><a href="#">如何修复厨房臭水槽排水口</a></li>
						<li><i>6</i><a href="#">免费可商用图片网站</a></li>
						<li><i>7</i><a href="#">为何临摹容易，自己做设计却完全没思路？</a></li>
						<li><i>8</i><a href="#">脑洞极大的设计想法怎么来的？</a></li>
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