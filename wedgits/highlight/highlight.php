<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/highlight/highlight_<?=$pageLang?>.css'/>	
<script type="text/javascript" src="<?=_PREF?>wedgits/highlight/highlight.js"></script>
 
	
<?
$item_counts =3;
$root_path ="uploads/";
if($pageLang=='ar'){$brief_count = 1150;}else{$brief_count = 600;}
$sql = "SELECT * FROM highlight where (publish_date <= date(now())) AND (end_date >= date(now())) ORDER BY publish_date DESC ";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		
		
		$id= MYSQL_RESULT($result,$i,"id");
		$table_name= MYSQL_RESULT($result,$i,"table_name");
		$record_id= MYSQL_RESULT($result,$i,"record_id");
		$publish_date= MYSQL_RESULT($result,$i,"publish_date");
		$end_date= MYSQL_RESULT($result,$i,"end_date");
		
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
				$type_last= MYSQL_RESULT($result,($numrows-1),"type_".$pageLang);
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
$before_item = "<div class=' bt".($numrows-1)." highlight_bt'> ".MYSQL_RESULT($result,($numrows-1),"type_".$pageLang)."</div>";
if($numrows> 3 OR $numrows ==3){
	$after_item = "<div id='' class='bt2 highlight_bt'> ".MYSQL_RESULT($result,1,"type_".$pageLang)."</div>";
}

?>
	<div class='temp_data'><?=$temps?></div>
	<div class="highlight" >
		<div class='high_nav_con'>
			<div class="highlight_nav" >
				<div class='nav_buttons'>
					
					
					<?
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
					<?
						if($numrows>2){?>
							<img class='go_up' onClick='switch_highlight(<?=$item_num?>,"prev")' src='<?=_PREF?>wedgits/highlight/left_arrow_<?=$pageLang?>.png'/>
							<span class='high_nums'><span class='curr_high'>2</span> <?=of?> <?=$item_num?></span>
							<img class='go_down' onClick='switch_highlight(<?=$item_num?>,"next")' src='<?=_PREF?>wedgits/highlight/right_arrow_<?=$pageLang?>.png'/>
						<?}elseif($numrows==2){?>
							<img class='go_up' onClick='switch_highlights(<?=$item_num?>,"prev")' src='<?=_PREF?>wedgits/highlight/left_arrow_<?=$pageLang?>.png'/>
							<span class='high_nums'><span class='curr_high'>2</span> <?=of?> <?=$item_num?></span>
							<img class='go_down' onClick='switch_highlights(<?=$item_num?>,"next")' src='<?=_PREF?>wedgits/highlight/right_arrow_<?=$pageLang?>.png'/>
						<?}?>
					
				</div>
			</div>
		</div>
		<div class='desc_con'>
			<?=$contents?>
		</div>
		
	</div>
	<input type='hidden' class='current' value='1'/>
	<input type='hidden' class='hits' value='1'/>
	
	<?if($numrows>2){?>
		<script>
			count = <?=(73*$numrows)*10-73?>;
			curr_count = <?=(10*$numrows)?>;
			total_count = <?=(10*$numrows)?>;
			
			$('documents').ready(function(){
				$('.nav_buttons').css('top',-count+'px');
			});
		</script>
		<? echo"<script>var timer_news = setTimeout('switch_highlight($numrows,\"next\")',7000);</script>"?>
	<?}elseif($numrows==2){?>
		<script>
			count = <?=(73*$numrows)*10-73?>;
			curr_count = <?=(10*$numrows)?>;
			total_count = <?=(10*$numrows)?>;
			$('documents').ready(function(){
				$('.nav_buttons').css('top','73px');
			});
			
		</script>
		<? echo"<script>var timer_news = setTimeout('switch_highlights($numrows,\"next\")',7000);</script>"?>
	<?}else{?>
		<script>
			$('documents').ready(function(){
				$('.desc1').css('display','inline');
				$('.nav_buttons').css('top','73px');
			});
			
		</script>
	<?}?>