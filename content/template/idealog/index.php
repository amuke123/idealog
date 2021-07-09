<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>

<?php if(!empty($banners)){?>
<section>
	<div class="content">
		<div class="ban">
			<div id="banner">   
				<div class="tab">
					<?php foreach($banners as $val){if($val['show']){?>
						<a href="<?php echo $val["link"];?>" <?php echo $val["blank"]=='1'?'target="_blank"':'';?>><img class="tabImg" src="<?php echo $val["pic"];?>" alt="<?php echo $val["name"];?>" title="<?php echo $val["name"];?>" width="100%" /></a>
					<?php }}?>
				</div>
				<div class="lunbo_btn">
					<?php $i=0;foreach($banners as $val){if($val['show']){?>
						<span onclick="tabBtnFc(<?php echo $i++;?>);" class="tabBtn"></span>
					<?php }}?>
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
	</div>
</section>
<?php }?>

<section>
	<div class="content">
		<div class="sorts">
			<div class="center">
				<ul class="sortlist">
					<li><a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic1.jpg" /></a></li>
					<li><a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg" /></a></li>
					<li><a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic1.jpg" /></a></li>
					<li><a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic2.jpg" /></a></li>
				</ul>
			</div>
		</div>
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
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic1.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">近日发布了《杨浦区高新技术企业资助办法》杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic1.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">近日发布了《杨浦区高新技术企业资助办法》杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<div class="list_left">
							<a href="#"><img src="<?php echo TEMPLATE_URL;?>images/pic1.jpg"></a>
						</div>
						<div class="list_right">
							<h2><a href="#">近日发布了《杨浦区高新技术企业资助办法》杨浦区为推动区高新技术企业发展</a></h2>
							<p>近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。杨浦区为推动区高新技术企业发展，近日发布了《杨浦区高新技术企业资助办法》，自2021年8月1日开始施行。办法》，自2021年8月1日开始施行。办法》，</p>
							<div class="art_info"><span class="left">2021-07-07</span><span>分类：<a href="#">技术</a></span><span>阅读：<a href="#">236</a></span></div>
						</div>
						<div class="clear"></div>
					</li>
				</ul>
				<div class="list_page">
					<p><span>1</span><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="content">
		<div class="links">
			<div class="center">
				<p><b>链接：</b><a href="#">首页</a><a href="#">下载</a><a href="#">关于</a><a href="#">免责</a><a href="#">留言</a></p>
			</div>
		</div>
	</div>
</section>

<?php
include View::getView('footer');
?>