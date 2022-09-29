<?php include_once("../common/header-admin.php"); ?>
<div class="head">
<h1 class="title"><?php echo Country?></h1>
<a href="javascript:actionf('Del')" class="Del"><img src="<?php echo _PREF?>images/icons/Delete.png" border="0"/></a>
<a href="javascript:actionf('Enter')"><img src="<?php echo _PREF?>images/icons/new.png" border="0"/></a><a href="javascript:actionf('Refresh')"><img src="<?php echo _PREF?>images/icons/refresh.png" border="0"/></a>
</div>
<?php
$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;

$action = $_REQUEST['action'];
$key = $_REQUEST['key'];

if($action=="Ins"){
	$id = addslashes($_REQUEST['id']);
	$country_ar = addslashes($_REQUEST['country_ar']);
	$country_en = addslashes($_REQUEST['country_en']);

	$SQL = "INSERT INTO country (country_ar , country_en ) VALUES ('$country_ar' , '$country_en' )";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
if($action=="Upd"){
	$id = addslashes($_REQUEST['id']);
	$country_ar = addslashes($_REQUEST['country_ar']);
	$country_en = addslashes($_REQUEST['country_en']);

	$SQL = "UPDATE country SET id = '$id' , country_ar = '$country_ar' , country_en = '$country_en' WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
if($action=="Del"){
if(isset($_POST['rid'])){
		$array = $_POST['rid'];
		$ids = implode(",",$array); 
		$sql = "DELETE FROM country WHERE id IN ($ids) ";
		$result = MYSQL_QUERY($sql);
		if($result) echo '<script>correctMessageWithoutBack("'.Record_delete.'")</script>';
	}}// Delete record
$sql = "SELECT * FROM country  $sort ";
$result = mysql_query($sql);
$numberOfRows = mysql_numrows($result);
$i=0;
?>
<form method='post' name='subForm' action='<?php echo $_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='id' value='<?=$_GET['id']?>'>


<script>
function actionf(act){
	subForm.action.value = act;
	subForm.submit();
}
</script>
<br>
<table cellspacing="0" cellpadding="0" border="0" width="100%" id="list">
<thead>
<tr>
	<th>&nbsp;</th>
	<th>
		<a href="<?php echo $PHP_SELF;?>?pn=<?php echo $pn?>&so=<?php echo $so?>&sb=country_ar&"><b>Country (AR)</b></a>
	</th>
	<th>
		<a href="<?php echo $PHP_SELF;?>?pn=<?php echo $pn?>&so=<?php echo $so?>&sb=country_en&"><b>Country (EN)</b></a>
	</th>
	<th colspan="5"> &nbsp; </th>
</tr>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>
<tr>
	<td>&nbsp;</td>
	<td><input type="Text" name="country_ar" size="20" value="<?php echo stripslashes($country_ar)?>" class=""/>  </td>
	<td><input type="Text" name="country_en" size="20" value="<?php echo stripslashes($country_en)?>" class=""/>  </td>
	<td colspan=5 class="tableData"><img src="<?php echo _PREF?>images/icons/save.png" onClick="actionf('Ins')" onMouseOver="over(this)" alt="<?=_Save?>" /></td>
</tr>
<?php 
}// Enter record

while ($i<$numberOfRows){
	$id= mysql_result($result,$i,"id");
	$country_ar= mysql_result($result,$i,"country_ar");
	$country_en= mysql_result($result,$i,"country_en");

if($action=="Edit"  && $_REQUEST['id'] == $id){?>
<tr>
	<td>&nbsp;</td>
	<td><input type="Text" name="country_ar" size="20" value="<?php echo stripslashes($country_ar)?>" class=""/>  </td>
	<td><input type="Text" name="country_en" size="20" value="<?php echo stripslashes($country_en)?>" class=""/>  </td>
	<td colspan=5><img src="<?php echo _PREF?>images/icons/save.png" onClick="actionf('Upd')" onMouseOver="over(this)" alt="<?=_Save?>" /></td>
</tr>
<?php 
}// Edit record
else{
?>
	<tr>
	<td><input name="rid[]" type="checkbox" value="<?=$id?>"/></td>
		<td><?php echo stripslashes($country_ar)?></td>
		<td><?php echo stripslashes($country_en)?></td>
	
	<td width="30" align="center"><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&id=<?php echo $id?>&"><?php echo Edit?></a></td>
	</tr>
<?php 	}//end else
	$i++;
}//End While
?>
</tbody>
</table>
<div class="control">
<a href="javascript:actionf('Del')" class="Del"><img src="<?php echo _PREF?>images/icons/Delete.png" border="0"/></a>
<a href="javascript:actionf('Enter')"><img src="<?php echo _PREF?>images/icons/new.png" border="0"/></a><a href="javascript:actionf('Refresh')"><img src="<?php echo _PREF?>images/icons/refresh.png" border="0"/></a></div>
<br>
</form>
<?php include_once("../common/footer-admin.php"); ?>