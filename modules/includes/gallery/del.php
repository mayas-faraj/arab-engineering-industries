<?php 
session_start();
include_once("../../../config.php");
include_once("../../common/dbConnection.php");
require_once("dbUtilsGallary.php");
if(checkGallogin()){ 
$opr=$_REQUEST['opr'];
$Mid=$_REQUEST['id'];
$t=$_REQUEST['t'];
$sql3 = "SELECT * FROM galleries_photos where id='$Mid' limit 1 ";
$res3= mysqli_query($GLOBALS["db_link_conn"], $sql3);
$rows3 = mysqli_num_rows($res3);
if($rows3>0){
$selThumb=mysqli_result($GLOBALS["db_link_conn"], $res3,0,'thumb');
?><div style="float:right; margin:10px; margin-right:50px;"><img src="../../../uploads/<?php echo $selThumb; ?>"/></div><?php
?><div style="margin:10px; float:left"><?php
if(isset($_REQUEST['id']) && isset($_REQUEST['opr'])) {	
	if($opr=='info'){	
		$sql = "SELECT * FROM galleries_galleries ";
		$res= mysqli_query($GLOBALS["db_link_conn"], $sql);
		$rows = mysqli_num_rows($res);
		if ($rows>0) {
			$i=0;
			$counter=0;
			$albs='';
			while ($i<$rows){
				$id= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"id");
				$gallery_name= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"gallery_name_en");
				$description= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"description_en");
				$main_photo= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"main_photo");
				$photos= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"photos");		
				$phos=explode(',',$photos);
				if(in_array($Mid,$phos)){
					$counter++;
					$albs.='<div>'.$counter.' - '.$gallery_name.'</div>';				
				}
				$i++;
			}
			if($counter>0){
				echo '<b>Albums that contain this image : ('.$counter.')</b> '.$albs;
				
			}else{
				echo 'Was not added to any album this image';
			}
		}
		?><div><div class="gall_opr_butt" onclick="del_photo(<?php echo $Mid; ?>,'del','<?php echo $t; ?>')">Delete</div>
        <div class="gall_opr_butt" onClick="$('#upload_div').hide('fast')">Cancel</div></div><?php
	}

	if($opr=='del'){
		/*----------------Delete Photo from Galleries----------- */
		$sql = "SELECT * FROM galleries_galleries ";
		$res= mysqli_query($GLOBALS["db_link_conn"], $sql);
		$rows = mysqli_num_rows($res);
		if ($rows>0) {
			$i=0;
			
			$albs='';
			while ($i<$rows){
				$id= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"id");
				$gallery_name= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"gallery_name");
				$description= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"description");
				$main_photo= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"main_photo");
				$photos= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"photos");
				$phos=explode(',',$photos);
				$e=0;
				$new_photos='';
				$counter=0;
				$Mpoto=0;
				for($f=0;$f<count($phos);$f++){
					if($phos[$f]==$Mid){
						$e=1;
						$counter++;	
						if($phos[$f]==$main_photo){
							$Mpoto=$phos[$f];
							
						}
					}else{
						$new_photos.=$phos[$f].',';
					}
				}
				$new_photos=substr($new_photos,0,strlen($new_photos)-1);
				$Q='';
				if($counter>0){
					if($Mpoto!=0){
						$mp2=explode(',',$new_photos);
						if(count($mp2)>0){
							$Q= " , `main_photo` = '".$mp2[0]."' ";
						}
					}
					$sql2 = "UPDATE `galleries_galleries` SET `photos` = '$new_photos' $Q  WHERE `id` =$id LIMIT 1 ;";
					$res2= mysqli_query($GLOBALS["db_link_conn"], $sql2);
				}
				
				$i++;
			}

			
				$photo=mysqli_result($GLOBALS["db_link_conn"], $res3,0,'photo');
				$folder=mysqli_result($GLOBALS["db_link_conn"], $res3,0,'folder');
				$thumb=mysqli_result($GLOBALS["db_link_conn"], $res3,0,'thumb');
				
				$sql4 = "DELETE FROM `galleries_photos` WHERE `id` ='$Mid' LIMIT 1 ;";
				$res4= mysqli_query($GLOBALS["db_link_conn"], $sql4);
				@unlink('../../../uploads/'.$folder.$photo);
				@unlink('../../../uploads/'.$thumb);
	
		}
	}
}
?>
</div> <?php }}?>