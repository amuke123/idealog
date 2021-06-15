<div class="main" id="main">
	<div class="content">
		<div class="m_title">管理首页</div>
		<!--div class="m_warning"><span><i class="icon aicon-infor"></i></span>：出于演示站完整性考虑，演示站不开放图片上传和删除功能，且每次有用户登录演示后台时</div>
		<div class="m_warning"><span><i class="icon aicon-infor"></i></span>：出于演示站完整性考虑，演示站不开放图片上传和删除功能，且每次有用户登录演示后台时，数据都将被自动还原</div-->
		<!--div class="m_infor"><i class="icon-bell"></i><b>提示：</b>如果统计数据不准确，请点击此处<a href="#">更新缓存</a>即可更新为网站最新数据。</div-->
		<div class="m_info left">
			<div class="m_i_title"><i class="icon aicon-info"></i>站点信息</div>
			<div class="m_i_list">
				<ul>
					<li>有 <?php echo $sta_cache['artnum'];?> 篇文章， <?php echo $sta_cache['sayall'];?> 条评论，<?php echo $sta_cache['usernum'];?> 位注册会员</li>
					<li>数据库表前缀：<?php echo DB_PRE;?></li>
					<li>PHP版本：<?php echo $php_ver;?></li>
					<li>MySQL版本：<?php echo $mysql_ver;?></li>
					<li>服务器环境：<?php echo $serverapp;?></li>
					<li>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize;?></li>
				</ul>
			</div>
		</div>
		<div class="m_info right">
			<div class="m_i_title"><i class="icon aicon-infor"></i>官方消息</div>
			<div class="m_i_list">
				<ul>
					<li><a href="#">IDEASHU V 1.0.0 发布了，都有神马好功能！</a><span>2020-05-08</span></li>
					<li><a href="#">IDEASHU666</a><span>2020-05-08</span></li>
					<li><a href="#">厉害了，我的IDEASHU</a><span>2020-05-08</span></li>
					<li><a href="#">IDEASHU真好用</a><span>2020-05-08</span></li>
					<li><a href="#">今天是IDEASHU V 1.0.0 发布的日子</a><span>2020-05-08</span></li>
					<li><a href="#">今天随便看IDEASHU V 1.0.0 发布</a><span>2020-05-08</span></li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>

	</div>
</div>