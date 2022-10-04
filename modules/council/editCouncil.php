<?php  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("BOD: Update", "BOD", "", 0);

?>
<div id="output1"></div>
<?php
$sub = $_REQUEST['sub'];
$term = $_REQUEST['term'];
if($sub){
$id = addslashes($_REQUEST['id']);
$name_ar = addslashes($_REQUEST['name_ar']);
$name_en = addslashes($_REQUEST['name_en']);
$position_ar = addslashes($_REQUEST['position_ar']);
$position_en = addslashes($_REQUEST['position_en']);
$company_ar = addslashes($_REQUEST['company_ar']);
$company_en = addslashes($_REQUEST['company_en']);
$address_ar = addslashes($_REQUEST['address_ar']);
$address_en = addslashes($_REQUEST['address_en']);
$country = addslashes($_REQUEST['country']);
$photo = addslashes($_REQUEST['photo']);
$active = addslashes($_REQUEST['active']);
$biography_en = addslashes($_REQUEST['biography_en']);
$biography_ar = addslashes($_REQUEST['biography_ar']);


$email = addslashes($_REQUEST['email']);
$website = addslashes($_REQUEST['website']);
$tel = addslashes($_REQUEST['tel']);
$fax = addslashes($_REQUEST['fax']);

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}

$j = 0;
foreach ( $_REQUEST['terms'] as $k=> $c)
{
	if($j == 0)
		$terms .= $c;
	else
		$terms .= ','.$c;
	$j++;
}
//$lang = addslashes($_REQUEST['lang']);
if(!$active)
	$active = 0;
$photo = str_replace("../../uploads/", "", $photo );

$values = "name_ar = '$name_ar'";
$values .= ", name_en = '$name_en'";
$values .= " ,position_ar = '$position_ar'";
$values .= " ,position_en = '$position_en'";
$values .= " ,company_en = '$company_en'";
$values .= " ,company_ar = '$company_ar'";
$values .= " , country = '$country'";
$values .= " , photo = '$photo'";
$values .= " , email = '$email'";
$values .= " , website = '$website'";
$values .= " , tel = '$tel'";
$values .= " , fax = '$fax'";
$values .= " , address_ar = '$address_ar'";
$values .= " , address_en = '$address_en'";
$values .= " , active = '$active'";
$values .= " , biography_en = '$biography_en'";
$values .= " , biography_ar = '$biography_ar'";
$values .= " , terms = '$terms'";
$values .= " , creator_id = '$creator_id'";

//$values .= " , lang = '$lang'";

$SQL = "UPDATE mem_council SET $values WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){
$id = $_REQUEST['id'];
$sql ="SELECT * FROM mem_council WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
if ($numberOfRows>0) {
$i=0;
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$name_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"name_ar");
$name_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"name_en");
$position_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"position_ar");
$position_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"position_en");
$company_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"company_ar");
$company_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"company_en");
$country= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"country");
$photo= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo");
$active= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"active");
$address_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"address_en");
$address_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"address_ar");
$item_order= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"item_order");
$biography_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"biography_en");
$biography_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"biography_ar");
$terms= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"terms");
$tel= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"tel");
$fax= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"fax");
$email= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"email");
$website= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"website");
$creator_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"creator_id");

}?>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
<input type="Hidden" name="term" size="20" value="<?php echo $term; ?>" />
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
	<td align="<?php echo _ALI; ?>"><span class="field_title">Name: </span></td><td width="5" class="required">*</td>
	<td> En: <input type="Text" name="name_en" size="50" value='<?php echo stripslashes($name_en); ?>' class="required" />
		 Ar: <input type="Text" name="name_ar" size="50" value='<?php echo stripslashes($name_ar); ?>' class="required" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Phone: </span></td><td width="5" class=""></td>
<td><input type="Text" name="tel" size="50" value="<?php echo stripslashes($tel); ?>" class="" /></td>
</tr>

<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">fax: </span></td><td width="5" class=""></td>
<td><input type="Text" name="fax" size="50" value="<?php echo stripslashes($fax); ?>" class="" /></td>
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
	<td align="<?php echo _ALI; ?>"><span class="field_title">Position: </span></td><td width="5" class="required">*</td>
	<td> En: <input type="Text" name="position_en" size="50" value='<?php echo stripslashes($position_en); ?>' class="required" />
		 Ar: <input type="Text" name="position_ar" size="50" value='<?php echo stripslashes($position_ar); ?>' class="required" /></td>
</tr>

<?php
?>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Country; ?>:</span></td><td width="5" class="required">*</td>
<td><?php echo createComboBox("country", "id", "country_en", $country, "country","required");?></td>
</tr>
<?php
?>


<tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title">Company: </span></td><td width="5" class="required">*</td>
	<td> En: <input type="Text" name="company_en" size="50" value='<?php echo stripslashes($company_en); ?>' class="required" />
		 Ar: <input type="Text" name="company_ar" size="50" value='<?php echo stripslashes($company_ar); ?>' class="required" /></td>
</tr>

<?php
?>
<tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Photo; ?>:</span></td><td width="5" class="required"></td>
 <td><input type="Text" name="photo" size="20" value="<?php echo stripslashes($photo)?>" class=""/>
<a href="javascript:mcImageManager.open('subForm','photo','','',{relative_urls : true});">[Select file]</a></td>
</tr>



<tr>
	<td align="<?php echo _ALI; ?>"><span class="field_title">Address: </span></td><td width="5" class="required">*</td>
	<td> En: <input type="Text" name="address_en" size="50" value='<?php echo stripslashes($address_en); ?>' class="" />
		 Ar: <input type="Text" name="address_ar" size="50" value='<?php echo stripslashes($address_ar); ?>' class="" /></td>
</tr>




<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Biography (En):</span></td><td width="5" class="required"></td>
<td><textarea name="biography_en" class="simpleEditor" ><?php echo stripslashes($biography_en); ?></textarea></td>
</tr>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title">Biography (Ar):</span></td><td width="5" class="required"></td>
<td><textarea name="biography_ar" class="simpleEditor" ><?php echo stripslashes($biography_ar); ?></textarea></td>
</tr>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td>
<td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>

<!--tr>
<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Terms; ?>:</span></td><td width="5" class="required">*</td>
<td><?php echo createCheckBox("terms", "id", "name_en", $terms, "terms");; ?></td>
</tr-->



</table>
<input name="sub" type="submit" id="sub" value="Save">
<?php
$url = 'term='.$term;
?>
<input name="sub4" type="button" id="sub3" value="All BOD Member" onClick=" document.location='listCouncilMembers.php?<?php echo $url; ?>'">
</form><?php
}
include_once("../common/footer-admin.php"); ?>
