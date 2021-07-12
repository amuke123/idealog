<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>


<section>
	<div class="content">
		<div class="art_title">
			<div class="center">
				<div class="d_bg">
					<h2><?php echo $art_title;?></h2>
					<div class="u_info">
						<div class="left"><p><img src="<?php echo $art_authorUrl;?>"></p></div>
						<div class="right"><b><a href="<?php echo Url::author($art_uid);?>" target="_blank">by <?php echo $art_author;?></a></b><span><?php echo date("Y-m-d",$art_date);?></span></div>
					</div>
					<div class="d_ac">
						<ul>
							<li id="goods"><i class="icono-heart"></i><?php echo $art_goodnum;?> 赞</li>
							<li><i class="icono-heart"></i><?php echo $art_badnum;?> 踩</li>
							<li><i class="icono-fied"></i><a href="<?php echo Url::sort($art_sortid);?>"><?php echo $art_sortName;?></a></li>
							<li><i class="icono-write"></i><?php echo $art_saynum;?> 评论</li>
							<li><i class="icono-eye"></i><?php echo $art_eyes;?> 阅读</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="content">
		<div class="c_cont">
			<div class="center">
				<div class="c_cont_left left">
					<div class="d_cont">
						<div class="d_copy">
							<span title="版权">©</span> 本文 <a href="<?php echo Url::author($art_uid);?>" target='_blank' >by <?php echo $art_author;?></a> 
							<?php if($art_getsite=='原创'){echo $art_copyrights==1?'版权所有，未经作者本人的书面许可任何人不得转载或使用整体或任何部分的内容。':'版权所有，作者未对本笔记声明转载限制，转载时请注明本文标题和链接。';}else if($art_getsite=='网络'){echo '转载自 <a target="_blank" rel="nofollow" href="'.$art_geturl.'" >网络</a>，如有任何版权问题可联系管理员进行处理。';}else{echo '版权所有.';}?>
						</div>
						<div class="c_title"><b></b><span>笔记</span></div>
						<div class="d_contc">
							<?php echo str_replace('../content/uploadfile/',IDEA_URL .'content/uploadfile/',htmlspecialchars_decode($art_content));?>
						</div>
						<div class="d_contc"><p>---</p></div>
						<div class="d_contc">转载请注明本文标题和链接：《 <a href="<?php echo Url::log($aid);?>"><?php echo $art_title;?></a> 》</div>
						<div class="d_tag"><b>TAG：</b>	<?php echo getTag($art_tags,1);?><div class="clear"></div></div>
						<div class="d_good">
							<?php $code=Checking::getAjCode(12);?>
							<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
							<a href="javascript:good('<?php echo $aid;?>','<?php echo IDEA_URL;?>');"><i class="icono-heart"></i>攒</a>
							<a href="javascript:bad('<?php echo $aid;?>','<?php echo IDEA_URL;?>');"><i class="icono-heart"></i>踩</a>
						</div>
						<div class="d_next">
							<div class="left">上一篇：<a href="<?php echo Url::log($neighbour['prev']['id']);?>"><?php echo $neighbour['prev']['title'];?></a></div>
							<div class="right">下一篇：<a href="<?php echo Url::log($neighbour['next']['id']);?>"><?php echo $neighbour['next']['title'];?></a></div>
							<div class="clear"></div>
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