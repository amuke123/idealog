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
		<div class="m_tab">
			<ul>
				<li><span>笔记</span></li>
				<li><a href="?draft=0">草稿</a></li>
				<li><a href="?examine=0">审核</a></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div class="m_set">
			<div class="left">
				<select name="novesort" onchange="jumpMenu('parent',this,0)">
					<option value="#">全部分类笔记..</option>
					<option value="url">创意</option>
					<option value="url">设计</option>
					<option value="url">手工</option>	
					<option value="url">未分类</option>
				</select>
			</div>
			<div class="right">
				<form action="" method="get" name="myso">
					<input type="text" name="keyword" class="formc" placeholder="搜索文章">
				</form>
			</div>
		</div>
		<div class="clear"></div>
		<div class="m_list" id="m_list">
			<p><b></b><b>标题</b><b>作者</b><b>分类</b><b>查看</b><b>时间</b><b>评论</b><b>阅读</b><b>赞</b><b>踩</b></p>
			<p>
				<span><input type="checkbox" name="artck[]" value="203"></span>
				<span class="tleft">
					<a title="点击标题编辑笔记" href="#203">网站入口文件编辑 index.php</a>
					<img src="<?php echo TEMPLATE_URLA;?>static/images/att.gif" title="附件数：1">
				</span>
				<span><a href="./author=1">少年</a></span>
				<span><a href="./sortid=9">程序</a></span>
				<span><a target="_blank" href="./203.html"><img title="查看" src="<?php echo TEMPLATE_URLA;?>static/images/eye.png"></a></span>
				<span>2021-06-02 14:09:16</span>
				<span><a href="#say203">0</a></span>
				<span>12</span>
				<span>0</span>
				<span>0</span>
			</p>
			<p>
				<span><input type="checkbox" name="artck[]" value="202"></span>
				<span class="tleft">
					<a title="点击标题编辑笔记" href="#202">网站文档结构</a>
					<img src="<?php echo TEMPLATE_URLA;?>static/images/att.gif" title="附件数：2">
				</span>
				<span><a href="./author=1">少年</a></span>
				<span><a href="./sortid=9">程序</a></span>
				<span><a target="_blank" href="./202.html"><img title="查看" src="<?php echo TEMPLATE_URLA;?>static/images/eye.png"></a></span>
				<span>2021-06-02 13:37:02</span>
				<span><a href="#say202">0</a></span>
				<span>18</span>
				<span>0</span>
				<span>0</span>
			</p>
			<p>
				<span><input type="checkbox" name="artck[]" value="201"></span>
				<span class="tleft">
					<a title="点击标题编辑笔记" href="#201">数据库设计</a>
					<img src="<?php echo TEMPLATE_URLA;?>static/images/att.gif" title="附件数：2">
				</span>
				<span><a href="./author=1">少年</a></span>
				<span><a href="./sortid=9">程序</a></span>
				<span><a target="_blank" href="./201.html"><img title="查看" src="<?php echo TEMPLATE_URLA;?>static/images/eye.png"></a></span>
				<span>2021-06-02 09:22:06</span>
				<span><a href="#say201">0</a></span>
				<span>32</span>
				<span>0</span>
				<span>0</span>
			</p>
		</div>
		<div class="clear"></div>
		<div class="m_set">
			<a id="allselect" href="javascript:allSelect('allselect');">全选</a> 选中项：<a class="red" href="javascript:delList('https://www.ideashu.cn/','article');">删除</a> | <a href="javascript:setDraft('https://www.ideashu.cn/','article');">放入草稿箱</a> | 
			<select name="top" onchange="setTop(this,'https://www.ideashu.cn/');">
				<option value="">置顶操作..</option>
				<option value="T">首页置顶</option>
				<option value="ST">分类置顶</option>
				<option value="0">取消置顶</option>
			</select> 
			<select name="novesort" onchange="moveSort(this,'https://www.ideashu.cn/');">
				<option value="">移动分类..</option>
				<option value="1">创意</option>
				<option value="2">设计</option>
				<option value="3">手工</option>
				<option value="0">未分类</option>
			</select>
		</div>
		<div class="clear"></div>
		<div class="m_button">
			<input type="button" onclick="javascript:change_index('https://www.ideashu.cn/','banner');" class="m_sub" name="tj" value="更改排序">
			<input type="button" onclick="javascript:show_add('banner_add');" class="m_but" name="add" value="添加轮换图 +">
		</div>
		<div class="clear"></div>
		<div class="m_page">
			<span>1</span>
			<a href="#page=2">2</a>
			<a href="#page=3">3</a>
			<a href="#page=4">4</a>
			<a href="#page=5">5</a>
			... 
			<a href="#page=16">16</a>(有 188 篇笔记)
		</div>
		<div class="clear"></div>
		
	</div>
</div>