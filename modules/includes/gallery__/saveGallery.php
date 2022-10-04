<?php 
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php");
require_once("dbUtilsGallary.php");
if(checkGallogin()){ 
if(isset($_SESSION['gid'])){
	$gid=$_SESSION['gid'];
	$sql = "SELECT * FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numberOfRows = mysqli_num_rows($result);
	if ($numberOfRows>0) {
		$gallery_name= mysqli_result($GLOBALS["db_link_conn"], $result,0,"gallery_name_en");
		$description= mysqli_result($GLOBALS["db_link_conn"], $result,0,"description_en");
		$main_photo= mysqli_result($GLOBALS["db_link_conn"], $result,0,"main_photo");
		$photos= mysqli_result($GLOBALS["db_link_conn"], $result,0,"photos");
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
<script type="text/javascript" src="gallery.js" ></script>
<script>
$(document).ready(function(){ 	
	loadImages(2);
});
</script>
</head>
<body style="margin:10px; overflow:hidden">
<div id="upload_div" ></div>
<div id="loading">LOADING ...</div>
<div class="head"><h1 class="title">Save Gallery</h1></div>
<br>
<div style="display:inline-block"><div class="steps_inact_inact"> Step1: Add gallery Info. </div><div class="steps_inact_act"> Step2: Add photos to gallery </div><div class="steps_act_end">Step3: Save gallery</div></div>

<div style="margin-top:10px; margin-bottom:10px;">Please select the main photo from below:</div>
<div id="gallery_admin2"></div>

<div style="margin-top:10px;">
<div class="next" onClick="document.location='photosGallery.php'">Back</div>
<?php if(isset($_SESSION['entergid']) && $_SESSION['entergid']==$gid){
	?><div class="next" style="margin-left:10px;" onClick="window.close()">Finsh</div><?php
	}else{?>
<div class="next" style="margin-left:10px;" onClick="opener.document.location.reload(true);window.close()">Finsh</div>
<?php }?>
</div>
</body>
</html>
<?php } }}?>