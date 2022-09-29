<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Announcements: Insert Announcements Item", "News", "", 0);

?><div id="output1"></div><?

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

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}


$gallery = addslashes($_REQUEST['gallery']);
$link = addslashes($_REQUEST['link']);
$special = addslashes($_REQUEST['special']);

$cols = "subject"; $values = "'$subject'";
$cols .= " , brief "; $values .=" , '$brief'";
$cols .= ", details "; $values .=", '$details'";

$cols .= ", subject_ar "; $values .=", '$subject_ar'";
$cols .= ", brief_ar "; $values .=", '$brief_ar'";
$cols .= ", details_ar "; $values .=", '$details_ar'";

$cols .= ", publish_date"; $values .=", '$publish_date'";

$cols .= " , active"; $values .=" , '$active'";
$cols .= " , lang"; $values .=" , '$lang'";
$cols .= " , gallery"; $values .=" , '$gallery'";
$cols .= " , link"; $values .=" , '$link'";
$cols .= " , special"; $values .=" , '$special'";
$cols .= " , creator_id"; $values .=" , '$creator_id'";

echo $SQL = "INSERT INTO news_news ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<?
?>
<table>

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
<?
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"> publish date :</span></td>
<td width="5" class=""></td>
<td><input type="Text" name="publish_date" size="20" value="<?php echo stripslashes($publish_date); ?>" class=" dateF" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (EN):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief"  class="" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (AR):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief_ar"  class="" ><?php echo stripslashes($brief_ar); ?></textarea></td>
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

<?
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?
?>
<input name="sub4" type="button" id="sub3" value="<?php echo Back; ?>" onClick=" document.location='listNews.php?<?php echo $url; ?>'">
</form></div><?
}
include_once("../common/footer-admin.php"); ?>
