<? include_once("../common/header-admin.php");

echo print_GridAdminHead("Forum group users","Forum group users", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$user_id = addslashes($_REQUEST['user_id']);
$grp_id = addslashes($_REQUEST['grp_id']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "user_id ";
	$values = "'$user_id'";

	$cols .= " , grp_id ";
	$values .= " , '$grp_id'";	
	
	$cols .= ""; $values .= "";

	$SQL = "INSERT INTO forum_users_groups ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	//echo '<script>$(document).ready(function(){$(".query").html("'.$SQL.'")});</script>';
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';

}
//-------------------------------------------------
if($action=="Update"){
	$values = "user_id = '$user_id'";
	$values .= " , grp_id = '$grp_id'";

	$SQL = "UPDATE forum_users_groups SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("forum_users_groups","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM forum_users_groups  where grp_id = '$grp_id' $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$users_combo = createComboBox("users" , "user_id", "full_name" , $user_id , "user_id", "required",'','','',0);
$i=0;?>
<div class="data">
<form method='post' name='main' action='<?=$_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<script>
function actionf(act){
	main.action.value = act;
	main.submit();
}
</script>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
<input type="Hidden" name="grp_id" size="20" value="<?=$grp_id?>" />
<thead>
	<TR>
		<th width="100px;"><?=print_AdminRecordHead("user_id", "User", $sb, $so, $static_order)?></th>
		<th colspan="3">&nbsp;</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<td><?=$users_combo?></td>
	<TD><?=print_save_icon("Insert")?></TD>
	<TD colspan="1">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$user_id= MYSQL_RESULT($result,$i,"user_id");
	$grp_id= MYSQL_RESULT($result,$i,"grp_id");

	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<input type="Hidden" name="id" size="20" value="<?=$id?>" />
			
			<td><?=createComboBox("users" , "user_id", "full_name" , $user_id , "user_id", "required");?></td>

			<TD><?=print_save_icon("Update")?></TD>
			<TD colspan="2">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD class='query'><?=lookupField('users','user_id','full_name',stripslashes($user_id))?></TD>
			
			<?/**delete_grp_functions(part 1 of 2)********************************************/?>
			<TD width="29" align="center"><?=print_delete_ckbox($id)?></TD>
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
<input type='button' onClick='document.location="listUsers_groups_forum.php"' value='Back'/>
<? include_once("../common/footer-admin.php"); ?>