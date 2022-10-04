<?php include_once("../common/header-admin.php"); ?>
<?php

$sub = $_POST['sub'];
if($sub){
$id = addslashes($_REQUEST['id']);
$photo_en = addslashes($_REQUEST['photo_en']);
$photo_en = str_replace("../../uploads/","",$photo_en);
$title_en = addslashes($_REQUEST['title_en']);
$link_en = addslashes($_REQUEST['link_en']);
$description_en = addslashes($_REQUEST['description_en']);
$type_en = addslashes($_REQUEST['type_en']);

$photo_ar = addslashes($_REQUEST['photo_ar']);
$photo_ar = str_replace("../../uploads/","",$photo_ar);
$title_ar = addslashes($_REQUEST['title_ar']);
$link_ar = addslashes($_REQUEST['link_ar']);
$description_ar = addslashes($_REQUEST['description_ar']);
$type_ar = addslashes($_REQUEST['type_ar']);

$active = addslashes($_REQUEST['active']);


$values ="id = '$id' ";
$values .= ", photo_en = '$photo_en'";
$values .= ", title_en = '$title_en'";
$values .= ", link_en = '$link_en'";
$values .= ", type_en = '$type_en'";
$values .= ", description_en = '$description_en'";

$values .= ", photo_ar = '$photo_ar'";
$values .= ", title_ar = '$title_ar'";
$values .= ", link_ar = '$link_ar'";
$values .= ", type_ar = '$type_ar'";
$values .= ", description_ar = '$description_ar'";

$values .= ", active = '$active'";
$SQL = "UPDATE highlight_highlight SET $values  WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)
echo '<script>correctMessage("'.Record_Update.'")</script>';
else echo '<script>cerrorMessage("'.CantInsert.'")</script>' ;
}// Sub
else{ ?>
<?php
$id = $_GET['id'];
$sql ="SELECT * FROM highlight_highlight WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
if ($numberOfRows>0) {
$i=0;
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$photo_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo_en");
$link_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"link_en");
$title_en=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"title_en");
$type_en=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"type_en");
$description_en=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"description_en");

$photo_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo_ar");
$link_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"link_ar");
$title_ar=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"title_ar");
$type_ar=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"type_ar");
$description_ar=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"description_ar");

$active=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"active");
}
?>

<?php } ?>
<?php if((!$sub) || (!$result)){ ?>
<div class="head"><h1 class="title_en"><?php echo Highlight?>: Update Record</h1></div>
<div id="output1"></div>
<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="Hidden" name="sub" size="20" value="save" />
<table>
<input type="Hidden" name="id" size="20" value="<?php echo $id?>" class=""/>
<?php
?>
<tr>
	<td align="<?php echo _ALI?>"><b><?php echo Photo?> (EN):</b></td>
	<td width="5"></td>
	<td><input type="Text" name="photo_en" size="20" value="<?php echo stripslashes($photo_en)?>" class=""/>
	<a href="javascript:mcImageManager.open('subForm','photo_en','','',{relative_urls : true});">[Select file]</a> 450x265 px </td>
</tr>

<tr>
	<td align="<?php echo _ALI?>"><b><?php echo Photo?> (AR):</b></td>
	<td width="5"></td>
	<td><input type="Text" name="photo_ar" size="20" value="<?php echo stripslashes($photo_ar)?>" class=""/>
	<a href="javascript:mcImageManager.open('subForm','photo_ar','','',{relative_urls : true});">[Select file]</a> 450x265 px </td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Title?> (EN):</b></td>
<td width="5">*</td>
<td><input type="Text" name="title_en" size="20" value="<?php echo stripslashes($title_en)?>" class="required"/>  </td>
</tr>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Title?> (AR):</b></td>
<td width="5">*</td>
<td><input type="Text" name="title_ar" size="20" value="<?php echo stripslashes($title_ar)?>" class="required"/>  </td>
</tr>

<tr>
<td align="<?php echo _ALI?>"><b><?php echo Type?> (EN):</b></td>
<td width="5">*</td>
<td><input type="Text" name="type_en" size="20" value="<?php echo stripslashes($type_en)?>" class="required"/>  </td>
</tr>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Type?> (AR):</b></td>
<td width="5">*</td>
<td><input type="Text" name="type_ar" size="20" value="<?php echo stripslashes($type_ar)?>" class="required"/>  </td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Link?> (EN):</b></td>
<td width="5"></td>
<td><input type="Text" name="link_en" size="20" value="<?php echo stripslashes($link_en)?>" class=""/>  </td>
</tr>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Link?> (AR):</b></td>
<td width="5"></td>
<td><input type="Text" name="link_ar" size="20" value="<?php echo stripslashes($link_ar)?>" class=""/>  </td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Description?> (EN):</b></td>
<td width="5"></td>
<td><textarea name="description_en" cols="40" rows="5"><?php echo $description_en; ?></textarea></td>
</tr>
<tr>
<td align="<?php echo _ALI?>"><b><?php echo Description?> (AR):</b></td>
<td width="5"></td>
<td><textarea name="description_ar" cols="40" rows="5"><?php echo $description_ar; ?></textarea></td>
</tr>
<?php
?>
<tr>
<td align="<?php echo _ALI; ?>"><span class="field_title_en"><?php echo Active; ?>:</span></td><td width="5" class=""></td>
<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
</tr>
</table>
<input type="submit" name="sub" value="<?php echo  Save?>">
<input type="button" name="back" value="<?php echo  Back?>" onClick="javascript:window.location='listHighlight.php';">
</form>
<?php
} ?>
<?php include_once("../common/footer-admin.php"); ?>