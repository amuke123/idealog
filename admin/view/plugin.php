<div class="main" id="main">
	<div class="content">
		<div class="m_title">插件</div>
		
		<div class="clear"></div>
	</div>
</div>
<script>
window.onload=function(){
	autoShow(<?php echo $plugin?"'extend','more_".$plugin."'":"'sys','plugin'";?>);
}
</script>