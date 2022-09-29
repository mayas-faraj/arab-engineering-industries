<? include_once("../common/header-admin.php");

echo print_GridAdminHead("Active forms groups","Active forms groups", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$topic_id = addslashes($_REQUEST['topic_id']);
$grp_id = addslashes($_REQUEST['grp_id']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "topic_id ";
	$values = "'$topic_id'";

	$cols .= " , grp_id ";
	$values .= " , '$grp_id'";	
	
	$cols .= ""; $values .= "";

	$SQL = "INSERT INTO topic_groups ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	//echo '<script>$(document).ready(function(){$(".query").html("'.$SQL.'")});</script>';
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
	//else echo '<script>alert("'.$SQL.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "topic_id = '$topic_id'";
	$values .= " , grp_id = '$grp_id'";

	$SQL = "UPDATE topic_groups SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	if($array){
		$ids = implode(",", $array);
		deleteRecord("topic_groups","id in ($ids)",true);
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM topic_groups  where topic_id = '$topic_id' $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$users_combo = createComboBox("forum_group" , "id", "name_en" , $topic_id , "topic_id", "required",'','','',0);
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
<input type="Hidden" name="topic_id" size="20" value="<?php echo $topic_id; ?>" />
<thead>
	<TR>
		<th width="100px;"><?php echo print_AdminRecordHead("grp_id", "Group", $sb, $so, $static_order); ?></th>
		<th colspan="3">&nbsp;</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<td><?php echo createComboBox("forum_group" , "id", "name_en" , $grp_id , "grp_id", "required",'','','',0); ?></td>
	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="1">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$topic_id= MYSQL_RESULT($result,$i,"topic_id");
	$grp_id= MYSQL_RESULT($result,$i,"grp_id");

	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
			
			<td><?php echo createComboBox("forum_group" , "id", "name_en" , $grp_id , "grp_id", "required",'','','',0); ?></td>

			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="2">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD class='query'><?php echo lookupField('forum_group','id','name_en',stripslashes($grp_id)); ?></TD>
			
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
<input type='button' onClick='document.location="listArticlesCat.php"' value='Back'/>
<? include_once("../common/footer-admin.php"); ?>