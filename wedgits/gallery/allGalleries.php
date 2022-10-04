<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/gallery/gallery_<?php echo $pageLang; ?>.css'/>	



<div class="page_content" dir='<?php echo _DIR; ?>'>
<div class='title2'><?php echo Galleries; ?></div>

<?php
$sql='SELECT * FROM `galleries_galleries` where isGallery="1"';
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numrows = mysqli_num_rows($result);
if($numrows > 0){
	$i=0;
	echo "<table class='all_gallery'>";
	while($i<$numrows){
		if($i%4==0 ){echo "</tr><tr>";}
		$gid = mysqli_result($GLOBALS["db_link_conn"], $result,$i,'id');
		$main_photo_id = mysqli_result($GLOBALS["db_link_conn"], $result,$i,'main_photo');
		$lang_v = ($_SESSION['pageLang']=="ar")?'_ar':'';
		$gallery_name = mysqli_result($GLOBALS["db_link_conn"], $result,$i,'gallery_name'.$lang_v);
		$folder = mysqli_result($GLOBALS["db_link_conn"], $result,$i,'folder');
		$main_photo = basename(lookupField('galleries_photos','id','photo',$main_photo_id));
		$thumb='';
		$photo_path = "../../uploads/";


		
		
		if($main_photo){

			$photo_path = str_replace('//','/',"../../uploads/$folder/");
			$upload_path = str_replace('//','/',"../../uploads/");
			$thumb = basename(resizeToFile($photo_path.$main_photo, 400 , 400 , $upload_path."cash/galleryView_".$main_photo));	
			
		}	
					
		if($main_photo_id!=0){	
			//echo "../../uploads/cash/$thumb </br>";
			if(file_exists("../../uploads/cash/$thumb")){
				Crop($upload_path."cash/galleryView_".$main_photo,150,113,$upload_path."cash/galleryViewCroped_".$main_photo);
				$thumb = 'galleryViewCroped_'.$main_photo;
				$src = $upload_path.'cash/'.$thumb;
			}else{	
				Crop($upload_path.$main_photo,150,113,$upload_path."cash/galleryViewCroped_".$main_photo);
				$thumb = 'galleryViewCroped_'.$main_photo;
				$src = $photo_path.$thumb;		
			}
		}
		//$thumb = 'galleryViewCroped_'.$main_photo;
		//$thumb = $main_photo;
	
		if(file_exists($upload_path."cash/$thumb")){
			echo "<td valign='middle' align='center'><a href='"._PREF."view/gallery/viewGallery.php?gid=$gid'><img src='"._PREF."uploads/cash/$thumb'/><br/>$gallery_name</a></td>";
		}elseif(file_exists($photo_path."$thumb")){
			echo "<td valign='middle' align='center'><a href='"._PREF."view/gallery/viewGallery.php?gid=$gid'><img src='".$photo_path."$thumb'/><br/>$gallery_name</a></td>";
		}
		
		$i++;
		
		//if(($i+1)==$numrows){echo"</tr>";}
	}
	echo "</table>";
}




?>
</div>
