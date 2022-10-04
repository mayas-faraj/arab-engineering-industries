<?php  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Activity: Insert Activity Item", "Activity", "", 0);

?><div id="output1"></div><?php

$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$subject = addslashes($_REQUEST['subject']);
$brief = addslashes($_REQUEST['brief']);
$details = addslashes($_REQUEST['details']);
$private = addslashes($_REQUEST['private']);

$place_ar = addslashes($_REQUEST['place_ar']);
$place = addslashes($_REQUEST['place']);

$subject_ar = addslashes($_REQUEST['subject_ar']);
$brief_ar = addslashes($_REQUEST['brief_ar']);
$details_ar = addslashes($_REQUEST['details_ar']);
$private_ar = addslashes($_REQUEST['private_ar']);

$activity_date = addslashes($_REQUEST['activity_date']);
$end_date = addslashes($_REQUEST['end_date']);
$active = addslashes($_REQUEST['active']);
$photo = addslashes($_REQUEST['photo']);
$link = addslashes($_REQUEST['link']);
$special = addslashes($_REQUEST['special']);

$atype = addslashes($_REQUEST['atype']);
$afield = addslashes($_REQUEST['afield']);
$alevel = addslashes($_REQUEST['alevel']);

$gal_id = addslashes($_REQUEST['gal_id']);

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}

$cols = "subject"; $values = "'$subject'";
$cols .= " , brief "; $values .=" , '$brief'";
$cols .= ", details "; $values .=", '$details'";
$cols .= ", private "; $values .=", '$private'";

$cols .= ", place "; $values .=", '$place'";
$cols .= ", place_ar "; $values .=", '$place_ar'";

$cols .= " , subject_ar "; $values .= " , '$subject_ar' ";
$cols .= " , brief_ar "; $values .=" , '$brief_ar'";
$cols .= " , details_ar "; $values .=" , '$details_ar'";
$cols .= " , private_ar "; $values .=" , '$private_ar'";
$cols .= " , link "; $values .=" , '$link'";
$cols .= " , special "; $values .=" , '$special'";

$cols .= ", activity_date"; $values .=", '$activity_date'";
$cols .= ", end_date"; $values .=", '$end_date'";
$cols .= " , active"; $values .=" , '$active'";
$cols .= " , atype"; $values .=" , '$atype'";
$cols .= " , afield"; $values .=" , '$afield'";
$cols .= " , alevel"; $values .=" , '$alevel'";
$cols .= " , gal_id"; $values .=" , '$gal_id'";
$cols .= " , creator_id"; $values .=" , '$creator_id'";
 

echo $SQL = "INSERT INTO mem_activities ( $cols ) VALUES ( $values )";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
//else echo '<script>$("document").ready( function(){$(".ttest").attr("value","'.$SQL.'");});	</script>' ;
}
if((!$sub) || (!$result)){ ?>
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
	<td align="<?php echo _ALI; ?>"><span class="field_title">Subject: </span></td><td width="5" class="required">*</td>
	<td> 
		En: <input type="Text" name="subject" size="50" value="<?php echo stripslashes($subject); ?>" class="required" />
		Ar: <input type="Text" name="subject_ar" size="50" value="<?php echo stripslashes($subject_ar); ?>" class="required" /> 
	</td>
</tr>

<tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title">Places: </span></td><td width="5" class="required">*</td>
	<td> 
		En: <input type="Text" name="place" size="50" value="<?php echo stripslashes($place); ?>" class="required" />
		Ar: <input type="Text" name="place_ar" size="50" value="<?php echo stripslashes($place_ar); ?>" class="required" /> 
	</td>
</tr>



<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"> Activity Start date :</span></td>
<td width="5" class=""></td>
<td><input type="Text" name="activity_date" size="54" value="<?php echo stripslashes($activity_date); ?>" class=" dateF" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"> Activity End date :</span></td>
<td width="5" class=""></td>
<td><input type="Text" name="end_date" size="54" value="<?php echo stripslashes($end_date); ?>" class=" dateF" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (EN):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief" cols='140' class="" ><?php echo stripslashes($brief); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?> (AR):</span></td>
<td width="5" class=""></td>
<td><textarea name="brief_ar" cols='140' class="" ><?php echo stripslashes($brief_ar); ?></textarea></td>
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
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Private (EN):</span></td>
<td width="5" class=""></td>
<td><textarea name="private" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($private); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Private (AR):</span></td>
<td width="5" class=""></td>
<td><textarea name="private_ar" cols="50" rows="4" class="mceEditor" ><?php echo stripslashes($private_ar); ?></textarea></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td><td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>

<tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Special; ?>:</span></td><td width="5" class=""></td>
	<TD><input type="Checkbox" name="special" size="20" value="1" <?php echo ($special)? "checked" : ""?>  /></TD>
</tr>

<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Gallery:</span></td>
	<td width="5" class="" valign="top"></td>
	<td><?php echo galleryComboBox($gal_id, "gal_id");?> &nbsp; &nbsp; Minimum photo size: 220px x 130px</td>
</tr>

<!--tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Activity Type:</span></td>
	<td width="5" class="" valign="top">*</td>
	<td><?php echo createComboBox("types" , "id", "name_en" , $atype , "atype", "required");; ?></td>
</tr-->

<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Activity Field:</span></td>
	<td width="5" class="" valign="top">*</td>
	<td><?php echo createComboBox("fields" , "id", "name_en" , $afield , "afield", "required");; ?></td>
</tr>

<tr>
	<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title">Activity Level:</span></td>
	<td width="5" class="" valign="top">*</td>
	<td><?php echo createComboBox("levels" , "id", "name_en" , $alevel , "alevel", "required");; ?></td>
</tr>


<?php
?>
</table>
<input name="sub" type="submit" id="sub" value="Save">
<?php
?>
<input name="sub4" type="button" id="sub3" value="All Activities" onClick=" document.location='listActivities.php?<?php echo $url; ?>'">
</form></div><?php
}
include_once("../common/footer-admin.php"); ?>
