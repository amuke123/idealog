<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>

<?php
//获取评论
function getComments($comments,$aid){?>
	<a name="comments"></a>
	<div class="c_title"><b></b><span><?php echo art_Model::getArtType($aid)=="p"?'留言':'评论';?></span></div>
	<?php if(empty($comments)){?>
		<p class="comment_header"><b><?php echo art_Model::getArtType($aid)=="p"?'':'还没有评论奥，快来抢个沙发吧！';?></b></p>
	<?php }else{?>
		<?php
		$isGravatar=Control::get('say_gravatar');
		foreach($comments as $sayval){
			$cid=$sayval['id'];
			$posterPhoto=user_Model::getUserPhoto($sayval['posterid'],'1');
			$poster=$sayval['url']?'<a href="'.$sayval['url'].'" target="_blank">'.$sayval['name'].'</a>':$sayval['name'];
		?>
			<div class="comment" id="comment-<?php echo $cid;?>">
				<a name="<?php echo $cid;?>"></a>
				<?php if($isGravatar=='1'){?>
				<div class="avatar left">
					<img src="<?php echo $posterPhoto==''?getGravatar($sayval['mail']):$posterPhoto;?>" />
				</div>
				<?php }?>
				<div class="comment_info right">
					<b><?php echo $poster;?></b><br />
					<div class="comment_content"><?php echo $sayval['del']=='0'?'评论内容已删除':strip_tags($sayval['content']); ?></div>
					<p class="comment_time"><span class="left"><?php echo $sayval['date']!=''?date('Y-m-d H:i:s',$sayval['date']):'';?></span><?php if($sayval['del']!='0'){?><a href="#comment-place" class="right" onclick="commentReply('<?php echo $cid;?>',this,'<?php echo $sayval['name'];?>')">回复</a><?php }?></p>
				</div>
				<div class="clear"></div>
				<?php if(!empty($sayval['children'])){getComments2($comments,$sayval['children'],$aid);}?>
			</div>
		<?php }?>
	<?php }?>
<?php }?>

<?php
//获取子评论
function getComments2($comments,$children,$aid){
	$isGravatar=Control::get('say_gravatar');
	foreach($children as $sayval){
		$myurl=isset($comments[$sayval['top_id']]['url'])?$comments[$sayval['top_id']]['url']:$children[$sayval['top_id']]['url'];
		$myname=isset($comments[$sayval['top_id']]['name'])?$comments[$sayval['top_id']]['name']:$children[$sayval['top_id']]['name'];
		$topposter=$myurl?'<a href="'.$myurl.'" target="_blank">'.$myname.'</a>':$myname;
		$cid=$sayval['id'];
		$posterPhoto=user_Model::getUserPhoto($sayval['posterid'],'1');
		$poster=$sayval['url']?'<a href="'.$sayval['url'].'" target="_blank">'.$sayval['name'].'</a>':$sayval['name'];
	?>
		<div class="comment comment_children" id="comment-<?php echo $cid;?>">
			<a name="<?php echo $cid;?>"></a>
			<?php if($isGravatar=='1'){?>
			<div class="avatar left">
				<img src="<?php echo $posterPhoto==''?getGravatar($sayval['mail']):$posterPhoto;?>" />
			</div>
			<?php }?>
			<div class="comment_info right">
				<b><?php echo $poster;?></b><br />
				<div class="comment_content">
					<b>@ <?php echo $topposter;?>：</b><?php echo $sayval['del']=='0'?'评论内容已删除':strip_tags($sayval['content']); ?>
				</div>
				<p class="comment_time"><span class="left"><?php echo date('Y-m-d H:i:s',$sayval['date']);?></span><?php if($sayval['del']!='0'){?><a href="#comment-place" class="right" onclick="commentReply('<?php echo $cid;?>',this,'<?php echo $sayval['name'];?>')">回复</a><?php }?></p>
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>
<?php }?>

<?php
//获取评论表单
function getCommentPost($aid,$ckname,$ckmail,$ckurl,$verifyCode){
?>
<div id="comment-place">
	<div class="comment_post" id="comment-post">
		<div class="cancel" id="cancel-reply"><a href="javascript:cancelReply();">取消回复</a></div>
		<div class="reply">
			<?php if(ROLE != ROLE_VISITOR){
			$userinfo=user_Model::getInfo();
			$userimg=$userinfo['photo']==""?IDEA_URL .ADMIN_TYPE ."/view/static/images/avatar.jpg":str_replace('../',IDEA_URL,$userinfo['photo']);
			?>
			<div class="comment_left left"><img src="<?php echo $userimg;?>" /></div>
			<?php }else{?>
			<div class="comment_left left"><img src="<?php echo IDEA_URL .ADMIN_TYPE;?>/view/static/images/avatar.jpg" /></div>
			<?php }?>
			<div class="comment_right right">
				<form method="post" name="commentform" action="<?php echo Url::getActionUrl('comments');?>" id="commentform">
					<input type="hidden" name="aid" value="<?php echo $aid;?>" />
					<?php if(ROLE == ROLE_VISITOR){?>
					<div class="comment_blog"><p>
						<input type="text" name="comname" maxlength="49" placeholder="昵称" value="<?php echo $ckname;?>" size="22" tabindex="1">
						<input type="text" name="commail" placeholder="邮件地址 (选填)" maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2">
						<input type="text" name="comurl" placeholder="个人主页 (选填)" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
					</p></div>
					<?php }?>
					<div class="comment_cont">
						<p><textarea name="comment" required="required" id="comment" rows="10" tabindex="4" placeholder="相信你的评论可以一针见血！"></textarea></p>
						<p><?php echo $verifyCode;?> <input type="submit" id="comment_submit" class="comment_sub" value="立即评论" tabindex="6" /></p>
						<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
					</div>
				</form>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php }?>


<?php
//导航
function site_nav($sortid=0){
	$cache=Conn::getCache();
	$nav_cache=$cache->readCache('nav');
	foreach($nav_cache as $value){
		if($value['top_id']!=0||$value['show']==0){continue;}
		$blank=$value['blank']=='1'?'target="_blank"':'';
		if(!empty($value['children']) || !empty($value['childnav']) ){
?>
		<li>
            <?php if(!empty($value['children'])){?>
                <a href="<?php echo $value['url']; ?>" <?php echo $blank;?>><?php echo $value['name']; ?>▾</a>
                <ul>
                    <?php foreach ($value['children'] as $row){
                        echo '<li><a href="'.Url::sort($row['id']).'">'.$row['sortname'].'</a></li>';
                    }?>
                </ul>
            <?php }?>
            <?php if (!empty($value['childnav'])){?>
                <a href="<?php echo $value['url']; ?>" <?php echo $blank;?>><?php echo $value['name']; ?>▾</a>
                <ul>
                    <?php foreach ($value['childnav'] as $key){
						$blank = $nav_cache[$key]['blank'] == '1' ? 'target="_blank"' : '';
                        echo '<li><a href="'.$nav_cache[$key]['url'] . "\" $blank >" . $nav_cache[$key]['name'].'</a></li>';
                    }?>
                </ul>
            <?php }?>
        </li>
		<?php }else{?>
			<li <?php echo $value['id']==$sortid?'class="active"':'';?>>
				<a href="<?php echo $value['url']; ?>" <?php echo $blank;?>><?php echo $value['name'];?></a>
			</li>
<?php 
		}
	}
}?>


