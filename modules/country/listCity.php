<?php include_once("../common/header-admin.php"); ?>
<div class="head">
<h1 class="title"><?php echo City?></h1>
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
	$city_ar = addslashes($_REQUEST['city_ar']);
	$city_en = addslashes($_REQUEST['city_en']);
	$country_id = addslashes($_REQUEST['country_id']);

	$SQL = "INSERT INTO city (city_ar , city_en , country_id ) VALUES ('$city_ar' , '$city_en' , '$country_id' )";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)
 	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
if($action=="Upd"){
	$id = addslashes($_REQUEST['id']);
	$city_ar = addslashes($_REQUEST['city_ar']);
	$city_en = addslashes($_REQUEST['city_en']);
	$country_id = addslashes($_REQUEST['country_id']);

	$SQL = "UPDATE city SET id = '$id' , city_ar = '$city_ar' , city_en = '$city_en' , country_id = '$country_id' WHERE id = '$id' ";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)
 	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
if($action=="Del"){
if(isset($_POST['rid'])){
		$array = $_POST['rid'];
		$ids = implode(",",$array); 
		$sql = "DELETE FROM city WHERE id IN ($ids) ";
		$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
		if($result) echo '<script>correctMessageWithoutBack("'.Record_delete.'")</script>';
	}}// Delete record
$sql = "SELECT * FROM city  $sort ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
$i=0;
?>
<form method='post' name='subForm' action='<?php echo $_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='id' value='<?php echo $_GET['id']; ?>'>


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
		<a href="<?php echo $PHP_SELF;?>?pn=<?php echo $pn?>&so=<?php echo $so?>&sb=city_ar&"><b>City (AR)</b></a>
	</th>
	<th>
		<a href="<?php echo $PHP_SELF;?>?pn=<?php echo $pn?>&so=<?php echo $so?>&sb=city_en&"><b>City (EN)</b></a>
	</th>
	<th>
		<a href="<?php echo $PHP_SELF;?>?pn=<?php echo $pn?>&so=<?php echo $so?>&sb=country_id&"><b><?php echo Country_id?></b></a>
	</th>
	<th colspan="4"> &nbsp; </th>
</tr>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>
<tr>
	<td>&nbsp;</td>
	<td><input type="Text" name="city_ar" size="20" value="<?php echo stripslashes($city_ar)?>" class=""/>  </td>
	<td><input type="Text" name="city_en" size="20" value="<?php echo stripslashes($city_en)?>" class=""/>  </td>
	<td><?php echo createComboBox("country" , "id", "country_en" , $country_id , "country_id", "required");?></td>
	<td colspan=4 class="tableData"><img src="<?php echo _PREF?>images/icons/save.png" onClick="actionf('Ins')" onMouseOver="over(this)" alt="<?php echo _Save; ?>" /></td>
</tr>
<?php 
}// Enter record

while ($i<$numberOfRows){
	$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
	$city_ar= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"city_ar");
	$city_en= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"city_en");
	$country_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"country_id");

if($action=="Edit"  && $_REQUEST['id'] == $id){?>
<tr>
	<td>&nbsp;</td>
	<td><input type="Text" name="city_ar" size="20" value="<?php echo stripslashes($city_ar)?>" class=""/>  </td>
	<td><input type="Text" name="city_en" size="20" value="<?php echo stripslashes($city_en)?>" class=""/>  </td>
	<td><?php echo createComboBox("country" , "id", "country_en" , $country_id , "country_id", "required");?></td>
	<td colspan=4><img src="<?php echo _PREF?>images/icons/save.png" onClick="actionf('Upd')" onMouseOver="over(this)" alt="<?php echo _Save; ?>" /></td>
</tr>
<?php 
}// Edit record
else{
?>
	<tr>
	<td><input name="rid[]" type="checkbox" value="<?php echo $id; ?>"/></td>
		<td><?php echo stripslashes($city_ar)?></td>
		<td><?php echo stripslashes($city_en)?></td>
		<td><?php echo lookupField("country" , "id", "country_en" , $country_id)?></td>
	
	<td width="30" align="center"><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&id=<?php echo $id?>&"><?php echo _Edit?></a></td>
	</tr>
<?php 	}//end else
	$i++;
}//End While
?>
</tbody>
</table>
<div class="control">
<a href="javascript:actionf('Del')" class="Del"><img src="<?php echo _PREF?>images/icons/Delete.png" border="0"/></a>
<a href="javascript:actionf('Enter')"><img src="<?php echo _PREF?>images/icons/new.png" border="0"/></a><a href="javascript:actionf('Refresh')"><img src="<?php echo _PREF?>images/icons/refresh.png" border="0"/></a>
</div>
<br>
</form>
<?php include_once("../common/footer-admin.php"); ?>