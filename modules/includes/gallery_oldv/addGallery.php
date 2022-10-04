<?php session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("../../includes/dbUtils.php"); ?>
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
	$("#gallery_admin").load("browse.php?all="+all+"&ph=<?php echo $photos; ?>&mph=<?php echo $main_photo; ?>");
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
$_SESSION['aaa']= 'aaaadf';
$action = $_REQUEST['sub'];
if($action){
	$gallery_name = ($_REQUEST['gallery_name']);
	$gallery_name_ar = ($_REQUEST['gallery_name_ar']);
	$description = ($_REQUEST['description']);
	
	$main_pho = ($_REQUEST['main_pho']);
	$photosArr = $_REQUEST['sel_pho']; 
	$folder = $_REQUEST['folder']; 
	if($_SESSION['USER'] == 2){
		$creator_id = ($_REQUEST['creator_id']);
	}else{
		$creator_id = $_SESSION['USER'];
	}
	$photos = "";//implode(",",$photosArr);

	$SQL = "INSERT INTO galleries_galleries (gallery_name , gallery_name_ar, description , main_photo , photos,folder, creator_id) VALUES ('$gallery_name' , '$gallery_name_ar','$description' ,'$main_pho' ,'$photos','$folder','$creator_id')";
	$result = mysql_query($SQL);
	if($result){
		
		
		$id = mysql_insert_id();

		if($folder&&$id){
			$folder_path = '../../../uploads/'.$folder;
			$folder_images = getFolderImages($folder_path);
			$photos_ids = '';
			for($i=0;$i<count($folder_images);$i++){
				$photo = $folder_images[$i];
				$gallery_folder = $folder.'/';

				$targetPath = '../../../uploads/'.$gallery_folder;
				$uploads_target = $_SERVER['DOCUMENT_ROOT'] .'uploads/';
				$targetPath = str_replace('//','/',$targetPath);
				$uploads_target = str_replace('//','/',$uploads_target);

				$targetFile = $targetPath.$photo;
				$thumbFile =  "mcith/mcith_".$photo;
				
				$thumb = resizeToFile($targetFile, 90, 90, '../../../uploads/'.$thumbFile);
				$SQL = "INSERT INTO galleries_photos (photo , description , thumb, creator_id ) VALUES ('$photo','&nbsp;','$thumbFile','$creator_id' )";
				$result = mysql_query($SQL);
				$photo_id = mysql_insert_id();
				if($photos_ids){
					$main_photo = $photo_id;
					$photos_ids .= ','.$photo_id;
				}else{
					$photos_ids .= $photo_id;
				}
			}
			$SQL = "update galleries_galleries set photos = '$photos_ids' , main_photo = '$main_photo' where id='$id' ";
			$result = mysql_query($SQL);
		}
		
		
		echo '<script>opener.document.location.reload(true);window.location="'._PREF.'modules/includes/gallery/editGallery.php?gid='.$id.'","","width=800,height=500";</script>';
	}
}// Insert record

?>
<form method='post' name='main' action='<?php echo  $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' onsubmit='return formValidator()'>
	 <br /> <br /> <br /> <br />
	 Please write the new Gallery:  <br /> <br />
	 <table>
		<tr><td>Name: (EN)</td><td><input type="text" name="gallery_name"  /> </td></tr>
		<tr><td>Name: (AR)</td><td><input type="text" name="gallery_name_ar"  /></td></tr>
		<tr><td> Folder path: uploads/</td><td><input type="text" name="folder"  /></td></tr>
		<?if($_SESSION['USER'] == 2){?>
			<tr><td> Creator</td><td><?php echo createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");; ?></td></tr>
		<?}?>
		
	 </table>

	  <br /> <br />
   	<input type="submit" value="Next" name="sub" />
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