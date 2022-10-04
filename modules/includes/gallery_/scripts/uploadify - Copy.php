<?php  
include_once('../../../../config.php'); 
include_once('../../../common/dbConnection.php'); 
include_once('../../dbUtils.php'); ?>
<?php
session_start();
if (!empty($_FILES)) {
	$gal = $_SESSION['gal'];
	$upfolder =$_REQUEST['upfolder'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetPath = str_replace('//','/',$targetPath);
	
	$targetFile = $targetPath.$_FILES['Filedata']['name'];
	$realName = str_replace(" ","_",$_FILES['Filedata']['name']);
	$photo=$realName;
	while(file_exists($targetPath.$photo)){
		$fileNameParts = explode(".", "$photo");
		$fileExtension = end($fileNameParts); // part behind last dot
		$ext = $fileExtension."";
		$photo=$fileNameParts[0]."1.".$ext;
	}
	$targetFile = $targetPath.$photo;
	
	$fileNameParts = explode(".", $_FILES['Filedata']['name']);
	$fileExtension = end($fileNameParts);
	$thumbFile =  "mcith/mcith_".randomStringUtil(20).'.'.$fileExtension;
	
	
	$availableEx = array("jpg","gif","png","jpeg","pdf","doc","docx","xls","xlsx");
	$ext = strtolower(end(explode('.',$photo)));
	if(in_array($ext,$availableEx)){
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = explode('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
		move_uploaded_file($tempFile,$targetFile);
		//$thumb = resizeToFile($targetFile, 90, 90, $targetPath.$thumbFile);
		$SQL = "INSERT INTO galleries_photos (photo , description , thumb, folder ) VALUES ('$photo','&nbsp;','$thumbFile' ,'$upfolder' )";
		$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
		$id = mysqli_insert_id($GLOBALS["db_link_conn"]);
		
		//$SQL = "update `galleries` set photos = concat(photos,',','".$id."') where id=".$gal;
		/*if(!isset($_REQUEST['gal'])){
			mysqli_result($GLOBALS["db_link_conn"], "INSERT INTO galleries (gallery_name , description , main_photo , photos) VALUES ('' , '' ,'' ,'')";);
			$gid = mysqli_insert_id($GLOBALS["db_link_conn"]);
		}*/
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

//	 } else {
//	 	echo 'Invalid file type.';
//	 }
}
?>