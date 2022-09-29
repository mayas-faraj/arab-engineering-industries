<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Committees: Update", "Committees", "", 0);

?>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$name_en = addslashes($_REQUEST['name_en']);
$name_ar = addslashes($_REQUEST['name_ar']);
$creation_date = addslashes($_REQUEST['creation_date']);
$description_ar = addslashes($_REQUEST['description_ar']);
$description_en = addslashes($_REQUEST['description_en']);
$brief_en = addslashes($_REQUEST['brief_en']);
$brief_ar = addslashes($_REQUEST['brief_ar']);
$private_en = addslashes($_REQUEST['private_en']);
$private_ar = addslashes($_REQUEST['private_ar']);
$active = addslashes($_REQUEST['active']);
$ord = addslashes($_REQUEST['ord']);
//$lang = addslashes($_REQUEST['lang']);

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}

if(!$active)
	$active = 0;

$values = "name_ar = '$name_ar'";
$values .= " , name_en = '$name_en'";
$values .= " ,creation_date = '$creation_date'";
$values .= " ,description_ar = '$description_ar'";
$values .= " ,description_en = '$description_en'";
$values .= " ,brief_en = '$brief_en'";
$values .= " ,brief_ar = '$brief_ar'";

$values .= " ,private_en = '$private_en'";
$values .= " ,private_ar = '$private_ar'";
$values .= " , active = '$active'";
$values .= " , ord = '$ord'";
$values .= " , creator_id = '$creator_id'";
//$values .= " , lang = '$lang'";

$SQL = "UPDATE mem_committees SET $values WHERE id = '$id' ";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
//else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
else echo '<script>alert("'.$SQL.'")</script>' ;
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM mem_committees WHERE id = '$id' ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows>0) {
$i=0;
$id= MYSQL_RESULT($result,$i,"id");
$name_ar= MYSQL_RESULT($result,$i,"name_ar");
$name_en= MYSQL_RESULT($result,$i,"name_en");
$creation_date= MYSQL_RESULT($result,$i,"creation_date");
$description_ar= MYSQL_RESULT($result,$i,"description_ar");
$description_en= MYSQL_RESULT($result,$i,"description_en");
$brief_en= MYSQL_RESULT($result,$i,"brief_en");
$brief_ar= MYSQL_RESULT($result,$i,"brief_ar");
$private_en= MYSQL_RESULT($result,$i,"private_en");
$private_ar= MYSQL_RESULT($result,$i,"private_ar");
$active= MYSQL_RESULT($result,$i,"active");
$ord= MYSQL_RESULT($result,$i,"ord");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
}?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<?
?>
<table>

<?if($_SESSION['USER'] == 2){?>
	<tr>
		<td align="<?php echo _ALI; ?>"><span class="field_title">Creator:</span></td>
		<td width="5" class="required">*</td>
		<td>
			<?php echo createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");; ?>
		</td>
	</tr>
<?}?>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Name(En):</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="name_en" size="50" value="<?php echo stripslashes($name_en); ?>" class="required" /></td>
</tr>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Name(Ar):</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="name_ar" size="50" value="<?php echo stripslashes($name_ar); ?>" class="required " /></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Creation_Date; ?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="creation_date" size="20" value="<?php echo stripslashes($creation_date); ?>" class="required dateF" /></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Brief (En):</span></td><td width="5" class="required"></td>
<td><textarea name="brief_en" class="simpleEditor" ><?php echo stripslashes($brief_en); ?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Brief (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="brief_ar" class="simpleEditor" ><?php echo stripslashes($brief_ar); ?></textarea></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Description (En):</span></td><td width="5" class="required"></td>
<td><textarea name="description_en" class="mceEditor" ><?php echo stripslashes($description_en); ?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Description (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="description_ar" class="mceEditor" ><?php echo stripslashes($description_ar); ?></textarea></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Private (En):</span></td><td width="5" class="required"></td>
<td><textarea name="private_en" class="mceEditor" ><?php echo stripslashes($private_en); ?></textarea></td>
</tr>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Private (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="private_ar" class="mceEditor" ><?php echo stripslashes($private_ar); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td>
<td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?
?>
<input name="sub4" type="button" id="sub3" value="All Committees" onClick=" document.location='listComittees.php?<?php echo $url; ?>'">
</form><?
}
include_once("../common/footer-admin.php"); ?>
