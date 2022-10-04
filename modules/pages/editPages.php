<?php  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Pages: Update", "Pages", "", 0);

?>
<div id="output1"></div>
<?php
$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$title = addslashes($_REQUEST['title']);
$details = addslashes($_REQUEST['details']);

$values = "title = '$title' , details = '$details' ";
$lang = addslashes($_REQUEST['lang']);
$values .= ", lang = '$lang'";
$brief = addslashes($_REQUEST['brief']);
$values .= " , brief = '$brief'";
$SQL = "UPDATE pages SET  $values WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM pages WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
if ($numberOfRows>0) {
$i=0;
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$title= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"title");
$details= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"details");
$brief = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"brief");
$lang= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"lang");
}?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<table>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Title; ?>:</span></td>
<td width="5" class="required">*</td>
<td><input type="Text" name="title" size="50" value="<?php echo stripslashes($title); ?>" class="required" /></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?>:</span></td>
<td width="5" class="required"></td>
<td><textarea name="brief" cols="50" rows="4" class="simpleEditor" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Details; ?>:</span></td>
<td width="5" class="required"></td>
<td><textarea name="details" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($details); ?></textarea></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Lang; ?>:</span></td><td width="5" class="required">*</td>
<td><?php echo createComboBox("languages" , "lang", "lang_name" , $lang , "lang", "required");; ?></td>
</tr>
<?php
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<input name="sub2" type="button" id="sub2" value="<?php echo ALL_Pages; ?>" onClick=" document.location='listPages.php'">
</form><?php
}
include_once("../common/footer-admin.php"); ?>
