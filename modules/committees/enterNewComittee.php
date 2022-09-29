<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Committees: Insert new committees", "Committees", "", 0);

?><div id="output1"></div><?

$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$name_ar = addslashes($_REQUEST['name_ar']);
$name_en = addslashes($_REQUEST['name_en']);
$creation_date = addslashes($_REQUEST['creation_date']);
$description_ar = addslashes($_REQUEST['description_ar']);
$description_en = addslashes($_REQUEST['description_en']);
$brief_en = addslashes($_REQUEST['brief_en']);
$brief_ar = addslashes($_REQUEST['brief_ar']);
$private_en = addslashes($_REQUEST['private_en']);
$private_ar = addslashes($_REQUEST['private_ar']);
$active = addslashes($_REQUEST['active']);
$ord = addslashes($_REQUEST['ord']);

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}

//$lang = addslashes($_REQUEST['lang']);
if(!$active)
	$active = 0;

$cols  = " name_ar ";         $values  ="  '$name_ar'";
$cols  .= ", name_en ";         $values  .=",  '$name_en'";
$cols .= ", creation_date ";   $values .=", '$creation_date'";
$cols .= ", description_ar "; $values .=", '$description_ar'";
$cols .= ", description_en "; $values .=", '$description_en'";
$cols .= ", brief_en "; $values .=", '$brief_en'";
$cols .= ", brief_ar "; $values .=", '$brief_ar'";
$cols .= ", private_en "; $values .=", '$private_en'";
$cols .= ", private_ar "; $values .=", '$private_ar'";
$cols .= ", active ";      $values .=", '$active'";
$cols .= ", ord ";         $values .=", '$ord'";
$cols .= ", creator_id ";         $values .=", '$creator_id'";

$SQL = "INSERT INTO mem_committees ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?=$id?>" />
<?
?>
<table>
<?if($_SESSION['USER'] == 2){?>
	<tr>
	<td align="<?=_ALI?>"><span class="field_title">Creator:</span></td>
	<td width="5" class="required">*</td>
	<td>
		<?=createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");?>
	</td>
	</tr>
<?}?>
<tr>
<td align="<?=_ALI?>"><span class="field_title">Name (En):</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="name_en" size="50" value="<?=stripslashes($name_en)?>" class="required" /></td>
</tr>
<tr>
<td align="<?=_ALI?>"><span class="field_title">Name (Ar):</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="name_ar" size="50" value="<?=stripslashes($name_ar)?>" class="required" /></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title"><?=Creation_Date?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="creation_date" size="20" value="<?=stripslashes($creation_date)?>" class="required dateF" /></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Brief (En):</span></td><td width="5" class="required"></td>
<td><textarea name="brief_en" class="simpleEditor" ><?=stripslashes($brief_en)?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Brief (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="brief_ar" class="simpleEditor" ><?=stripslashes($brief_ar)?></textarea></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Description (En):</span></td><td width="5" class="required"></td>
<td><textarea name="description_en" class="mceEditor" ><?=stripslashes($description_en)?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Description (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="description_ar" class="mceEditor" ><?=stripslashes($description_ar)?></textarea></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Private (En):</span></td><td width="5" class="required"></td>
<td><textarea name="private_en" class="mceEditor" ><?=stripslashes($private_en)?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Private (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="private_ar" class="mceEditor" ><?=stripslashes($private_ar)?></textarea></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title"><?=Active?>:</span></td>
<td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?
?>
<input name="sub4" type="button" id="sub3" value="All Committees" onClick=" document.location='listComittees.php?<?=$url?>'">
</form><?
}
include_once("../common/footer-admin.php"); ?>
