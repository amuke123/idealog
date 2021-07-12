<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>
<section>
	<div class="content">
		<div class="c_cont">
			<div class="center">
				<div class="c_cont_left left">
					<div class="d_cont">
						<div class="c_title"><b></b><span><?php echo $art_title;?></span></div>
						<div class="d_contc">
							<?php echo str_replace('../content/uploadfile/',IDEA_URL .'content/uploadfile/',htmlspecialchars_decode($art_content));?>
						</div>
						<div class="clear"></div>
						<?php if($allow_remark){?>
						<div class="d_pl" id="comments">
							<?php getComments($comments,$aid);?>
							<div class="list_page"><p><?php echo $pagestr;?></p></div>
							<?php getCommentPost($aid,$ckname,$ckmail,$ckurl,$verifyCode);?>
						</div>
						<?php }?>
						<div class="clear"></div>
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