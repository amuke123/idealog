<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>


<section>
	<div class="content">
	<?php if(!empty($banners)){?>
	<script src="<?php echo TEMPLATE_URL;?>js/banner.js" type="text/javascript"></script>
		<div class="ban">
			<div id="banner">   
				<div class="tab">
					<?php $bnun=1;foreach($banners as $bval){if($bval['show']){$bnun++;?>
						<a href="<?php echo $bval["link"];?>" <?php echo $bval["blank"]=='1'?'target="_blank"':'';?>><img class="tabImg" src="<?php echo $bval["pic"];?>" alt="<?php echo $bval["name"];?>" title="<?php echo $bval["name"];?>" width="100%" /></a>
					<?php }}?>
				</div>
				<div class="lunbo_btn">
					<?php for($i=0;$i<$bnun;$i++){?>
						<span onclick="tabBtnFc(<?php echo $i++;?>);" class="tabBtn"></span>
					<?php }?>
				</div>
				<div class="arrow prve">
					<span class="slider_left"></span>
				</div>
				<div class="arrow next">
					<span class="slider_right"></span>
				</div>      
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>
	</div>
</section>



<section>
	<div class="content">
	<?php if(!empty($toparts)){?>
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
	<?php }?>
	</div>
</section>

<section>
	<div class="content">
		<div class="contents">
			<div class="center">
				<div class="cont_top">
					<a href="javascript:void(0);" onclick="listorcard('list',this);" class="active"><i class="icon-list"></i></a>
					<span></span>
					<a href="javascript:void(0);" onclick="listorcard('card',this);"><i class="icon-card"></i></a>
				</div>
				<ul class="artlist">
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
				</ul>
				<div class="list_page">
					<p><?php echo $pagestr;?></p>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="content">
		<div class="links">
			<div class="center">
				<p>
					<b>链接：</b>
					<?php if(!empty($links)){?>
					<?php foreach($links as $lval){if($lval['show']){?>
						<a href="<?php echo $lval["url"];?>" title="<?php echo $lval["des"];?>" target="_blank"><?php echo $lval["name"];?></a>
					<?php }}?>
					<?php }?>
				</p>
			</div>
		</div>
	</div>
</section>

<?php
include View::getView('footer');
?>