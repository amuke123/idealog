<?php
if(!defined('IDEA_ROOT')){exit('error!');}
?>

<?php
//导航
function site_nav($sortid=0){
	$cache=Conn::getCache();
	$nav_cache=$cache->readCache('nav');
	$sort_cache=$cache->readCache('sort');
	foreach($nav_cache as $value){
		if($value['top_id']!=0||$value['show']==0){continue;}
		$blank=$value['blank']=='1'?'target="_blank"':'';
		if(!empty($value['children']) || !empty($value['childnav']) ){
?>
		<li>
            <?php if(!empty($value['children'])){?>
                <a href="<?php echo IDEA_URL .$value['url']; ?>" <?php echo $blank;?>><?php echo $value['name']; ?>▾</a>
                <ul>
                    <?php foreach ($value['children'] as $row){
                        echo '<li><a href="'.Url::sort($row['id']).'">'.$row['sortname'].'</a></li>';
                    }?>
                </ul>
            <?php }?>
            <?php if (!empty($value['childnav'])){?>
                <a href="<?php echo IDEA_URL .$value['url']; ?>" <?php echo $blank;?>><?php echo $value['name']; ?>▾</a>
                <ul>
                    <?php foreach ($value['childnav'] as $key){
						$blank = $nav_cache[$key]['blank'] == '1' ? 'target="_blank"' : '';
                        echo '<li><a href="'.IDEA_URL .$nav_cache[$key]['url'] . "\" $blank >" . $nav_cache[$key]['name'].'</a></li>';
                    }?>
                </ul>
            <?php }?>
        </li>
		<?php }else{?>
			<li <?php echo $value['id']==$sortid?'class="active"':'';?>>
				<a href="<?php echo IDEA_URL .$value['url']; ?>" <?php echo $blank;?>><?php echo $value['name'];?></a>
			</li>
<?php 
		}
	}
}?>


