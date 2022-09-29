<? include_once("../common/header-admin.php");

echo print_GridAdminHead("Specialization","Specialization", 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$specialization_en = addslashes($_REQUEST['specialization_en']);
$specialization_ar = addslashes($_REQUEST['specialization_ar']);
$action = $_REQUEST['action'];
if($action=="Insert"){
	$cols = "specialization_en";
	$values = "'$specialization_en'";

	$cols .= ", specialization_ar"; $values .= ",'$specialization_ar'";

	$SQL = "INSERT INTO specialization ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "specialization_en = '$specialization_en'";
	$values .= ", specialization_ar = '$specialization_ar'";

	$SQL = "UPDATE specialization SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
	$array = $_POST['rid'];
	
	if($array){
		$ids = implode(",", $array);
		$related_sql = " select count(*) from mem_members where specialization in ($ids) ";
		$related = mysql_numrows(mysql_query($related_sql));
		if(!$related){
			deleteRecord("specialization","id in ($ids)",true);
		}else{
			echo '<script>alert("Sorry: specialization cannot be deleted because it is related to a member");</script>';
		}
		
	}
}
//-------------------------------------------------
$sql = "SELECT * FROM specialization $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
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
<thead>
	<TR>
		<th width="100px;"><?=print_AdminRecordHead("specialization_en", "Sub Sector (EN)", $sb, $so, $static_order)?></th>
		<th width="100px;"><?=print_AdminRecordHead("specialization_ar", "Sub Sector (AR)", $sb, $so, $static_order)?></th>
		<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<TD><input type="Text" name="specialization_en" size="20" value="<?=stripslashes($specialization_en)?>"/></TD>
	<TD><input type="Text" name="specialization_ar" size="20" value="<?=stripslashes($specialization_ar)?>"/></TD>
	<TD><?=print_save_icon("Insert")?></TD>
	<TD colspan="3">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$specialization_en= MYSQL_RESULT($result,$i,"specialization_en");
	$specialization_ar= MYSQL_RESULT($result,$i,"specialization_ar");
	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<TD>
				<input type="Text" name="specialization_en" size="20" value="<?=stripslashes($specialization_en)?>" />
				<input type="Hidden" name="id" size="20" value="<?=$id?>" />
			</TD>
			<TD>
				<input type="Text" name="specialization_ar" size="20" value="<?=stripslashes($specialization_ar)?>" />
			</TD>	
			<TD><?=print_save_icon("Update")?></TD>
			<TD colspan="3">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?=stripslashes($specialization_en)?></TD>
			<TD><?=stripslashes($specialization_ar)?></TD>
			<TD width="42" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id)?></TD>
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
<? include_once("../common/footer-admin.php"); ?>