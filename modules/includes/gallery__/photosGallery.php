<?php 
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php");
require_once("dbUtilsGallary.php");
if(checkGallogin()){
$uploads_folder = str_replace('//','/',lookupField('users','user_id','uploads_folder',$_SESSION['USER']).'/');
if(isset($_SESSION['gid'])){
	$gid=$_SESSION['gid'];
	$sql = "SELECT gallery_name_en,main_photo,photos FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysql_query($sql);
	$numberOfRows = mysql_numrows($result);
	if ($numberOfRows>0) {
		$gallery_name= mysql_result($result,0,"gallery_name_en");
		$main_photo= mysql_result($result,0,"main_photo");
		$photos= mysql_result($result,0,"photos");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css"  href="../css/style.css" />
<link rel="stylesheet" type="text/css"  href="css/style.css" />
<link type="text/css" rel="stylesheet" href="../jquery/smoothness/jquery-ui.css"/>

<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="../jquery/jquery.form.js" ></script>

<script>var rootUploadsFolder='test/';</script>
<script type="text/javascript" src="gallery.js" ></script>
<script>
$(document).ready(function(){	
	loadFolderList(rootUploadsFolder,rootUploadsFolder,1);
});
</script>

</head>
<body style="margin:10px; overflow:hidden">
<div id="upload_div" ></div>
<div id="loading">LOADING ...</div>
<div class="head"><h1 class="title"><?=$gallery_name?> &raquo; Add photos</h1></div>

<div style="margin:5px; width:700px; height:25px;">
<div class="steps_inact_act"> Step1: Add gallery Info. </div>
<div class="steps_act_inact"> Step2: Add photos to gallery </div>
<div class="steps_inact_end">Step3: Save gallery</div>
</div>


<?php
$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;
$action = $_REQUEST['sub'];
if($action){
	$main_pho = ($_REQUEST['main_pho']);
	$photosArr = $_REQUEST['sel_pho']; 
	if($photosArr)	$photos = implode(",",$photosArr);
	else $photos = '';
	//$SQL = " UPDATE galleries_galleries SET main_photo = '$main_pho' , photos = '$photos' WHERE id = '$gid'"; 
	//$result = mysql_query($SQL);
	if($result){
		echo '<script>window.location="saveGallery.php?gid='.$gid.'&n='.$_REQUEST['n'].'"</script>';
	}
}
?>
	<div class="gallery_nav">
     <div id="folder_path_view">root/</div>
     <div id="new_folder">
     	<div class="newFolder2"><input id="addFolder"  type="text"></div>
     	<div class="save_folder" onClick="saveFolder()">Save</div>
     </div>
    <a href="javascript:uploadImage();" class="upload_photos navbutt"> upload photos </a>
    <div onClick="newFolder()" class="newFolder navbutt">New Folder</div>
    <div onClick="sync()" class="sync navbutt">synchronise</div>
    </div>	
    <div class="foldersList"><div id="foldersList"><?=loadFolders();?></div></div>    
    <div id="gallery_admin" ></div>
    <div style="clear:both">
    <div class="next" onClick="document.location='editGallery.php?gid=<?=$gid?>'">Back</div>
    <div class="next"  style="margin-left:10px;" onClick="document.location='saveGallery.php'">Next</div>
    </div><?
	} 
}?>
</body>
</html>
<? }?>