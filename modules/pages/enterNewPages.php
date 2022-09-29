<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Pages: Insert New Item", "Pages", "", 0);

?><div id="output1"></div><?

$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$title = addslashes($_REQUEST['title']);
$details = addslashes($_REQUEST['details']);
$cols ="title , details";
$values = "'$title' , '$details' ";
$brief  = addslashes($_REQUEST['brief']);
$cols .= ", brief";
$values .= ", '$brief'";
$lang = addslashes($_REQUEST['lang']);
$cols .= " , lang ";
$values .= ", '$lang'";
$SQL = "INSERT INTO pages ($cols) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?=$id?>" />
<table>
<!---------------------------------------------------------------------------------->
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Title?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="title" size="50" value="<?=stripslashes($title)?>" class="required" /></td>
</tr>
<!---------------------------------------------------------------------------------->
<?
?>
<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title"><?=Brief?>:</span></td><td width="5" class="required"></td>
<td><textarea name="brief" class="simpleEditor" ><?=stripslashes($brief)?></textarea></td>
</tr>
<?
?>
<!---------------------------------------------------------------------------------->
<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title"><?=Details?>:</span></td><td width="5" class="required"></td>
<td><textarea name="details" class="mceEditor" ><?=stripslashes($details)?></textarea></td>
</tr>
<!---------------------------------------------------------------------------------->
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Lang?>:</span></td>
<td width="5" class="required">*</td>
<td><?=createComboBox("languages" , "lang", "lang_name" , $lang , "lang", "required");?></td>
</tr>
<?
?>
<!---------------------------------------------------------------------------------->
</table>
<input name="sub" type="submit" id="sub" value="Save">
<input name="sub4" type="button" id="sub3" value="<?=ALL_Pages?>" onClick=" document.location='listPages.php'">
</form></div><?
}
include_once("../common/footer-admin.php"); ?>
