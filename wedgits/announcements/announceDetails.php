<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/announcements/announcements_<?php echo $pageLang; ?>.css'/>	
<div class="page_content" dir='<?php echo _DIR; ?>'>

	<?php
$photo_path ="../../uploads/";
$news_id = cleanString($_REQUEST['id']);

$sql =  "SELECT * FROM news_news WHERE (id=$news_id) ";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		if($pageLang=='ar'){$langPref = '_ar';}else{$langPref = '';}
		$id=mysql_result($result, $i,"id");
		$subject=mysql_result($result, $i,"subject".$langPref);
		$pdate=mysql_result($result, $i,"pdate");
		$txt=mysql_result($result, $i,"details".$langPref);
		$prepared = mysql_result($result, $i,"prepared");
		
		$start_date=mysql_result($result, $i,"publish_date");
		if($start_date=='0000-00-00'){
			$start_date='';
		}else{
			$start_date=date('d / m / Y',strtotime($start_date));
		}
		
		$gallery= MYSQL_RESULT($result,$i,"gallery");		
		$src='';
		$main_photo_id=0;
		if($gallery){
			$main_photo_id = lookupField('galleries_galleries','id','main_photo',$gallery);
			$main_photo = basename(lookupField('galleries_photos','id','photo',$main_photo_id));
			$folder = lookupField('galleries_galleries','id','folder',$gallery);
			$photo_path = str_replace('//','/',"../../uploads/$folder/");
			$upload_path = str_replace('//','/',"../../uploads/");
			$thumb = basename(resizeToFile($photo_path.$main_photo, 400 , 300 , $upload_path."cash/viewAnn_".$main_photo));	
		}	
					
		if($main_photo_id!=0){			
			if(file_exists("../../uploads/cash/$thumb")){
				$src = $upload_path.'cash/'.$thumb;
			}else{	
				$src = $photo_path.$thumb;		
			}
		}
		if($src){
			$act_img = "<img src='$src'/>";
		}else{
			$act_img = "";
		}
		

		?>
	<div class="title2"><?php echo $subject; ?></div>
	<div class="annonce_details">
		<div class="annonce_details_body">
			<div class="annonce_img"><?php echo $act_img; ?></div>
			<div class="annonce_details_txt"><?php echo $txt; ?></div>
		</div>
		<div class="annonce_info">
		<?php echo on; ?> : <?php echo $start_date; ?>
		
		</div>
	
	</div>
		<?php
		$i++;
	}
}

?>                                                   
<input type='button' value='<?php echo Back; ?>' class='more_btn' onClick='history.back()'/>                            
</div>