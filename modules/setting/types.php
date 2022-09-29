<? include_once("../common/header-admin.php");

echo print_GridAdminHead("Activity Types","Types", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$name_en = addslashes($_REQUEST['name_en']);
$name_ar = addslashes($_REQUEST['name_ar']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "name_en";
	$values = "'$name_en'";

	$cols .= ", name_ar"; $values .= ",'$name_ar'";

	$SQL = "INSERT INTO types ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "name_en = '$name_en'";
	$values .= ", name_ar = '$name_ar'";

	$SQL = "UPDATE types SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("types","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM types $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i=0;?>
<div class="data">
<form method='post' name='main' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<script>
function actionf(act){
	main.action.value = act;
	main.submit();
}
</script>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
<thead>
	<TR>
		<th width="100px;"><?php echo print_AdminRecordHead("name_en", "Name (EN)", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("name_ar", "Name (AR)", $sb, $so, $static_order); ?></th>
		<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<TD><input type="Text" name="name_en" size="20" value="<?php echo stripslashes($name_en); ?>"/></TD>
	<TD><input type="Text" name="name_ar" size="20" value="<?php echo stripslashes($name_ar); ?>"/></TD>
	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="3">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$name_en= MYSQL_RESULT($result,$i,"name_en");
	$name_ar= MYSQL_RESULT($result,$i,"name_ar");
	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<TD>
				<input type="Text" name="name_en" size="20" value="<?php echo stripslashes($name_en); ?>" />
				<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
			</TD>
			<TD>
				<input type="Text" name="name_ar" size="20" value="<?php echo stripslashes($name_ar); ?>" />
			</TD>	
			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="3">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?php echo stripslashes($name_en); ?></TD>
			<TD><?php echo stripslashes($name_ar); ?></TD>
			<TD width="42" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id)?></TD>
			<?/**delete_grp_functions(part 1 of 2)********************************************/?>
			<TD width="29" align="center"><?php echo print_delete_ckbox($id); ?></TD>
			<?//-------------------------------------------------------?>
		</TR>
	<?}//end else
	$i++;
}//End While?>
</tbody>
</TABLE>
<br><br>
</form>
</div>
<? include_once("../common/footer-admin.php"); ?>