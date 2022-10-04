<?php include_once("../common/header-admin.php"); ?>
<?php
//define ordering cretiria:
function getNewHighlightOrder(){
$lang = $_SESSION['lang'];
return getNewItemOrder("highlight_highlight", "item_order", "");
}
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
$item_order = getNewHighlightOrder();


$cols .= "photo_en ";
$cols .= ",title_en ";
$cols .= ", link_en ";
$cols .= ", description_en ";
$cols .= ", type_en ";

$cols .= ", photo_ar ";
$cols .= ", title_ar ";
$cols .= ", link_ar ";
$cols .= ", description_ar ";
$cols .= ", type_ar ";

$cols .= ", item_order";
$cols .= ", active ";


$values .= "'$photo_en'";
$values .= ",'$title_en'";
$values .= ",'$link_en'";
$values .= ",'$description_en'";
$values .= ",'$type_en'";

$values .= ",'$photo_ar'";
$values .= ",'$title_ar'";
$values .= ",'$link_ar'";
$values .= ",'$description_ar'";
$values .= ",'$type_ar'";

$values .= ",'$item_order'";
$values .= ",'$active'";

$SQL = "INSERT INTO highlight_highlight ( $cols) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessage("'.Record_Enter.'")</script>';
else echo '<script>cerrorMessage("'.CantInsert.'")</script>' ;
}// Sub
else{ ?>

<?php } ?>
<?php if((!$sub) || (!$result)){ ?>
<div class="head"><h1 class="title_en"><?php echo Highlight?>: Enter Record</h1></div>
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