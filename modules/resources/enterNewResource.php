<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("FYI: Insert FYI Item", "FYI", "", 0);

?><div id="output1"></div><?

$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$title = addslashes($_REQUEST['title']);
$keyword = addslashes($_REQUEST['keyword']);
$details = addslashes($_REQUEST['details']);
$lang = addslashes($_REQUEST['lang']);
$link = addslashes($_REQUEST['link']);
$brief = addslashes($_REQUEST['brief']);
$special = addslashes($_REQUEST['special']);
$photo = addslashes($_REQUEST['photo']);
$private = addslashes($_REQUEST['private']);

$cols = "title"; $values = "'$title'";
$cols .= " , keyword "; $values .=" , '$keyword'";
$cols .= ", details "; $values .=", '$details'";
$cols .= " , lang"; $values .=" , '$lang'";
$cols .= " , link"; $values .=" , '$link'";
$cols .= " , brief"; $values .=" , '$brief'";
$cols .= " , special"; $values .=" , '$special'";
$cols .= " , private"; $values .=" , '$private'";

echo $SQL = "INSERT INTO resources ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="40" value="<?php echo $id; ?>" />

<table>
<tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Title; ?> :</span></td>
	<td width="5" class="required">*</td>
	<td><input type="Text" name="title" size="40" value="<?php echo stripslashes($title); ?>" class="required" /></td>
</tr>
<!--tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Link; ?> :</span></td>
	<td width="5" class="required">*</td>
	<td><input type="Text" name="link" size="40" value="<?php echo stripslashes($link); ?>" class="required" /></td>
</tr-->
<tr>
	<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Photo; ?>:</span></td><td width="5" class=""></td>
	<td><input type="Text" name="photo" size="40" value="<?php echo stripslashes($photo)?>" class=""/>
	<a href="javascript:mcImageManager.open('subForm','photo','','',{relative_urls : true});">[Select file]</a></td>
</tr>
<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Keywords; ?> :</span></td>
	<td width="5" class=""></td>
	<td><textarea name="keyword" rows='2' cols='140' class="" ><?php echo stripslashes($keyword); ?></textarea></td>
</tr>
<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> :</span></td>
	<td width="5" class=""></td>
	<td><textarea name="brief"  rows='2' cols='140' class="" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>
<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Details; ?> :</span></td>
	<td width="5" class=""></td>
	<td><textarea name="details" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($details); ?></textarea></td>
</tr>
<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Private :</span></td>
	<td width="5" class=""></td>
	<td><textarea name="private" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($private); ?></textarea></td>
</tr>
<tr>
<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Language:</span></td>
	<td width="5" class="" valign="top">*</td>
	<td><?php echo createComboBox("languages" , "lang", "lang_name" , $lang , "lang", "required");; ?></td>
</tr>

<!--tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Special; ?>:</span></td><td width="5" class=""></td>
	<TD><input type="Checkbox" name="special" size="40" value="1" <?php echo ($special)? "checked" : ""?>  /></TD>
</tr-->
</table>

<input name="sub" type="submit" id="sub" value="Save">
<?
?>
<input name="sub4" type="button" id="sub3" value="Back" onClick=" document.location='listResources.php?<?php echo $url; ?>'">
</form></div><?
}
include_once("../common/footer-admin.php"); ?>
