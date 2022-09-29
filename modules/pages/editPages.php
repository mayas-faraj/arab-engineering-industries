<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Pages: Update", "Pages", "", 0);

?>
<div id="output1"></div>
<?
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
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM pages WHERE id = '$id' ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows>0) {
$i=0;
$id= MYSQL_RESULT($result,$i,"id");
$title= MYSQL_RESULT($result,$i,"title");
$details= MYSQL_RESULT($result,$i,"details");
$brief = MYSQL_RESULT($result,$i,"brief");
$lang= MYSQL_RESULT($result,$i,"lang");
}?>
<form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?=$id?>" />
<table>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Title?>:</span></td>
<td width="5" class="required">*</td>
<td><input type="Text" name="title" size="50" value="<?=stripslashes($title)?>" class="required" /></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Brief?>:</span></td>
<td width="5" class="required"></td>
<td><textarea name="brief" cols="50" rows="4" class="simpleEditor" ><?=stripslashes($brief)?></textarea></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Details?>:</span></td>
<td width="5" class="required"></td>
<td><textarea name="details" cols="50" rows="4" class="mceEditor" ><?=stripslashes($details)?></textarea></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Lang?>:</span></td><td width="5" class="required">*</td>
<td><?=createComboBox("languages" , "lang", "lang_name" , $lang , "lang", "required");?></td>
</tr>
<?
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<input name="sub2" type="button" id="sub2" value="<?=ALL_Pages?>" onClick=" document.location='listPages.php'">
</form><?
}
include_once("../common/footer-admin.php"); ?>
