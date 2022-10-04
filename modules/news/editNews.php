<?php  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Announcements: Update", "Announcements", "", 0);

?>
<div id="output1"></div>
<?php
$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$subject = addslashes($_REQUEST['subject']);
$brief = addslashes($_REQUEST['brief']);
$details = addslashes($_REQUEST['details']);

$subject_ar = addslashes($_REQUEST['subject_ar']);
$brief_ar = addslashes($_REQUEST['brief_ar']);
$details_ar = addslashes($_REQUEST['details_ar']);

$publish_date = addslashes($_REQUEST['publish_date']);
$end_date = addslashes($_REQUEST['end_date']);

$active = addslashes($_REQUEST['active']);
$photo = addslashes($_REQUEST['photo']);
$lang = addslashes($_REQUEST['lang']);
$gallery = addslashes($_REQUEST['gallery']);
$link = addslashes($_REQUEST['link']);
$special = addslashes($_REQUEST['special']);
$photo = str_replace("../../uploads/","",$photo);
if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}

$values = "subject = '$subject'";
$values .= " , brief = '$brief'";
$values .= " ,details = '$details'";

$values .= " ,subject_ar = '$subject_ar'";
$values .= " ,brief_ar = '$brief_ar'";
$values .= " ,details_ar = '$details_ar'";

$values .= " ,publish_date = '$publish_date'";

$values .= " , active = '$active'";
$values .= " , lang = '$lang'";
$values .= " , gallery = '$gallery'";
$values .= " , link = '$link'";
$values .= " , special = '$special'";
$values .= " , creator_id = '$creator_id'";

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
$subject_ar= MYSQL_RESULT($result,$i,"subject_ar");
$brief= MYSQL_RESULT($result,$i,"brief");
$brief_ar= MYSQL_RESULT($result,$i,"brief_ar");
$details= MYSQL_RESULT($result,$i,"details");
$details_ar= MYSQL_RESULT($result,$i,"details_ar");
$publish_date= MYSQL_RESULT($result,$i,"publish_date");

$active= MYSQL_RESULT($result,$i,"active");
$photo= MYSQL_RESULT($result,$i,"photo");
$gallery= MYSQL_RESULT($result,$i,"gallery");
$link= MYSQL_RESULT($result,$i,"link");
$special= MYSQL_RESULT($result,$i,"special");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
}?>

<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<?php
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
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Subject; ?> (EN):</span></td>
<td width="5" class="required">*</td>
<td><input type="Text" name="subject" size="20" value="<?php echo stripslashes($subject); ?>" class="required" /></td>
</tr>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Subject; ?> (AR):</span></td>
<td width="5" class="required">*</td>
<td><input type="Text" name="subject_ar" size="20" value="<?php echo stripslashes($subject_ar); ?>" class="required" /></td>
</tr>

<!--tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Link; ?> :</span></td>
	<td width="5" class="required">*</td>
	<td><input type="Text" name="link" size="20" value="<?php echo stripslashes($link); ?>" class="required" /></td>
</tr-->
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"> publish date :</span></td>
<td width="5" class=""></td>
<td><input type="Text" name="publish_date" size="20" value="<?php echo stripslashes($publish_date); ?>" class=" dateF" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (EN):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief" rows='4' cols='140' class="" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (AR):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief_ar" rows='4' cols='140' class="" ><?php echo stripslashes($brief_ar); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Details; ?> (EN):</span></td>
<td width="5" class=""></td>
<td><textarea name="details" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($details); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Details; ?> (AR):</span></td>
<td width="5" class=""></td>
<td><textarea name="details_ar" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($details_ar); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td><td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>

<!--tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Special; ?>:</span></td><td width="5" class=""></td>
	<TD><input type="Checkbox" name="special" size="20" value="1" <?php echo ($special)? "checked" : ""?>  /></TD>
</tr-->

<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Gallery:</span></td>
	<td width="5" class="" valign="top"></td>
	<td><?php echo galleryComboBox($gallery, "gallery");?> &nbsp; &nbsp; Minimum photo size: 220px x 130px</td>
</tr>

<?php
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?php
?>
<input name="sub2" type="button" id="sub2" value="<?php echo Back; ?>" onClick=" document.location='listNews.php?<?php echo $url; ?>'">
</form><?php
}
include_once("../common/footer-admin.php"); ?>
