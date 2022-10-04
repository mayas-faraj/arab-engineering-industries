<?php include_once("../common/header-admin.php");

echo print_GridAdminHead("Users Groups","Users Groups", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="grp_id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$grp_id = $_REQUEST['grp_id'];
$grp_name = addslashes($_REQUEST['grp_name']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "grp_name";
	$values = "'$grp_name'";

	$cols .= ""; $values .= "";

	$SQL = "INSERT INTO users_groups ( $cols ) VALUES ($values)";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "grp_name = '$grp_name'";

	//$values .= ", photo = '$photo'";

	$SQL = "UPDATE users_groups SET $values WHERE grp_id = '$grp_id' ";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("users_groups","grp_id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM users_groups WHERE grp_id>3 $sort ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
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
		<th width="100px;"><?php echo print_AdminRecordHead("grp_name", "Group Name", $sb, $so, $static_order); ?></th>
		<th colspan="3">&nbsp;</th>
</TR>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>
<TR>
	<TD><input type="Text" name="grp_name" size="20" value="<?php echo stripslashes($grp_name); ?>"/></TD>
	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="2">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$grp_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"grp_id");
	$grp_name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"grp_name");
	if($action=="Edit"  && $_REQUEST['grp_id'] == $grp_id){?>
    	<TR>
			<TD><input type="Text" name="grp_name" size="20" value="<?php echo stripslashes($grp_name); ?>" />
				<input type="Hidden" name="grp_id" size="20" value="<?php echo $grp_id; ?>" />
			</TD>
			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="2">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?php echo stripslashes($grp_name); ?></TD>
			<TD width="42" align="center"><?php echo print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&grp_id=".$grp_id)?></TD>
			
			<TD width="30" align="center"><a href="listPermissions.php?grp_id=<?php echo $grp_id?>"><img src="../../images/icons/permissions.png" alt="<?php echo Permissions?>" border="0"></a></TD>
			<?/**delete_grp_functions(part 1 of 2)********************************************/?>
			<TD width="29" align="center"><?php echo print_delete_ckbox($grp_id); ?></TD>
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
<?php include_once("../common/footer-admin.php"); ?>