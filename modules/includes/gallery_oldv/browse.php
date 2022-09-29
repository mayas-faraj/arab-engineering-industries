<?php
session_start();

header("cache-control: no-cache"); 
require_once('../../../config.php'); 
require_once('../../common/dbConnection.php'); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse Images</title>
<style>
.thumb{float:left; width:100px; height:150px; border:1px solid #eee; margin:5px;}
.img{float:none; width:100px; height:100px; vertical-align:middle}
.label{background-color:#eee; height:20px; font-size:11px; line-height:15px; padding-top:5px; text-align:center }
</style>
<script>
function del_conform(id){
	$('#delDiv').html('Loading....');
	$('#delDiv').dialog("open");
	$.post("del.php",{id:id}, function(data){
		$('#delDiv').html(data);
	});
}
function del_file(){
	$.post("del.php",{}, function(data){
		$('#delDiv').html(data);
		if(data!=0){
			$('#delDiv').dialog("close");
			$('#box'+data).hide('normal');
		}
	});
}

function edit_conform(id){
	$('#editDiv').html('Loading....');
	$('#editDiv').dialog("open");
	$.post("edit.php",{id:id}, function(data){
		$('#editDiv').html(data);
	});
}
function edit_file(){
	$('#editDiv').html('Loading....');
	var des=$('#des2').val();
	$.post("edit.php",{des:des}, function(data){
		$('#editDiv').html(data);
		if(data!=0){
			$('#editDiv').dialog("close");
			$('#box'+data).hide('normal');
		}
	});
}

$(document).ready(function(){
	$('#delDiv').dialog({
		autoOpen: false,
		width:420,
		title:'<?=Delete?>',
		modal: true, 
		buttons: {
			"<?=Delete?>": function() {del_file()} ,
			"<?=Cancel?>": function() {$(this).dialog("close");} 
		}
	});
	
	$('#editDiv').dialog({
	autoOpen: false,
	width:420,
	title:'<?=Edit?>',
	modal: true, 
	buttons: {
		"<?=Save?>": function() {edit_file()} ,
		"<?=Cancel?>": function() {$(this).dialog("close");} 
	}
});
	
});
</script>
</head>
<body >
<input name="des2" type="hidden" id="des2" value="d" size="100">
<?php
// Images Extentions
$img_arr = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
//$dh  = opendir("../../uploads");
//while (false !== ($filename = readdir($dh))) {
//	$files[] = $filename;
//}
//rsort($files);
//for($i = 0;$i < count($files)-2;$i++){
//	$f = explode(".",$files[$i],-1);
//	$ext = $f[1];
$gid=$_REQUEST['gid'];
if($_REQUEST['all'] == '1'){
	if($_SESSION['USER']==2){
		$sql = "SELECT * FROM galleries_photos  $sort  order by id DESC";
	}else{
		$sql = "SELECT * FROM galleries_photos WHERE creator_id='". $_SESSION['USER']."' $sort  order by id DESC";
	}
	$photos = $_REQUEST['ph'];
	$resPhotos= explode(',',$photos);
} else if($gid){
	$sql = "SELECT * FROM galleries_galleries  where id=$gid limit 0,1";
	$result = mysql_query($sql);
	$numberOfRows = mysql_numrows($result);
	if ($numberOfRows>0) {
		$gallery_name= mysql_result($result,0,"gallery_name");
		$description= mysql_result($result,0,"description");
		$mph= mysql_result($result,0,"main_photo");
		$photos= mysql_result($result,0,"photos");
		if( $photos == '')$phStmt = " WHERE id=0";
		else if($_REQUEST['all'] != '1')	$phStmt = " WHERE id in ($photos)";
		$sql = "SELECT * FROM galleries_photos $phStmt $sort  order by id DESC";
		$resPhotos= explode(',',$photos);
	}else{
		$sql = "SELECT * FROM galleries_photos $sort  order by id DESC";
		$resPhotos=array();
	}
}else{
	$sql = "SELECT * FROM galleries_photos where id=0 $sort  order by id DESC";
	$resPhotos=array();
}

$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i=0;

//echo "(".$mph.")";

while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$photo= MYSQL_RESULT($result,$i,"photo");
	$description= MYSQL_RESULT($result,$i,"description");

	//$gallery_folder = lookupField('galleries_galleries','id','folder',$gid);
	//if($gallery_folder){$folder = $gallery_folder.'/';}
	$thumb= MYSQL_RESULT($result,$i,"thumb");?>
		<div class="thumb" align="center" id="box<?=$id?>">
		<div class="img" align="center">
        <img src="<?=_PREF?>uploads/<?=$thumb?>" alt="<?=stripslashes($description)?>" /></div>
        <div class="label" align="right">
          <input type="checkbox" <? if(in_array($id,$resPhotos)){echo " checked ";}?> name="sel_pho[]" value="<?=$id?>" />
        <img src="../../../images/icons/Delete.png" width="20" hspace="3"style="cursor:pointer" onClick="del_conform(<?=$id?>)"/>
        <img src="../../../images/icons/Edit.png"   width="20" hspace="3" style="cursor:pointer" onClick="edit_conform(<?=$id?>)"/>
        </div>
        <div class="label" align="right">
        <input type="radio" name="main_pho" <?	if($id==$mph){echo " checked ";}?> value="<?=$id?>" /> Main photo</div>
		<!--<div><a href=\"editPhoto.php?id=$id\" class=\"popup\">Edit</a></div>-->
        </div>
        <?
		/*echo "<div class=\"thumb\" align=\"center\">
		<div class=\"img\" align=\"center\"><img src=\"../../uploads/".$thumb."\" alt=\"".stripslashes($description)."\" /><br>".$photo."</div>
		<div class=\"label\" align=\"left\"><input type=\"checkbox\" ";
		if(in_array($id,$resPhotos)){echo " checked ";}
		echo "name=\"sel_pho[]\" value=\"".$id."\" /> Select photo</div>
		<div class=\"label\" align=\"left\"><input type=\"radio\" name=\"main_pho\" ";
		if($id==$mph){echo " checked ";}
		echo "value=\"".$id."\" /> Main photo</div>
		<!--<div><a href=\"editPhoto.php?id=$id\" class=\"popup\">Edit</a></div>-->
		</div>";*/
	$i++;
}//end for
?>
<div id="delDiv">Loading....</div>
<div id="editDiv">Loading....</div>
</body>
</html>