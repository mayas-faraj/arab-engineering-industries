<?php
session_start();
header("cache-control: no-cache"); 
require_once('../../../config.php'); 
require_once('../../common/dbConnection.php'); 
include_once("../../includes/dbUtils.php");
if(checkGallogin()){
?>
<script>
function del_conform(id){
	dleID=id;
	$('#delDiv').html('Loading....');
	$('#delDiv').dialog("open");
	$.post("del.php",{id:id,opr:'info'}, function(data){
		$('#delDiv').html(data);
	});
}
function del_file(){
	$.post("del.php",{id:dleID,opr:'del'}, function(data){
		$('#delDiv').dialog("close");
		$('#box'+dleID).hide('slow');
		dleID=0;
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
var dleID=0;
<?php if(isset($_REQUEST['f'])){ ?>
$(document).ready(function(){
	$('#delDiv').dialog({
		autoOpen: false,
		width:420,
		title:'<?php echo Delete; ?>',
		modal: true, 
		buttons: {
			"<?php echo Delete; ?>": function() {del_file()} ,
			"<?php echo Cancel; ?>": function() {$(this).dialog("close");} 
		}
	});
	
	$('#editDiv').dialog({
	autoOpen: false,
	width:420,
	title:'<?php echo Edit; ?>',
	modal: true, 
	buttons: {
		"<?php echo Save; ?>": function() {edit_file()} ,
		"<?php echo Cancel; ?>": function() {$(this).dialog("close");} 
	}
});
	
});
<?php }?>
</script>
<input name="des2" type="hidden" id="des2" value="d" size="100">
<?php
// Images Extentions
$img_arr = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
$gid=$_SESSION['gid'];
$ph=lookupField('galleries_galleries','id','photos',$gid);
$photos=explode(',',$ph);
$_REQUEST['folder'];
$folder = ltrim($_REQUEST['folder'],"/");
$sql = "SELECT * FROM galleries_photos where folder='$folder' $sort  order by id DESC";	
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
$i=0;
while ($i<$numberOfRows){
	$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
	$photo= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo");
	$folder= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"folder");
	$description= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"description");
	$thumb= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"thumb");
	$file_path='../../../uploads/'.$folder.$photo;
	if(file_exists($file_path)){
		if($thumb!='video'){
			$thumbN= resizeToFile($file_path, 90, 90,'../../../uploads/'.$thumb); 
			//$thumbN=_PREF.'uploads/'.$thumb;		
		}else{
			$thumbN=_PREFICO.'video.png';
		}
		//	echo $thumb;
		?>	
	
        <div class="thumb" align="center" id="box<?php echo $id; ?>">
        <div class="img_des" id="des<?php echo $id; ?>"  
        onMouseOut="viewDes(<?php echo $id; ?>,0)"><div><?php echo $photo.'<br>'.stripslashes($description); ?></div></div>
        <div class="thumb_img" align="center" style="background-image:url(<?php echo $thumbN; ?>)" 
        onMouseOver="viewDes(<?php echo $id; ?>,1)" ></div>
        <?php 
		$bgcol='ccc';
		$checked='';
		if(in_array($id,$photos)){
			$checked= " checked ";
			$bgcol='abe656';
		}?>
        <div class="thumb_tools" style="background-color:#<?php echo $bgcol; ?>" id="tools_<?php echo $id; ?>" >
        <div>
        <input type="checkbox" id="ch_<?php echo $id; ?>"  value="<?php echo $id; ?>" <?php echo $checked; ?> onClick="addToGallery(<?php echo $id; ?>,1)" />
        </div><div>	
        <img src="../css/images/icons/Delete.png" width="20" hspace="3" style="cursor:pointer" 
        onClick="del_photo(<?php echo $id; ?>,'info',1)"/>
        </div><div>
        <img src="../css/images/icons/Edit.png" width="20" hspace="3" style="cursor:pointer" 
        onClick="edit_photo(<?php echo $id; ?>,'<?php echo $description; ?>','<?php echo $thumb; ?>',1)"/>
        </div></div>
        </div><?php		
	}
	$i++;
}//end for
}?>
