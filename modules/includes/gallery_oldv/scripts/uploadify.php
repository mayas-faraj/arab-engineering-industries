<?php  
include_once('../../../../config.php'); 
include_once('../../../common/dbConnection.php'); 
include_once('../../dbUtils.php'); ?>
<?php
session_start();
if (!empty($_FILES)) {
	$gal = $_SESSION['gal'];
	$no_space_photo = str_replace(' ', '_',$_FILES['Filedata']['name']);
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$gallery_folder = lookupField('galleries_galleries','id','folder',$_REQUEST['gal']).'/';
	$creator_id = lookupField('galleries_galleries','id','creator_id',$_REQUEST['gal']).'/';
	$uploads_folder = lookupField('users','user_id','uploads_folder',$creator_id).'/';

	$targetPath = $_REQUEST['folder'].'/'.$uploads_folder.$gallery_folder;
	$uploads_target = $_REQUEST['folder'] ;

	$targetPath = str_replace('//','/',$targetPath);
	$targetPath = str_replace('//','/',$targetPath);
	$uploads_target = str_replace('//','/',$uploads_target);

	$targetFile = $targetPath.$no_space_photo;
	$targetFile = $targetPath.$no_space_photo;
	$thumbFile =  "mcith/mcith_".$no_space_photo;
	$photo  = $no_space_photo;
	$availableEx = array("jpg","gif","png","jpeg","pdf","doc","docx","xls","xlsx");
	$ext = strtolower(end(explode('.',$photo)));
	if(in_array($ext,$availableEx)){
	

		
		move_uploaded_file($tempFile,$targetFile);
		$thumb = resizeToFile($targetFile, 90, 90, $uploads_target.$thumbFile);
	
		$creator_id = lookupField('galleries_galleries','id','creator_id',$_REQUEST['gal']);
		
		$SQL = "INSERT INTO galleries_photos (photo , description , thumb, creator_id ) VALUES ('$photo','&nbsp;','$thumbFile', '$creator_id')";
		$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
		$id = mysqli_insert_id($GLOBALS["db_link_conn"]);
		
		
		$sql = "SELECT * FROM galleries_galleries where id=".$_REQUEST['gal']." limit 0,1";
		$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
		$numberOfRows = mysqli_num_rows($result);
		if ($numberOfRows>0) {
			$gallery_name= mysqli_result($GLOBALS["db_link_conn"], $result,0,"gallery_name");
			$description= mysqli_result($GLOBALS["db_link_conn"], $result,0,"description");
			$mph= mysqli_result($GLOBALS["db_link_conn"], $result,0,"main_photo");
			$photos= mysqli_result($GLOBALS["db_link_conn"], $result,0,"photos");
			if($photos != '')
				$SQL = "update `galleries_galleries` set photos = concat(photos,',','".$id."') where id=".$_REQUEST['gal'];
			else
				$SQL = "update `galleries_galleries` set photos = '".$id."' where id=".$_REQUEST['gal'];
			$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
			if(!$mph)	mysqli_query($GLOBALS["db_link_conn"], "update `galleries_galleries` set main_photo = '".$id."' where id=".$_REQUEST['gal']);
			echo "1";
		}
	}


}
?>