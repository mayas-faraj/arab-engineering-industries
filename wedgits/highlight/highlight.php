<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/highlight/highlight_<?php echo $pageLang; ?>.css'/>	
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/highlight/highlight.js"></script>
 
	
<?php
$item_counts =3;
$root_path ="uploads/";
if($pageLang=='ar'){$brief_count = 1150;}else{$brief_count = 600;}
$sql = "SELECT * FROM highlight where (publish_date <= date(now())) AND (end_date >= date(now())) ORDER BY publish_date DESC ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numrows = mysqli_num_rows($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		
		
		$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
		$table_name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"table_name");
		$record_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"record_id");
		$publish_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"publish_date");
		$end_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"end_date");
		
		switch($table_name){
			case 'resources':
				$title= lookupField('resources','id','title',$record_id);
				$brief= limit(lookupField('resources','id','brief',$record_id),$brief_count);
				$photo= lookupField('resources','id','photo',$record_id);
				$link = 'view/resources/viewResources.php?id='.$record_id;
			break;
			
			case 'news_news':
				if($pageLang=='ar'){$langPref = '_ar';}else{$langPref = '';}
				$brief= limit(lookupField($table_name,'id','brief'.$langPref,$record_id),$brief_count);
				$title= lookupField($table_name,'id','subject'.$langPref,$record_id);
				$gal_id= lookupField($table_name,'id','gallery',$record_id);
				$photo_id= lookupField('galleries_galleries','id','main_photo',$gal_id);
				$folder= lookupField('galleries_galleries','id','folder',$gal_id);
				$photo= lookupField('galleries_photos','id','photo',$photo_id);
				$link = 'view/Anouncements/viewAnnounceDetails.php?id='.$record_id;
			break;
			
			case 'mem_activities':
				if($pageLang=='ar'){$langPref = '_ar';}else{$langPref = '';}
				$brief= limit(lookupField($table_name,'id','brief'.$langPref,$record_id),$brief_count);
				$title= lookupField($table_name,'id','subject'.$langPref,$record_id);
				$gal_id= lookupField($table_name,'id','gal_id',$record_id);
				$photo_id= lookupField('galleries_galleries','id','main_photo',$gal_id);
				$folder= lookupField('galleries_galleries','id','folder',$gal_id);
				$folder= ($folder!=0)? $folder : '';;
				$photo= lookupField('galleries_photos','id','photo',$photo_id);
				$link = 'view/activities/viewActivities.php?id='.$record_id;
			break;
		}
		if($table_name=='resources'){	
			
		}else{
			
		}
		

		if($photo){
			$root_path = str_replace('//','/',"uploads/$folder/");
			$photo = str_replace('../../uploads/','',$photo);
			$photo2 = basename($photo);
			$thumb = resizeToFile($root_path.$photo, 190 , 190 , $root_path."cash/highlight_".$photo);	
			$src =  $root_path."cash/highlight_$photo2";
			if(!file_exists($src)){
				$src =  $root_path.$photo;
			}
			
		}else{
			$src = 'css/def_home.png';
		}
					
		
		$item_num = $i + 1;
			if($item_num==1){
				$type_last= mysqli_result($GLOBALS["db_link_conn"], $result,($numrows-1),"type_".$pageLang);
				$buttons .="<div class='bt$item_num highlight_bt_active'><span>$title</span></div>";
			}	
			else{
				$buttons .="<div class='bt$item_num highlight_bt'><span>$title</span></div>";
			}
			$temps .="<div class='temp$item_num '><div class='bt$item_num highlight_bt'><span>$title</span></div></div>";

		$contents .= '
		<a   href="'._PREF.$link.'">
			<div class="desc'.$item_num.' highlight_desc">
				<div class="highlight_img"><img src="'.$src.'" /></div>
				<div class="highlight_txt">
				'.$brief.'
				</div>
			</div>
		</a>';
		
		
		$i++;
	}
	
}
$before_item = "<div class=' bt".($numrows-1)." highlight_bt'> ".mysqli_result($GLOBALS["db_link_conn"], $result,($numrows-1),"type_".$pageLang)."</div>";
if($numrows> 3 OR $numrows ==3){
	$after_item = "<div id='' class='bt2 highlight_bt'> ".mysqli_result($GLOBALS["db_link_conn"], $result,1,"type_".$pageLang)."</div>";
}

?>
	<div class='temp_data'><?php echo $temps; ?></div>
	<div class="highlight" >
		<div class='high_nav_con'>
			<div class="highlight_nav" >
				<div class='nav_buttons'>
					
					
					<?php
					if($numrows>2){
						for($i=0; $i<20; $i++){
							echo $buttons;
						}
					}else{
						echo $buttons;
					}
					?>
					
				</div>
				
			</div>
			<div class='heighlight_switcher'>
				<div class='nav'>
					<?php if($numrows>2): ?>
							<img class='go_up' onClick='switch_highlight(<?php echo $item_num; ?>,"prev")' src='<?php echo _PREF; ?>wedgits/highlight/left_arrow_<?php echo $pageLang; ?>.png'/>
							<span class='high_nums'><span class='curr_high'>2</span> <?php echo "of"; ?> <?php echo $item_num; ?></span>
							<img class='go_down' onClick='switch_highlight(<?php echo $item_num; ?>,"next")' src='<?php echo _PREF; ?>wedgits/highlight/right_arrow_<?php echo $pageLang; ?>.png'/>
						<?php elseif($numrows==2): ?>
							<img class='go_up' onClick='switch_highlights(<?php echo $item_num; ?>,"prev")' src='<?php echo _PREF; ?>wedgits/highlight/left_arrow_<?php echo $pageLang; ?>.png'/>
							<span class='high_nums'><span class='curr_high'>2</span> <?php echo "of"; ?> <?php echo $item_num; ?></span>
							<img class='go_down' onClick='switch_highlights(<?php echo $item_num; ?>,"next")' src='<?php echo _PREF; ?>wedgits/highlight/right_arrow_<?php echo $pageLang; ?>.png'/>
						<?php endif; ?>
					
				</div>
			</div>
		</div>
		<div class='desc_con'>
			<?php echo $contents; ?>
		</div>
		
	</div>
	<input type='hidden' class='current' value='1'/>
	<input type='hidden' class='hits' value='1'/>
	
	<?php if($numrows>2): ?>
		<script>
			count = <?php echo (73*$numrows)*10-73; ?>;
			curr_count = <?php echo (10*$numrows); ?>;
			total_count = <?php echo (10*$numrows); ?>;
			
			$('documents').ready(function(){
				$('.nav_buttons').css('top',-count+'px');
			});
		</script>
		<?php echo"<script>var timer_news = setTimeout('switch_highlight($numrows,\"next\")',7000);</script>"?>
	<?php elseif($numrows==2): ?>
		<script>
			count = <?php echo (73*$numrows)*10-73; ?>;
			curr_count = <?php echo (10*$numrows); ?>;
			total_count = <?php echo (10*$numrows); ?>;
			$('documents').ready(function(){
				$('.nav_buttons').css('top','73px');
			});
			
		</script>
		<?php echo"<script>var timer_news = setTimeout('switch_highlights($numrows,\"next\")',7000);</script>"?>
	<?php else: ?>
		<script>
			$('documents').ready(function(){
				$('.desc1').css('display','inline');
				$('.nav_buttons').css('top','73px');
			});
			
		</script>
	<?php endif; ?>
