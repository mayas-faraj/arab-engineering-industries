<?php 
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css"  href="../css/style.css" />
<link type="text/css" rel="stylesheet" href="../jquery/smoothness/jquery-ui.css"/>	
<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="../jquery/jquery.form.js" ></script>
<script>
$(document).ready(function(){ 
$(function (){
	$('a.popup').click(function() {
		var url = this.href;
		var title = ($(this).attr('title')) ? $(this).attr('title') : 'External Site';
		var width = ($(this).attr('width')) ? $(this).attr('width') : 600;
		var height = ($(this).attr('height')) ? $(this).attr('height') : 450;
		var dialog = $('<div style="display:hidden;overflow:auto"></div>').appendTo('body');
		// load remote content
		dialog.load(
			url, 
			{},
			function (responseText, textStatus, XMLHttpRequest) {
				dialog.dialog({
					title: title, 
					autoOpen: true, 
					width: width,
					height: height, 
					modal: true, 
					overlay: { 
						opacity: 0.5, 
						background: "black" 
					},
					buttons: {
						"Close": function() { 
							$(this).dialog("close"); 
							$("#gallery_admin").load("browse.php");
						}
					}
				});
			}
		);
		//prevent the browser to follow the link
		return false;
	});
});
	$("#gallery_admin").load("browse.php");
});

function showGallery(all){
	$("#gallery_admin").load("browse.php?all="+all+"&$ph=<?php echo $photos; ?>&mph=<?php echo $main_photo; ?>");
}
</script>
</head>
<body style="margin:10px; overflow:hidden">
<div class="head"><h1 class="title">New Gallery</h1></div>
<?php
$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;

$action = $_REQUEST['sub'];
if($action){
	$gallery_name = ($_REQUEST['gallery_name']);
	$description = ($_REQUEST['description']);
	$main_pho = ($_REQUEST['main_pho']);
	$photosArr = $_REQUEST['sel_pho']; 
	$folder = $_REQUEST['folder']; 
	$photos = "";//implode(",",$photosArr);

	$SQL = "INSERT INTO galleries_galleries (gallery_name , description , main_photo , photos, folder) VALUES ('$gallery_name' , '$description' ,'$main_pho' ,'$photos', '$folder')";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result){

		$id = mysqli_insert_id($GLOBALS["db_link_conn"]);

		if($folder&&$id){
			$folder_path = '../../../uploads/'.$folder;
			$folder_images = getFolderImages($folder_path);
			$photos_ids = '';
			for($i=0;$i<count($folder_images);$i++){
				$photo = $folder_images[$i];
				$gallery_folder = $folder.'/';

				$targetPath = $_SERVER['DOCUMENT_ROOT'].'uploads/'.$gallery_folder;
				$uploads_target = $_SERVER['DOCUMENT_ROOT'] .'uploads/';
				$targetPath = str_replace('//','/',$targetPath);
				$uploads_target = str_replace('//','/',$uploads_target);

				$targetFile = $targetPath.$photo;
				$thumbFile =  "mcith/mcith_".$photo;
				
				$thumb = resizeToFile($targetFile, 90, 90, $uploads_target.$thumbFile);
				$SQL = "INSERT INTO galleries_photos (photo , description , thumb ) VALUES ('$photo','&nbsp;','$thumbFile' )";
				$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
				$photo_id = mysqli_insert_id($GLOBALS["db_link_conn"]);
				if($photos_ids){
					$photos_ids .= ','.$photo_id;
				}else{
					$photos_ids .= $photo_id;
				}
			}
			$SQL = "INSERT update galleries_galleries set photos = '$photos_ids' ";
			$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
		}
		
		echo "<script>opener.document.getElementById('newGal').value='$id';
		opener.document.getElementById('newGal').innerHTML='$gallery_name';
		window.location=\""._PREF."modules/includes/gallery/editGallery.php?gid=$id&n=1\";
		</script>";
		
	}
}// Insert record
?>
<form method='post' name='main' action='<?php echo  $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' onsubmit='return formValidator()'>
	<table>
		<tr>
			<td colspan='2'>Please write the new Gallery:</td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="gallery_name"  /></td>
		</tr>
		<tr>
			<td>folder path: uploads/</td>
			<td><input type="text" name="folder"  /></td>
		</tr>
		<tr>
			<td></td>
			<td> 	<input type="submit" value="Next" name="sub" style='width:123px'/></td>
		</tr>
	</table>

  
</form>
<script>
function formValidator(){
	if(this.main.gallery_name.value.length>0 ) return true;
	else{
		alert("Please enter the gallery name");
		 return false;
	}
}
</script>
<br>
</body>
</html>