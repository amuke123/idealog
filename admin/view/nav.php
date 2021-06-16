<div class="main" id="main">
	<div class="content">
		<div class="m_title">导航</div>
		<div class="m_content">
			<div class="m_set">
				<div class="left">
					<select name="novesort" onChange="jumpMenu('parent',this,0)">
						<?php foreach($novesorts as $nokey => $noval){?>
							<option value="<?php echo ADMIN_URL ."nav.php";echo $nokey=='0'?'':'?group='.$nokey;?>" <?php echo $group==$nokey?'selected':'';?>><?php echo $noval;?></option>
						<?php }?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<form action="?action=index" method="post" name="myform">
				<?php $code=Checking::getAjCode(12);?>
				<input type="hidden" name='ajcode' id='ajcode' value="<?php echo $code;?>" />
				<div class="m_list" id="m_list">
					<p><b>序号</b><b>导航</b><b>类型</b><b>图片</b><b>打开方式</b><b>状态</b><b>地址</b><b>查看</b><b>操作</b></p>
					<?php
					foreach($navs as $value){
						if($value['group']==$group){
							if($value['top_id']=='0'){
								$picpath=$value['pic']==""?TEMPLATE_URLA .'static/images/img.gif':$value['pic'];
							?>
							<p>
								<span><input type="text" name="num[]" alt="<?php echo $value['id'];?>" value="<?php echo $value['index'];?>" /></span>
								<span class="tleft"><a title="点击编辑导航" href="?action=edit&id=<?php echo $value['id'];?>"><?php echo $value['name'];?></a></span>
								<span>
									<?php
									switch($value['type']){
									case '1':echo '首页';break;
									case '2':echo '<em class="green">系统</em>';break;
									case '3':echo '登录';break;
									case '4':echo '<em class="blue">分类</em>';break;
									case '5':echo '<em class="orange">单页</em>';break;
									default:echo '<em class="red">自定</em>';
									}?>
								</span>
								<span><a <?php echo $value['pic']==""?'':'target="_blank" class="listimg" ';?> title="<?php echo $value['pic']==""?'无图':'点击图片可查看原图';?>" href="<?php echo $value['pic']==""?'':$picpath;?>"><img src="<?php echo $picpath;?>" /></a></span>
								<span><?php echo $value['blank']==0?'<img title="当前页" src="'. TEMPLATE_URLA .'static/images/vlog2.gif" />':'<img title="新页面" src="'. TEMPLATE_URLA .'static/images/vlog.gif" />';?></span>
								<span><a href="javascript:showOrHide('<?php echo $value['id']."','".IDEA_URL."','";echo $value['show']==0?'1':'0';?>','nav');"><?php echo $value['show']==0?'<img title="隐藏" src="'. TEMPLATE_URLA .'static/images/plugin_inactive.gif" />':'<img title="显示" src="'. TEMPLATE_URLA .'static/images/plugin_active.gif" />';?></a></span>
								<span class="tleft"><?php echo $value['type']=='1'?IDEA_URL:$value['url'];?></span>
								<span><a target="_blank" href="<?php echo Url::nav($value['type'],$value['typeId'],$value['url']);?>"><img title='查看' src='<?php echo TEMPLATE_URLA . "static/images/eye.png";?>' /></a></span>
								<span><?php if($value['change']=='1'){?><a href="javascript:delLine('<?php echo $value['id']."','".IDEA_URL;?>','nav');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a><?php }?></span>
							</p>
							<?php 
								$childnav=isset($value['childnav'])?$value['childnav']:'';
								if($childnav!=''){
								foreach($childnav as $val){
									$picpath2=$navs[$val]['pic']==""?TEMPLATE_URLA .'static/images/img.gif':$navs[$val]['pic'];
								?>
									<p>
										<span><input type="text" name="num[]" alt="<?php echo $navs[$val]['id'];?>" value="<?php echo $navs[$val]['index'];?>" /></span>
										<span class="tleft"><a title="点击编辑导航" href="?action=edit&id=<?php echo $navs[$val]['id'];?>">------<?php echo $navs[$val]['name'];?></a></span>
										<span>
											<?php
											switch($navs[$val]['type']){
											case '1':echo '首页';break;
											case '2':echo '<em class="green">系统</em>';break;
											case '3':echo '登录';break;
											case '4':echo '<em class="blue">分类</em>';break;
											case '5':echo '<em class="orange">单页</em>';break;
											default:echo '<em class="red">自定</em>';
											}?>
										</span>
										<span><a <?php echo $navs[$val]['pic']==""?'':'target="_blank" class="listimg" ';?> title="<?php echo $navs[$val]['pic']==""?'无图':'点击图片可查看原图';?>" href="<?php echo $navs[$val]['pic']==""?'':$picpath2;?>"><img src="<?php echo $picpath2;?>" /></a></span>
										<span><?php echo $navs[$val]['blank']==0?'<img title="当前页" src="'. TEMPLATE_URLA .'static/images/vlog2.gif" />':'<img title="新页面" src="'. TEMPLATE_URLA .'static/images/vlog.gif" />';?></span>
										<span><a href="javascript:showOrHide('<?php echo $navs[$val]['id']."','".IDEA_URL."','";echo $navs[$val]['show']==0?'1':'0';?>','nav');"><?php echo $navs[$val]['show']==0?'<img title="隐藏" src="'. TEMPLATE_URLA .'static/images/plugin_inactive.gif" />':'<img title="显示" src="'. TEMPLATE_URLA .'static/images/plugin_active.gif" />';?></a></span>
										<span class="tleft"><?php echo $navs[$val]['url'];?></span>
										<span><a target="_blank" href="<?php echo Url::nav($navs[$val]['type'],$navs[$val]['typeId'],$navs[$val]['url']);?>"><img title='查看' src='<?php echo TEMPLATE_URLA . "static/images/eye.png";?>' /></a></span>
										<span><?php if($value['change']=='1'){?><a href="javascript:delLine('<?php echo $navs[$val]['id']."','".IDEA_URL;?>','nav');"><img title='删除' src='<?php echo TEMPLATE_URLA . "static/images/icon_error.gif";?>' /></a><?php }?></span>
									</p>
								<?php
								}}
							}
						}
					}
					?>
				</div>
				<div class="m_button">
					<input type="button" onClick="change_index('<?php echo IDEA_URL;?>','nav');" class="m_sub" name='tj' value='更改排序' /><input type="button" onClick="anavshow(1);" class="m_but" name='add' value='新建按钮 +' />
				</div>
			</form>
		</div>
		
	</div>
</div>
<div class="addnavbg" id="addnav">
	<div class="addnav">
		<div class="addnav_top">
			<ul id='addk'>
				<li class='active2' onClick="navbh(1);">自定义</li>
				<li onClick="navbh(2);">分类</li>
				<li onClick="navbh(3);">单页</li>
				<span onclick="anavshow(0);">取消</span>
			</ul>
		</div>
		<div class="addl" id="nav1" style="display:block;">
			<div class="anavtitle">添加自定义导航</div>
			<div class="m_add2">
				<form action="" method="post" name="navadddiy" onSubmit="return yzNavAdd();" enctype="multipart/form-data">
					<input type="hidden" name="id" value="" />
					<p><input type="text" class="formin" name="index" value="" placeholder="序号" /></p>
					<p><input type="text" class="formput" name="name" value="" placeholder="导航名称" /></p>
					<p><input type="text" class="formput" name="url" value="" placeholder="链接(带http或https)" /></p>
					<p>
						<select name="group" class="formsele">
							<?php foreach($novesorts as $nokey => $noval){?>
							<option value="<?php echo $nokey;?>" <?php echo $group==$nokey?'selected':'';?>><?php echo $noval;?></option>
							<?php }?>
						</select>
					</p>
					<div class="group">
						<p><b>导航图标(无图标可忽略)</b></p>
						<p><input type="file" class="formfile" name="pic" /></p>
					</div>
					<p>
						<select name="topid" class="formsele">
							<option value="0">无</option>
							<?php
							foreach($navs as $valuena){
								if($valuena['group']==$group){
									if($valuena['type']=='0'&&$valuena['top_id']=='0'){
							?>
									<option value="<?php echo $valuena['id'];?>"><?php echo $valuena['name'];?></option>
							<?php 
									}
								}
							}?>
						</select> 父导航
					</p>
					<p>
						<select name="blank" class="formsele">
							<option value="0">当前页打开</option>
							<option value="1">新页面打开</option>
						</select>
					</p>
					<p class="m_button"><input type="submit" class="m_sub" name='adddiy' value='添加' /><input type="button" onclick="anavshow(0);" class="m_but2" value='取消' /></p>
				</form>
			</div>
		</div>
		<div class="addl" id="nav2">
			<div class="anavtitle">添加分类导航</div>
			<div class="m_add2">
				<form action="" method="post" name="navaddsort" onSubmit="return yzNavAdd2();">
					<input type="hidden" name="group" value="<?php echo $group;?>" />
					<?php 
					foreach($sorts as $values){
						if($values['top_id']==0){
					?>
							<p>&nbsp;&nbsp;<input type="checkbox" name="sck[]" value="<?php echo $values['id'];?>" /> <span class="naddnav"><?php echo $values['sortname'];?></span></p>
					<?php 
							$children=$values['children'];
							foreach($children as $val){
					?>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sck[]" value="<?php echo $sorts[$val]['id'];?>" /> <span class="naddnav">↦<?php echo $sorts[$val]['sortname'];?></span></p>
					<?php 
								if(isset($sorts[$val]['children'])){
									foreach($sorts[$val]['children'] as $v){
					?>
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sck[]" value="<?php echo $sorts[$v]['id'];?>" /> <span class="naddnav">↦<?php echo $sorts[$v]['sortname'];?></span></p>
					<?php 
									}
								}
							}
						}
					}?>
					<p class="m_button"><input type="submit" class="m_sub" name='addsort' value='添加' /><input type="button" onclick="anavshow(0);" class="m_but2" value='取消' /></p>
				</form>
			</div>
		</div>
		<div class="addl" id="nav3">
			<div class="anavtitle">添加页面导航</div>
			<div class="m_add2">
				<form action="" method="post" name="navaddpage" onSubmit="return yzNavAdd3();">
					<input type="hidden" name="group" value="<?php echo $group;?>" />
					<?php foreach($pages as $valuep){?>
						<p>&nbsp;&nbsp;<input type="checkbox" name="pck[]" value="<?php echo $valuep['id'];?>" /> <span class="naddnav"><?php echo $valuep['title'];?></span></p>
					<?php }?>
					<p class="m_button"><input type="submit" class="m_sub" name='addpage' value='添加' /><input type="button" onclick="anavshow(0);" class="m_but2" value='取消' /></p>
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow('eye','nav');
}
</script>