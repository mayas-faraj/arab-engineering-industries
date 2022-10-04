<?php include_once("../common/header-admin.php");
$term = cleanString(addslashes($_REQUEST['term']));
$start_year = lookupField('terms','id','start_year',$term);
$end_year = lookupField('terms','id','end_year',$term);
echo print_GridAdminHead("Members of the term ".$start_year.' - '.$end_year,"Members of the tirm ".$start_year.' - '.$end_year, 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = cleanString($_REQUEST['id']);

$member = cleanString(addslashes($_REQUEST['member']));
$position = cleanString(addslashes($_REQUEST['position']));
$action = cleanString($_REQUEST['action']);
if($action=="Insert"){
	$cols = "term_id";
	$values = "'$term'";

	$cols .= ", member_id"; $values .= ",'$member'";
	$cols .= ", position"; $values .= ",'$position'";


	$SQL = "INSERT INTO term_members ( $cols ) VALUES ($values)";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
	//echo '<script>alert("'.$SQL.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "term_id = '$term'";
	$values .= ", member_id = '$member'";
	$values .= ", position = '$position'";


	$SQL = "UPDATE term_members SET $values WHERE id = '$id' ";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
	//echo '<script>alert("'.$SQL.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("term_members","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM term_members WHERE term_id='$term' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
$i=0;?>
<div class="data">
<form method='post' name='main' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='term' value='<?php echo $term; ?>'>
<script>
function actionf(act){
	main.action.value = act;
	main.submit();
}
</script>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
<thead>
	<TR>
		<th width="100px;"><?php echo print_AdminRecordHead("member_id", "Member", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("position", "Position", $sb, $so, $static_order); ?></th>

		<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>
<TR>
	<TD><?php echo createComboBox("mem_council", "id", "name_en", $member_id, "member" , "required");; ?></TD>
	<TD><input type="Text" name="position" size="20" value="<?php echo stripslashes($position); ?>"/></TD>

	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="3">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
	$member_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"member_id");
	$position= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"position");

	if($action=="Edit"  && cleanString($_REQUEST['id']) == $id){?>
    	<TR>
			<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
			<TD><?php echo createComboBox("mem_council", "id", "name_en", $member_id, "member" , "required");; ?></TD>		
			<TD><input type="Text" name="position" size="20" value="<?php echo stripslashes($position); ?>" /></TD>

			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="3">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?php echo lookupField('mem_council','id','name_en',$member_id); ?></TD>
			<TD><?php echo stripslashes($position); ?></TD>

			<TD width="42" align="center"><?php echo print_edit_icon($_SERVER['PHP_SELF']."?term=$term&action=Edit&id=".$id)?></TD>
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

<input type="button" name="back" value="<?php echo  Back?>" onClick="javascript:window.location='terms.php';">
<?php include_once("../common/footer-admin.php"); ?>