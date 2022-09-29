<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Member: Insert new member", "Members", "", 0);

?><div id="output1"></div><?

$sub = $_REQUEST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$name_en = addslashes($_REQUEST['name_en']);
$name_ar = addslashes($_REQUEST['name_ar']);
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
//$ord = addslashes($_REQUEST['ord']);
$ord =  getNewItemOrder("mem_members", "ord",'');
$brief_ar = addslashes($_REQUEST['brief_ar']);
$brief_en = addslashes($_REQUEST['brief_en']);
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
if(!$active)
	$active = 0;

if($_SESSION['USER'] != 2){
	$creator_id = $_SESSION['USER'];
}else{
	$creator_id = $_REQUEST['creator_id'];
}


$cols  = " name_ar ";         $values  ="  '$name_ar'";
$cols  .= ", name_en ";         $values  .=",  '$name_en'";
$cols .= ", specialization ";   $values .=", '$specialization'";
//$cols .= ", description_en "; $values .=", '$description_en'";
$cols .= ", country ";     $values .=", '$country'";
$cols .= ", active ";      $values .=", '$active'";
//$cols .= ", lang";       $values .=", '$lang'";
$cols .= ", ord ";         $values .=", '$ord'";
$cols .= ", tel ";         $values .=", '$tel'";
$cols .= ", fax ";         $values .=", '$fax'";
$cols .= ", address_ar ";         $values .=", '$address_ar'";
$cols .= ", address_en ";         $values .=", '$address_en'";
$cols .= ", email ";         $values .=", '$email'";
$cols .= ", website ";         $values .=", '$website'";
$cols .= ", logo_en ";         $values .=", '$logo_en'";
$cols .= ", logo_ar ";         $values .=", '$logo_ar'";
$cols .= ", brief_ar ";         $values .=", '$brief_ar'";
$cols .= ", brief_en ";         $values .=", '$brief_en'";
$cols .= ", representer_en ";         $values .=", '$representer_en'";
$cols .= ", representer_ar ";         $values .=", '$representer_ar'";
$cols .= " , creator_id"; $values .=" , '$creator_id'";
 

$SQL = "INSERT INTO mem_members ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
//'<script>$(document).ready(function (){$(".temp").html("'.$SQL.'")});</script>';
//<div class='temp'></div>
}
if((!$sub) || (!$result)){ ?>
<form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="id" size="20" value="<?=$id?>" />
<?
?>

<table>
<tr>

<?if($_SESSION['USER'] == 2){?>
	<tr>
		<td align="<?=_ALI?>"><span class="field_title">Creator:</span></td>
		<td width="5" class="required">*</td>
		<td>
			<?=createComboBoxFiltered("users" , "user_id", "full_name" , $creator_id , "creator_id", ' grp_id <> "3" ' ,"required");?>
		</td>
	</tr>
<?}?>

<td align="<?=_ALI?>"><span class="field_title">Name: </span></td><td width="5" class="required">*</td>
<td> En: <input type="Text" name="name_en" size="50" value="<?=stripslashes($name_en)?>" class="required" />
	 Ar: <input type="Text" name="name_ar" size="50" value="<?=stripslashes($name_ar)?>" class="required" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">Representative: </span></td><td width="5" class="required">*</td>
<td> En: <input type="Text" name="representer_en" size="50" value="<?=stripslashes($representer_en)?>" class="required" />
	 Ar: <input type="Text" name="representer_ar" size="50" value="<?=stripslashes($representer_ar)?>" class="required" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">tele: </span></td><td width="5" class=""></td>
<td><input type="Text" name="tel" size="50" value="<?=stripslashes($tel)?>" class="" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">fax: </span></td><td width="5" class=""></td>
<td><input type="Text" name="fax" size="50" value="<?=stripslashes($fax)?>" class="" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">address_ar: </span></td><td width="5" class=""></td>
<td><input type="Text" name="address_ar" size="50" value="<?=stripslashes($address_ar)?>" class="" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">address_en: </span></td><td width="5" class=""></td>
<td><input type="Text" name="address_en" size="50" value="<?=stripslashes($address_en)?>" class="" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">email: </span></td><td width="5" class=""></td>
<td><input type="Text" name="email" size="50" value="<?=stripslashes($email)?>" class="" /></td>
</tr>

<tr>
<td align="<?=_ALI?>"><span class="field_title">website: </span></td><td width="5" class=""></td>
<td><input type="Text" name="website" size="50" value="<?=stripslashes($website)?>" class="" /></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Logo (EN):</span></td><td width="5" class=""></td>
 <td><input type="Text" name="logo_en" size="20" value="<?php echo stripslashes($logo_en)?>" class=""/>
<a href="javascript:mcImageManager.open('subForm','logo_en','','',{relative_urls : true});">[Select file]</a></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Logo (AR):</span></td><td width="5" class=""></td>
 <td><input type="Text" name="logo_ar" size="20" value="<?php echo stripslashes($logo_ar)?>" class=""/>
<a href="javascript:mcImageManager.open('subForm','logo_ar','','',{relative_urls : true});">[Select file]</a></td>
</tr>


<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title"><?=Country?>:</span></td><td width="5" class="required">*</td>
<td><?=createComboBox("country", "id", "country_en", $id, "country" , "required");?></td>
</tr>

<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Sub Sector:</span></td><td width="5" class=""></td>
<td><?=createCheckBox("specialization", "id", "specialization_en", $id, "specialization");?></td>
</tr>

<!--tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Products:</span></td><td width="5" class="required"></td>
<td>En: <textarea name="products_en" class="simpleEditor" ><?=stripslashes($products_en)?></textarea>
	Ar: <textarea name="products_ar" class="simpleEditor" ><?=stripslashes($products_ar)?></textarea>
</td>
</tr-->


<tr>
<td valign="top" align="<?=_ALI?>"><span class="field_title">Brief:</span></td><td width="5" class="required"></td>
<td>En: <textarea name="brief_en" class="simpleEditor" ><?=stripslashes($brief_en)?></textarea>
	Ar: <textarea name="brief_ar" class="simpleEditor" ><?=stripslashes($brief_ar)?></textarea>
</td>
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
<input name="sub4" type="button" id="sub3" value="<?=all_Members?>" onClick=" document.location='listMembers.php?<?=$url?>'">
</form><?
}
include_once("../common/footer-admin.php"); ?>

