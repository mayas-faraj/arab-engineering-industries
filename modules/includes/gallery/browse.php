<?php
session_start();
header("cache-control: no-cache"); 
require_once('../../../config.php'); 
require_once('../../common/dbConnection.php'); 
include_once("../../includes/dbUtils.php");
if(checkGallogin()){
	$img_arr = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
	$gid=$_SESSION['gid'];
	if($gid){?>
	<script>
	function fixPhotos(){
		var orderChanges="";
		$("#gal_order div[class=thumb]").each(function(){
			var columnId=$(this).attr("id");
			orderChanges+=columnId+",";				
		});
		var orderChanges=orderChanges.substr(0,orderChanges.length-1);
		loader(1);
		$.post("orderPhotos.php", {gid:<?php echo $gid; ?>,ids:orderChanges} ,function(data){
			loader(0);
			if(data!=''){
				setMainPhoto(data);
			}
		});	
	}
	$(document).ready(function(){
		fixPhotos();
		$("#gal_order").hover(function(){
			$(this).css( "cursor", "move" );
		});		
		$("#gal_order").sortable({
			connectWith: "div",
			cursor: "move",
			forcePlaceholderSize: true,
			opacity: 1,
			stop: function(event, ui){
				var orderChanges="";
				var sortorder="";
				$("#gal_order div[class=thumb]").each(function(){
					var columnId=$(this).attr("id");
					orderChanges+=columnId+",";				
				});
				var orderChanges=orderChanges.substr(0,orderChanges.length-1);
				loader(1);
				$.post("orderPhotos.php", {gid:<?php echo $gid; ?>,ids:orderChanges} ,function(data){				
					loader(0);
				});	
			}
		})
	})
	</script>
	<input name="des2" type="hidden" id="des2" value="d" size="100"><?php
	$sql = "SELECT * FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numberOfRows = mysqli_num_rows($result);
	if ($numberOfRows>0) {
		$gallery_name= mysqli_result($GLOBALS["db_link_conn"], $result,0,"gallery_name_en");
		$description= mysqli_result($GLOBALS["db_link_conn"], $result,0,"description_en");
		$mph= mysqli_result($GLOBALS["db_link_conn"], $result,0,"main_photo");
		$photos= mysqli_result($GLOBALS["db_link_conn"], $result,0,"photos");
		$resPhotos=explode(',',$photos);
		if( $photos != ''){
			$sql = "SELECT * FROM galleries_photos where id IN ($photos) ORDER BY FIELD(id,$photos);";
			$resPhotos=array();
	
			$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
			$numberOfRows = mysqli_num_rows($result);
			$i=0;
			
			?><div id="gal_order"><?php
			while ($i<$numberOfRows){
				$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
				$photo= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo");
				$description= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"description");
				$thumb= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"thumb");
				if($thumb!='video'){
					resizeToFile('../../../uploads/'.$folder.$photo, 90, 90,'../../../uploads/'.$thumb); 
					$thumbN=_PREF.'uploads/'.$thumb;		
				}else{
					$thumbN=_PREFICO.'video.png';
				}
				$MainPhotoClass='mainPhoto';
				if($mph==$id){
					$MainPhotoClass='mainPhotoAct';
					echo '<script>mainPhoto='.$id.'</script>';
				}
				resizeToFile('../../../uploads/'.$photo, 90, 90,'../../../uploads/'.$thumb); ?>
				<div class="thumb" align="center" id="<?php echo $id; ?>">
				<div class="<?php echo $MainPhotoClass; ?>" id="main_<?php echo $id; ?>" onClick="setMainPhoto(<?php echo $id; ?>)"></div>
				<div class="img_des" id="des<?php echo $id; ?>"  
				onMouseOut="viewDes(<?php echo $id; ?>,0)"><div><?php echo $photo.'<br>'.stripslashes($description); ?></div></div>
				<div class="thumb_img" align="center" style="background-image:url(<?php echo $thumbN; ?>)" 
				onMouseOver="viewDes(<?php echo $id; ?>,1)"></div>
				<?php 
				$bgcol='abe656';
				$checked='checked';?>
				<div class="thumb_tools" style="background-color:#<?php echo $bgcol; ?>" id="tools_<?php echo $id; ?>" >
				<div>
				<input type="checkbox" id="ch_<?php echo $id; ?>"  value="<?php echo $id; ?>" <?php echo $checked; ?> onClick="addToGallery(<?php echo $id; ?>,2)" />
				</div><div>	
				<img src="../css/images/icons/Delete.png" width="20" hspace="3" style="cursor:pointer" 
				onClick="del_photo(<?php echo $id; ?>,'info',2)"/>
				</div><div>
				<img src="../css/images/icons/Edit.png" width="20" hspace="3" style="cursor:pointer" 
				onClick="edit_photo(<?php echo $id; ?>,'<?php echo $description; ?>','<?php echo $thumb; ?>',2)"/>
				</div></div>
				</div>
				<?php
				$i++;
			} 
			?></div><?php 
		}
	}
}
}//end for
?>