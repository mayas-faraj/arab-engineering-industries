<?php 
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("dbUtilsGallary.php");
if(checkGallogin()){
if(isset($_REQUEST['gid'])){
	$gid=$_REQUEST['gid'];
	$_SESSION['gid']=$gid;
	$sql = "SELECT * FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numberOfRows = mysqli_num_rows($result);
	if ($numberOfRows>0) {
		$gid= mysqli_result($GLOBALS["db_link_conn"], $result,0,"id");
		$gallery_name_en= stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result,0,"gallery_name_en"));
		$description_en= stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result,0,"description_en"));
		$gallery_name_ar= stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result,0,"gallery_name_ar"));
		$description_ar= stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result,0,"description_ar"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css"  href="../css/style.css" />
<link rel="stylesheet" type="text/css"  href="css/style.css" />

</head>
<body style="margin:10px; overflow:hidden"  >
<div class="head"><h1 class="title">Edit Gallery</h1></div>
<br>
<div style="display:inline-block"><div class="steps_act_inact"> Step1: Add gallery Info. </div><div class="steps_inact_inact"> Step2: Add photos to gallery </div><div class="steps_inact_end">Step3: Save gallery</div></div>
<?php
$action = $_REQUEST['sub'];
if($action){
	$gid = ($_REQUEST['gid']);
	$gallery_name_en = addslashes($_REQUEST['gallery_name_en']);
	$description_en = addslashes($_REQUEST['description_en']);
	$gallery_name_ar = addslashes($_REQUEST['gallery_name_ar']);
	$description_ar = addslashes($_REQUEST['description_ar']);

	$SQL = " UPDATE galleries_galleries SET	
	gallery_name_en = '$gallery_name_en' , 
	gallery_name_ar = '$gallery_name_ar' , 
	description_en = '$description_en' , 
	description_ar = '$description_ar' 
	WHERE id = '$gid'";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result){
		echo '<script>window.location="'._PREF.'modules/includes/gallery/photosGallery.php";</script>';
	}
}// Insert record
?>
<form method='post' name='main' action='<?php echo  $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' onsubmit='return formValidator()'>
    <div style="height:340px; margin-top:20px">    
        <div style="float:left">
        <div>Gallery Name (EN): </div>
            <div><input type="text" name="gallery_name_en" class="inputText" value="<?php echo $gallery_name_en; ?>"/></div>
            <div style="margin-top:10px">Gallery Description (EN): </div>
            <div><textarea name="description_en" class="inputTextarea"><?php echo $description_en; ?></textarea></div>
        </div>
        
        <div style="float:left; margin-left:25px;">
            <div>Gallery Name (AR):</div> 
            <div><input type="text" name="gallery_name_ar" class="inputText"  value="<?php echo $gallery_name_ar; ?>"/></div>
            <div style="margin-top:10px">Gallery Description (AR):</div>
            <div><textarea name="description_ar" class="inputTextarea"><?php echo $description_ar; ?></textarea></div>
        </div>    
    </div>
	<input type="submit" value="Next" name="sub" class="next" />
    <input type="hidden" value="<?php echo $gid; ?>" name="gid" />
</form>

<?php
	}
} 
?>
<script>
function formValidator(){
	if(this.main.gallery_name_en.value.length>0 ) return true;
	else{
		alert("Please enter the gallery name");
		 return false;
	}
}
</script>

</body>
</html>
<?php }?>