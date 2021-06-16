<div class="main" id="main">
	<div class="content">
		<div class="m_title">用户列表</div>
		<div class="m_content">
			<div class="m_tab">
				<ul>
					<li><?php echo $state==0||$examine==0?'<a href="'. ADMIN_URL .'user.php">全部</a>':'<span>全部</span>';?></li>
					<?php if(ROLE==ROLE_ADMIN){?>
					<li><?php echo $examine==1?'<a href="?examine=0">审核</a>':'<span>审核</span>';?></li>
					<li><?php echo $state==1?'<a href="?state=0">禁言和封禁</a>':'<span>禁言和封禁</span>';?></li>
					<?php }?>
				</ul>
			</div>
			<div class="m_content">
				<form action="" method="post" name="myform">
					<div class="m_list" id="m_list">
						<p><b>头像</b><b>昵称</b><b>权限</b><b>简介</b><b>电子邮件</b><b>手机</b><b>文章</b><b>个性域名</b><b>注册时间</b><b>操作</b></p>
						<?php
						foreach($users as $value){
							$uinfo=user_Model::getInfo($value['id']);
							$pic=empty($uinfo['photo'])?TEMPLATE_URLA .'static/images/avatar.jpg': str_replace('../',IDEA_URL,$uinfo['photo']);
						?>
							<p>
								<span><i class="listimg"><img src="<?php echo $pic;?>" /></i></span>
								<span class="rightfx">
								<a href="?action=edit&id=<?php echo $uinfo['id'];?>"><?php echo $uinfo['name'];?></a> 
								<?php 
								if($uinfo['check']=='0'){
									echo "<em class='red'><img class='iconpic' title='未审核' src='". TEMPLATE_URLA ."static/images/check.png' /></em>";
								}
								if($state=='0' && $uinfo['state']!='0'){
									if($uinfo['state']=='1'){
										echo "<em class='red'><img title='已禁言' src='". TEMPLATE_URLA ."static/images/nosay.png' /></em>";
									}
									if($uinfo['state']=='2'){
										echo "<em class='red'><img title='已封禁' src='". TEMPLATE_URLA ."static/images/no2.png' /></em>";
									}
									if($uinfo['state']=='3'){
										echo "<em class='red'><img title='已永久封禁' src='". TEMPLATE_URLA ."static/images/no.png' /></em>";
									}
								}
								?>
								</span>
								<span><?php echo $uinfo['role']==ROLE_ADMIN?'管理员':'作者';?></span>
								<span><?php echo $uinfo['description'];?></span>
								<span class="rightfx"><?php echo $uinfo['email'];?> <?php if($uinfo['email']!=''){echo $uinfo['emailok']==0?"<img class='iconpic' title='未认证' src='". TEMPLATE_URLA ."static/images/onsel2.gif' />":"<img class='iconpic' title='已认证' src='". TEMPLATE_URLA ."static/images/onsel.gif' />";}?></span>
								<span class="rightfx"><?php echo $uinfo['tel'];?> <?php if($uinfo['tel']!=''){echo $uinfo['telok']==0?"<img class='iconpic' title='未认证' src='". TEMPLATE_URLA ."static/images/onsel2.gif' />":"<img class='iconpic' title='已认证' src='". TEMPLATE_URLA ."static/images/onsel.gif' />";}?></span>
								<span><?php echo $uinfo['artnum'];?></span>
								<span><?php echo $uinfo['diyurl'];?></span>
								<span><?php echo !empty($uinfo['date'])?date("Y-m-d H:i",$uinfo['date']):'';?></span>
								<span>
								<?php 
								if($examine=='1' && $state=='1'){
									if($uinfo['role']!=ROLE_ADMIN){
										if($uinfo['state']=='0'){
											echo "<a href='". ADMIN_URL ."user.php?action=do&id=".$uinfo['id']."&doid=1'><em><img title='禁言' src='". TEMPLATE_URLA ."static/images/nosay.png' /></em></a> ";
											echo "<a href='". ADMIN_URL ."user.php?action=do&id=".$uinfo['id']."&doid=2'><em><img title='封禁' src='". TEMPLATE_URLA ."static/images/no2.png' /></em></a> ";
											echo "<a href='". ADMIN_URL ."user.php?action=do&id=".$uinfo['id']."&doid=3'><em><img title='永久封禁' src='". TEMPLATE_URLA ."static/images/no.png' /></em></a> ";
										}else{
											$texta='';if($uinfo['state']=='1'){$texta='禁言';}if($uinfo['state']=='2'){$texta='封禁';}if($uinfo['state']=='3'){$texta='永久封禁';}
											echo "<em>已".$texta." </em> ";
										}
										echo " | <a href='javascript:deluser(\"". ADMIN_URL ."user.php?action=del&id=".$uinfo['id']."\");'><em class='red'><img title='删除用户' src='". TEMPLATE_URLA ."static/images/icon_error.gif' /></em></a> ";
									}
								}
								if($examine=='0' && $uinfo['check']=='0'){
									echo "<a href='". ADMIN_URL ."user.php?action=check&id=".$uinfo['id']."&examine=0'><em class='red'>审核</em></a> ";
								}
								if($state=='0' && $uinfo['state']!='0'){
									if($uinfo['state']!='3'){
										echo "<a href='". ADMIN_URL ."user.php?action=state&id=".$uinfo['id']."&state=0'><em class='red'>解禁</em></a> ";
									}else{
										//echo "<a href='". ADMIN_URL ."user.php?action=state&id=".$uinfo['id']."&state=0'><em class='red'>解禁</em></a> ";
										echo "<em class='red'><img title='永久禁言，无法解禁' src='". TEMPLATE_URLA ."static/images/no1.png' /></em>";
									}
								}
								?>
								</span>
							</p>
					<?php 
						}
					?>
					</div>
					<div class="m_page">
						<?php echo $pagestr;?>
					</div>
					<div class="m_button">
						<input type="button" onClick="javascript:location.href='?action=add';" class="m_but" name='add' value='添加用户 +' />
					</div>
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('ulist','user');
}
</script>