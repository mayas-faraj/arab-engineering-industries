<?session_start(); 
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("../../includes/dbUtils.php");
if(isset($_REQUEST['gid'])){
	$gid=$_REQUEST['gid'];
	$_SESSION['gal'] = $gid;
	$sql = "SELECT * FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysql_query($sql);
	$numberOfRows = mysql_numrows($result);
	if ($numberOfRows>0) {
		$gallery_name= mysql_result($result,0,"gallery_name");
		$gallery_name_ar= mysql_result($result,0,"gallery_name_ar");
		$description= mysql_result($result,0,"description");
		$main_photo= mysql_result($result,0,"main_photo");
		$photos= mysql_result($result,0,"photos");
		$folder= mysql_result($result,0,"folder");
		$creator_id= mysql_result($result,0,"creator_id");
?>
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
							$("#gallery_admin").load("browse.php?gid=<?php echo $gid; ?>&ph=<?php echo $photos; ?>&mph=<?php echo $main_photo; ?>"); 
						}
					}
				});
			}
		);
		//prevent the browser to follow the link
		return false;
	});
});
	$("#gallery_admin").load("browse.php?gid=<?php echo $gid; ?>&$ph=<?php echo $photos; ?>&mph=<?php echo $main_photo; ?>");
});
function showGallery(all){
	$("#gallery_admin").load("browse.php?all="+all+"&gid=<?php echo $gid; ?>&ph=<?php echo $photos; ?>&mph=<?php echo $main_photo; ?>");
}
</script>
</head>
<body style="margin:10px; overflow:hidden">
<div class="head"><h1 class="title">Edit Gallery</h1></div>
<?php
$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;
$action = $_REQUEST['sub'];
if($action){
	$gallery_name = ($_REQUEST['gallery_name']);
	$gallery_name_ar = ($_REQUEST['gallery_name_ar']);
	if($_SESSION['USER'] == 2){
		$creator_id = ($_REQUEST['creator_id']);
	}else{
		$creator_id = $_SESSION['USER'];
	}
	$description = ($_REQUEST['description']);
	$main_pho = ($_REQUEST['main_pho']);
	$photosArr = $_REQUEST['sel_pho']; 
	$folder = $_REQUEST['folder']; 
	if($photosArr)	$photos = implode(",",$photosArr);
	else $photos = '';
	$SQL = " UPDATE galleries_galleries SET gallery_name = '$gallery_name' , gallery_name_ar = '$gallery_name_ar' ,description = '$description' , 
	main_photo = '$main_pho' , photos = '$photos', folder='$folder' , creator_id='$creator_id' WHERE id = '$gid'"; 
	$result = mysql_query($SQL);
	if($result){
		if($_REQUEST['n']==1)
			echo '<script>window.close();</script>';
		else
			echo '<script>opener.document.location.reload(true);window.close();</script>';
	}
}
?>
<form method='post' name='main' action='<?php echo  $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' onsubmit='return formValidator()'>
   <!-- 1- Please write the new Gallery name: (EN)<input name="gallery_name" type="text" value="<?php echo $gallery_name; ?>"  /> (AR)<input name="gallery_name_ar" type="text" value="<?php echo $gallery_name_ar; ?>"  /> <br />-->
	<table>
		<tr>
			<td colspan='2'>1- Please write the new Gallery:</td>
		</tr>
		<tr>
			<td>Name: (EN)</td>
			<td><input type="text" name="gallery_name" value='<?php echo $gallery_name; ?>' /></td>
		</tr>
		<tr>
			<td>Name: (AR)</td>
			<td><input type="text" name="gallery_name_ar" value='<?php echo $gallery_name_ar; ?>' /></td>
		</tr>
		<tr>
			<td>folder path: uploads/</td>
			<td><input type="text" name="folder" value='<?php echo $folder; ?>' /></td>
		</tr>
		
	<?if($_SESSION['USER'] == 2){?>
		<tr>
			<td>Creator:</td>
			<td><?php echo createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");; ?></td>
		</tr>
	<?}?>
		
	</table>
	
    2- Select from the following images to add to this gallery or upload another photos by clicking
	
    <a href="index.php?creator_id=<?php echo $_SESSION['USER']; ?>&gal=<?php echo $gid; ?>" class="popup"> here </a>
	<br/>  <a href="#" onclick="showGallery(0)"> show Gallery</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="showGallery(1)"> show all</a>
    <div id="gallery_admin" style="width:100%; height:400px; overflow:auto"></div>
    3- click the save buttom <input type="submit" value="Save" name="sub" />
    <input type="hidden" value="<?php echo $gid; ?>" name="gid" />
    <input type="hidden" value="<?php echo $gid; ?>" name="gid" />
	<input type="hidden" value="<?php echo $_REQUEST['n']; ?>" name="n" />
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
	<br><?
	} 
}?>
</body>
</html>