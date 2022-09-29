<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("News: Update", "News", "", 0);

?>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$subject = addslashes($_REQUEST['subject']);
$brief = addslashes($_REQUEST['brief']);
$details = addslashes($_REQUEST['details']);
$publish_date = addslashes($_REQUEST['publish_date']);
$end_date = addslashes($_REQUEST['end_date']);
$special = addslashes($_REQUEST['special']);
$active = addslashes($_REQUEST['active']);
$values = "subject = '$subject'";
$values .= " , brief = '$brief'";
$values .= " ,details = '$details'";
$values .= " ,publish_date = '$publish_date'";
$values .= " ,end_date = '$end_date'";
$values .= " , special = '$special'";
$values .= " , active = '$active'";
$SQL = "UPDATE news_news SET $values WHERE id = '$id' ";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM news_news WHERE id = '$id' ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows>0) {
$i=0;
$id= MYSQL_RESULT($result,$i,"id");
$subject= MYSQL_RESULT($result,$i,"subject");
$brief= MYSQL_RESULT($result,$i,"brief");
$details= MYSQL_RESULT($result,$i,"details");
$publish_date= MYSQL_RESULT($result,$i,"publish_date");
$end_date= MYSQL_RESULT($result,$i,"end_date");
$special= MYSQL_RESULT($result,$i,"special");
$active= MYSQL_RESULT($result,$i,"active");
}?>
<form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?=$id?>" />
<?
?>
<table>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Subject?>:</span></td>
<td width="5" class="required">*</td>
<td><input type="Text" name="subject" size="20" value="<?=stripslashes($subject)?>" class="required" /></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=publish_date?>:</span></td>
<td width="5" class="">*</td>
<td><input type="Text" name="publish_date" size="20" value="<?=stripslashes($publish_date)?>" class="required dateF" /></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=end_date?>:</span></td>
<td width="5" class="">*</td>
<td><input type="Text" name="end_date" size="20" value="<?=stripslashes($end_date)?>" class="required dateF" /></td>
</tr>

<?
?>
<tr>
<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Brief?>:</span></td>
<td width="5" class=""></td>
<td><textarea name="brief"  class="simpleEditor" ><?=stripslashes($brief)?></textarea></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Details?>:</span></td>
<td width="5" class=""></td>
<td><textarea name="details" cols="50" rows="4" class="mceEditor" ><?=stripslashes($details)?></textarea></td>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Special?>:</span></td><td width="5" class=""></td>
<TD><input type="Checkbox" name="special" size="20" value="1" <?php echo ($special)? "checked" : ""?>  /></TD>
</tr>
<?
?>
<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Active?>:</span></td><td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>
<?
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?
?>
<input name="sub2" type="button" id="sub2" value="<?=all_news?>" onClick=" document.location='listNews.php?<?=$url?>'">
</form><?
}
include_once("../common/footer-admin.php"); ?>
