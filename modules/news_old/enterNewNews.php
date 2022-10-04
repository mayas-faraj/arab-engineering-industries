<?php  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("News: Insert New Item", "News", "", 0);

?><div id="output1"></div><?php

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
$cols = "subject";
$values = "'$subject'";
$cols .= " , brief "; $values .=" , '$brief'";
$cols .= ", details "; $values .=", '$details'";
$cols .= ", publish_date"; $values .=", '$publish_date'";
$cols .= " , end_date"; $values .=" , '$end_date'";
$cols .= " , special"; $values .=", '$special'";
$cols .= " , active"; $values .=" , '$active'";
$SQL = "INSERT INTO news_news ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<?php
?>
<table>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Subject; ?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="subject" size="50" value="<?php echo stripslashes($subject); ?>" class="required" /></td>
</tr>
<?php
?>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo publish_date; ?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="publish_date" size="20" value="<?php echo stripslashes($publish_date); ?>" class="required dateF" /></td>
</tr>
<?php
?>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo end_date; ?>:</span></td><td width="5" class="required">*</td>
<td><input type="Text" name="end_date" size="20" value="<?php echo stripslashes($end_date); ?>" class="required dateF" /></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?>:</span></td>
<td width="5" class=""></td>
<td><textarea name="brief"  class="simpleEditor" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>
<?php
?>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Details; ?>:</span></td><td width="5" class="required"></td>
<td><textarea name="details" class="mceEditor" ><?php echo stripslashes($details); ?></textarea></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Special; ?>:</span></td>
<td width="5" class=""></td>
<TD><input type="Checkbox" name="special" size="20" value="1" <?php echo ($special)? "checked" : ""?>  /></TD>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td>
<td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>
<?php
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?php
?>
<input name="sub4" type="button" id="sub3" value="<?php echo all_news; ?>" onClick=" document.location='listNews.php?<?php echo $url; ?>'">
</form></div><?php
}
include_once("../common/footer-admin.php"); ?>
