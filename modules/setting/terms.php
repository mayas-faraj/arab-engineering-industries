<? include_once("../common/header-admin.php");

echo print_GridAdminHead("Terms","Terms", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$start_year = addslashes($_REQUEST['start_year']);
$end_year = addslashes($_REQUEST['end_year']);
$position = addslashes($_REQUEST['position']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "start_year";
	$values = "'$start_year'";

	$cols .= ", end_year"; $values .= ",'$end_year'";
	$cols .= ", position"; $values .= ",'$position'";

	$SQL = "INSERT INTO terms ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "start_year = '$start_year'";
	$values .= ", end_year = '$end_year'";
	$values .= ", position = '$position'";

	$SQL = "UPDATE terms SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("terms","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM terms $sort ";
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
		<th width="100px;"><?php echo print_AdminRecordHead("start_year", "Start year", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("end_year", "End year", $sb, $so, $static_order); ?></th>
		<th colspan="3" align="center" style='text-align:center;'>Controler</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<TD><input type="Text" name="start_year" size="20" value="<?php echo stripslashes($start_year); ?>"/></TD>
	<TD><input type="Text" name="end_year" size="20" value="<?php echo stripslashes($end_year); ?>"/></TD>

	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="2">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$start_year= MYSQL_RESULT($result,$i,"start_year");
	$end_year= MYSQL_RESULT($result,$i,"end_year");

	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<TD>
				<input type="Text" name="start_year" size="20" value="<?php echo stripslashes($start_year); ?>" />
				<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
			</TD>
			<TD>
				<input type="Text" name="end_year" size="20" value="<?php echo stripslashes($end_year); ?>" />
			</TD>

			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="2">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?php echo stripslashes($start_year); ?></TD>
			<TD><?php echo stripslashes($end_year); ?></TD>
			<TD width="20px" align="center"><a href='term_members.php?term=<?php echo $id; ?>'>Term's members</a></TD>
			<TD width="20px" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id)?></TD>
			<TD width="20px" align="center"><?php echo print_delete_ckbox($id); ?></TD>
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