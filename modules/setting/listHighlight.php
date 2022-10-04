<?php include_once("../common/header-admin.php");

echo print_GridAdminHead("Highlights","Highlights", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="publish_date";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$publish_date = addslashes($_REQUEST['publish_date']);
$end_date = addslashes($_REQUEST['end_date']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "publish_date";
	$values = "'$publish_date'";

	$cols .= ", end_date"; $values .= ",'$end_date'";

	$SQL = "INSERT INTO highlight ( $cols ) VALUES ($values)";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "publish_date = '$publish_date'";
	$values .= ", end_date = '$end_date'";

	$SQL = "UPDATE highlight SET $values WHERE id = '$id' ";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("highlight","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM highlight $sort ";
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
		<th width="100px;"><?php echo print_AdminRecordHead("table_name", "Table", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("record_id", "Record name", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("publish_date", "Publish date", $sb, $so, $static_order); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("end_date", "End date", $sb, $so, $static_order); ?></th>
		<th colspan="2">&nbsp;</th>
</TR>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>

<?}// Enter record
while ($i<$numberOfRows){
	$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
	$publish_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"publish_date");
	$end_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"end_date");
	$table_name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"table_name");
	$record_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"record_id");
	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<TD><?php echo stripslashes($table_name); ?></TD>	
			<TD><?php echo stripslashes($record_id); ?></TD>	
			<TD>
				<input type="Text" name="publish_date" size="20" class='dateF' value="<?php echo stripslashes($publish_date); ?>" />
				<input type="Hidden" name="id" size="20"  value="<?php echo $id; ?>" />
			</TD>
			<TD>
				<input type="Text" name="end_date" size="20" class='dateF' value="<?php echo stripslashes($end_date); ?>" />
			</TD>
			<TD><?php echo print_save_icon("Update"); ?></TD>
			<th colspan="1">&nbsp;</th>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<?php
				switch($table_name){
					case 'resources':
						$title= lookupField('resources','id','title',$record_id);
						$table_name= 'Resources';
					break;
					
					case 'news_news':
						$title= lookupField($table_name,'id','subject',$record_id);
						$table_name= 'News';
					break;
					
					case 'mem_activities':
						$title= lookupField($table_name,'id','subject',$record_id);
						$table_name= 'Activities';
					break;
				}
			?>
			<TD><?php echo stripslashes($table_name); ?></TD>	
			<TD><?php echo stripslashes($title); ?></TD>			
			<TD><?php echo stripslashes($publish_date); ?></TD>
			<TD><?php echo stripslashes($end_date); ?></TD>
			<TD width="42" align="center"><?php echo print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id)?></TD>
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
<?php include_once("../common/footer-admin.php"); ?>