<? include_once("../common/header-admin.php");
$term = addslashes($_REQUEST['term']);
$start_year = lookupField('terms','id','start_year',$term);
$end_year = lookupField('terms','id','end_year',$term);
echo print_GridAdminHead("Members of the term ".$start_year.' - '.$end_year,"Members of the tirm ".$start_year.' - '.$end_year, 1, 1, 1, 1);

echo '<div class="controls">';

echo '</div>';

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY $sb $so";
//****************************************************

$id = $_REQUEST['id'];
$ord = addslashes($_REQUEST['ord']);
$member = addslashes($_REQUEST['member']);
$position_en = addslashes($_REQUEST['position_en']);
$position_ar = addslashes($_REQUEST['position_ar']);
$action = $_REQUEST['action'];

changeOrder("term_members", "id", "ord", getNewItemOrder("term_members", "ord", " term_id = $term "));

if($action=="Insert"){
	$cols = "term_id";
	$values = "'$term'";

	$cols .= ", member_id"; $values .= ",'$member'";
	$cols .= ", position_en"; $values .= ",'$position_en'";
	$cols .= ", position_ar"; $values .= ",'$position_ar'";
	$cols .= ", ord"; $values .= ",'$ord'";


	$SQL = "INSERT INTO term_members ( $cols ) VALUES ($values)";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
	else echo '<script>alert("'.$SQL.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
	$values = "term_id = '$term'";
	$values .= ", member_id = '$member'";
	$values .= ", position_en = '$position_en'";
	$values .= ", position_ar = '$position_ar'";
	$values .= ", ord = '$ord'";


	$SQL = "UPDATE term_members SET $values WHERE id = '$id' ";
	$result = mysql_query($SQL);
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
$sql = "SELECT * FROM term_members WHERE term_id='$term' order by ord ASC ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
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
<input type='hidden' value='<?php echo $term; ?>' name='term'/>
<thead>
	<TR>
		<th width="100px;"><?php echo print_AdminRecordHead("member_id", "Member", $sb, $so, $static_order,"&term=".$term); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("position_en", "Position (EN)", $sb, $so, $static_order,"&term=".$term); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("position_ar", "Position (AR)", $sb, $so, $static_order,"&term=".$term); ?></th>
		<th width="100px;"><?php echo print_AdminRecordHead("ord", "Order", $sb, $so, $static_order,"&term=".$term); ?></th>

		<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody>
<? if($action=="Enter"){ ?>
<TR>
	<TD><?php echo createComboBox("mem_council", "id", "name_en", $member_id, "member" , "required");; ?></TD>
	<TD><input type="Text" name="position_en" size="20" value="<?php echo stripslashes($position_en); ?>"/></TD>
	<TD><input type="Text" name="position_ar" size="20" value="<?php echo stripslashes($position_ar); ?>"/></TD>
	<TD><input type="Text" name="ord" size="20" value="<?php echo stripslashes($ord); ?>"/></TD>

	<TD><?php echo print_save_icon("Insert"); ?></TD>
	<TD colspan="2">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$member_id= MYSQL_RESULT($result,$i,"member_id");
	$position_en= MYSQL_RESULT($result,$i,"position_en");
	$position_ar= MYSQL_RESULT($result,$i,"position_ar");
	$ord= MYSQL_RESULT($result,$i,"ord");

	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
			<TD><?php echo createComboBox("mem_council", "id", "name_en", $member_id, "member" , "required");; ?></TD>		
			<TD><input type="Text" name="position_en" size="20" value="<?php echo stripslashes($position_en); ?>" /></TD>
			<TD><input type="Text" name="position_ar" size="20" value="<?php echo stripslashes($position_ar); ?>" /></TD>
			<TD><input type="Text" name="ord" size="20" value="<?php echo stripslashes($ord); ?>" /></TD>

			<TD><?php echo print_save_icon("Update"); ?></TD>
			<TD colspan="2">&nbsp;</TD>
		</TR>
   	<?}// Edit record
	else{?>
		<TR>
			<TD><?php echo lookupField('mem_council','id','name_en',$member_id); ?></TD>
			<TD><?php echo stripslashes($position_en); ?></TD>
			<TD><?php echo stripslashes($position_ar); ?></TD>
			<TD><?php echo stripslashes($ord); ?></TD>
			<?//=showUpDownIcons($result, $i, "id", "ord", "&term=".$term);?>
			<TD width="42" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?term=$term&action=Edit&id=".$id)?></TD>
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
<? include_once("../common/footer-admin.php"); ?>