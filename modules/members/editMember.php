<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Member: Update", "Member", "", 0);

?>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];
if($sub){
	$id = addslashes($_REQUEST['id']);
	$name_ar = addslashes($_REQUEST['name_ar']);
	$name_en = addslashes($_REQUEST['name_en']);
	//$specialization = addslashes($_REQUEST['specialization']);
	$j = 0;
	foreach ( $_REQUEST['specialization'] as $k=> $c)
	{
		if($j == 0)
			$specialization .= $c;
		else
			$specialization .= ','.$c;
		$j++;
	}
	$country = addslashes($_REQUEST['country']);
	$active = addslashes($_REQUEST['active']);

	
	$brief_ar = addslashes($_REQUEST['brief_ar']);
	$brief_en = addslashes($_REQUEST['brief_en']);
	
	//$ord = addslashes($_REQUEST['ord']);
	$tel = addslashes($_REQUEST['tel']);
	$fax = addslashes($_REQUEST['fax']);
	$address_ar = addslashes($_REQUEST['address_ar']);
	$address_en = addslashes($_REQUEST['address_en']);
	$email = addslashes($_REQUEST['email']);
	$website = addslashes($_REQUEST['website']);
	$representer_en = addslashes($_REQUEST['representer_en']);
	$representer_ar = addslashes($_REQUEST['representer_ar']);
	$logo_en = addslashes($_REQUEST['logo_en']);
	$logo_en = str_replace("../../uploads/", "", $logo_en );
	$logo_ar = addslashes($_REQUEST['logo_ar']);
	$logo_ar = str_replace("../../uploads/", "", $logo_ar );
	//$lang = addslashes($_REQUEST['lang']);
	if($_SESSION['USER'] != 2){
		$creator_id = $_SESSION['USER'];
	}else{
		$creator_id = $_REQUEST['creator_id'];
	}
	if(!$active)
		$active = 0;
	
$values = "name_en = '$name_en'";
$values .= " , name_ar = '$name_ar'";
$values .= " , specialization = '$specialization'";
//$values .= " ,description_en = '$description_en'";
$values .= " ,country = '$country'";
$values .= " , active = '$active'";

$values .= " , brief_ar = '$brief_ar'";
$values .= " , brief_en = '$brief_en'";
//$values .= " , lang = '$lang'";
//$values .= " , ord = '$ord'";
$values .= " , tel = '$tel'";
$values .= " , fax = '$fax'";
$values .= " , address_ar = '$address_ar'";
$values .= " , address_en = '$address_en'";
$values .= " , email = '$email'";
$values .= " , website = '$website'";
$values .= " , representer_en = '$representer_en'";
$values .= " , representer_ar = '$representer_ar'";
$values .= " , logo_en = '$logo_en'";
$values .= " , logo_ar = '$logo_ar'";
$values .= " , creator_id = '$creator_id'";


$SQL = "UPDATE mem_members SET $values WHERE id = '$id' ";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
//'<script>$(document).ready(function (){$(".temp").html("'.$SQL.'")});</script>';
//<div class='temp'></div>
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM mem_members WHERE id = '$id' ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows>0) {
$i=0;
$id= MYSQL_RESULT($result,$i,"id");
$name_ar= MYSQL_RESULT($result,$i,"name_ar");
$name_en= MYSQL_RESULT($result,$i,"name_en");
$specialization= MYSQL_RESULT($result,$i,"specialization");
$description_en= MYSQL_RESULT($result,$i,"description_en");
$country= MYSQL_RESULT($result,$i,"country");
$active= MYSQL_RESULT($result,$i,"active");

$brief_ar= MYSQL_RESULT($result,$i,"brief_ar");
$brief_en= MYSQL_RESULT($result,$i,"brief_en");
$ord= MYSQL_RESULT($result,$i,"ord");
$address_en= MYSQL_RESULT($result,$i,"address_en");
$address_ar= MYSQL_RESULT($result,$i,"address_ar");
$representer_en= MYSQL_RESULT($result,$i,"representer_en");
$representer_ar= MYSQL_RESULT($result,$i,"representer_ar");
$tel= MYSQL_RESULT($result,$i,"tel");
$fax= MYSQL_RESULT($result,$i,"fax");
$email= MYSQL_RESULT($result,$i,"email");
$website= MYSQL_RESULT($result,$i,"website");
$logo_en= MYSQL_RESULT($result,$i,"logo_en");
$logo_ar= MYSQL_RESULT($result,$i,"logo_ar");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
}?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<?
?>

<table>

<tr>

<?if($_SESSION['USER'] == 2){?>
	<tr>
		<td align="<?php echo _ALI; ?>"><span class="field_title">Creator:</span></td>
		<td width="5" class="required">*</td>
		<td>
			<?php echo createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");; ?>
		</td>
	</tr>
<?}?>

<td align="<?php echo _ALI; ?>"><span class="field_title">Name: </span></td><td width="5" class="required">*</td>
<td> En: <input type="Text" name="name_en" size="50" value="<?php echo stripslashes($name_en); ?>" class="required" />
	 Ar: <input type="Text" name="name_ar" size="50" value="<?php echo stripslashes($name_ar); ?>" class="required" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Representative: </span></td><td width="5" class="required">*</td>
<td> En: <input type="Text" name="representer_en" size="50" value="<?php echo stripslashes($representer_en); ?>" class="required" />
	 Ar: <input type="Text" name="representer_ar" size="50" value="<?php echo stripslashes($representer_ar); ?>" class="required" /></td>
</tr>


<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">tel: </span></td><td width="5" class=""></td>
<td><input type="Text" name="tel" size="50" value="<?php echo stripslashes($tel); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">fax: </span></td><td width="5" class=""></td>
<td><input type="Text" name="fax" size="50" value="<?php echo stripslashes($fax); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">address_en: </span></td><td width="5" class=""></td>
<td><input type="Text" name="address_en" size="50" value="<?php echo stripslashes($address_en); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">address_ar: </span></td><td width="5" class=""></td>
<td><input type="Text" name="address_ar" size="50" value="<?php echo stripslashes($address_ar); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">email: </span></td><td width="5" class=""></td>
<td><input type="Text" name="email" size="50" value="<?php echo stripslashes($email); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">website: </span></td><td width="5" class=""></td>
<td><input type="Text" name="website" size="50" value="<?php echo stripslashes($website); ?>" class="" /></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Logo (EN):</span></td><td width="5" class=""></td>
 <td><input type="Text" name="logo_en" size="20" value="<?php echo stripslashes($logo_en)?>" class=""/>
<a href="javascript:mcImageManager.open('subForm','logo_en','','',{relative_urls : true});">[Select file]</a></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Logo (AR):</span></td><td width="5" class=""></td>
 <td><input type="Text" name="logo_ar" size="20" value="<?php echo stripslashes($logo_ar)?>" class=""/>
<a href="javascript:mcImageManager.open('subForm','logo_ar','','',{relative_urls : true});">[Select file]</a></td>
</tr>


<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Country; ?>:</span></td><td width="5" class="required">*</td>
<td><?php echo createComboBox("country", "id", "country_en", $country, "country" , "required");; ?></td>
</tr>

<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Sub Sector:</span></td><td width="5" class=""></td>
<td><?php echo createCheckBox("specialization", "id", "specialization_en", $specialization, "specialization");; ?></td>
</tr>
<!--tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Products:</span></td><td width="5" class="required"></td>
<td>En: <textarea name="products_en" class="simpleEditor" ><?php echo stripslashes($products_en); ?></textarea>
	Ar: <textarea name="products_ar" class="simpleEditor" ><?php echo stripslashes($products_ar); ?></textarea>
</td>
</tr-->


<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Brief:</span></td><td width="5" class="required"></td>
<td>En: <textarea name="brief_en" class="simpleEditor" ><?php echo stripslashes($brief_en); ?></textarea>
	Ar: <textarea name="brief_ar" class="simpleEditor" ><?php echo stripslashes($brief_ar); ?></textarea>
</td>
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
<input name="sub4" type="button" id="sub3" value="<?php echo all_Members; ?>" onClick=" document.location='listMembers.php?<?php echo $url; ?>'">
</form><?
}
include_once("../common/footer-admin.php"); ?>
