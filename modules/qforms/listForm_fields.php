<?
include_once("../common/header-admin.php");

/***********Print Header*************/
print_GridAdminHead("Forms", "Forms", 1, 1, 1, 1);

$action = $_REQUEST['action'];
$form_id = $_REQUEST['form_id'];

/**Ordering_functions(part 1 of 2)********************************************/
//define ordering cretiria:
function getFieldsOrder(){
$form_id = $_REQUEST['form_id'];
$sql = "SELECT MAX(item_order) AS max FROM form_fields WHERE (form_id = '$form_id') ";
$result = mysql_query($sql);
if ($result) return $max = MYSQL_RESULT($result,0,'max')+1;
else return 1;
}
//apply updating:
changeOrder("form_fields", "id", "item_order", getFieldsOrder());
$action = $_REQUEST['action'];
if($action=="Insert")	$item_order = getFieldsOrder();
$static_order = 1;
//---------------------------------------------------------------------------------


if($action=="Insert"){
$field_label = addslashes($_REQUEST['field_label']);
$type = addslashes($_REQUEST['type']);
$plus = addslashes($_REQUEST['plus']);
$required = addslashes($_REQUEST['required']);
$form_id = addslashes($_REQUEST['form_id']);
$SQL = "INSERT INTO form_fields (field_label , type , plus , required , form_id ,item_order) VALUES ('$field_label' , '$type' , '$plus' , '$required' , '$form_id' , ' $item_order' )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
if($action=="Update"){
$id = addslashes($_REQUEST['id']);
$field_label = addslashes($_REQUEST['field_label']);
$type = addslashes($_REQUEST['type']);
$plus = addslashes($_REQUEST['plus']);
$required = addslashes($_REQUEST['required']);
$form_id = addslashes($_REQUEST['form_id']);
$SQL = "UPDATE form_fields SET field_label = '$field_label' , type = '$type' , plus = '$plus' , required = '$required' , form_id = '$form_id' WHERE id = '$id' ";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
if($action=="Delete"){
if(isset($_POST['rid'])){
$array = $_POST['rid'];
$ids = implode(",",$array);
deleteRecord("form_fields","id in ($ids)",true);
}
}// Delete record

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$whereStmt = createFilter(array('Field'), array('%field_label'), "AND");


/***********Query*************/
if($whereStmt!="")	$whereStmt = " AND $whereStmt";
$sql = "SELECT * FROM form_fields WHERE (form_id = '$form_id') $whereStmt ORDER BY item_order ASC ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("form_fields", str_replace("AND", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);
?>
<div class="main">
<form method='post' name='subForm' action='<?php echo $_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='ids' value=''>
<input type='hidden' name='id' value='<?php echo $_REQUEST['id']; ?>'>
<input type="Hidden" name="form_id" size="20" value="<?php echo $form_id?>" />
<input type="hidden" value="<?php echo $form_id?>" name="form_id" />
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
<thead>
<TR>
<th width="100px;"><?php echo print_AdminRecordHead("field_label", "Field Label", $sb, $so, $static_order); ?></th>
<th width="100px;"><?php echo print_AdminRecordHead("type", "Type", $sb, $so, $static_order); ?></th>
<th width="100px;"><?php echo print_AdminRecordHead("plus", "Plus", $sb, $so, $static_order); ?></th>
<th width="100px;"><?php echo print_AdminRecordHead("required", "Required", $sb, $so, $static_order); ?></th>
<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody><?
if($action=="Enter"){?>
<TR>
<TD><input type="Text" name="field_label" size="20" value="<?php echo stripslashes($field_label)?>" /></TD>
<TD>
<select name="type">
<option value="Label" <?=($type=='Label')? "selected" : "" ?>> Label</option>
<option value="Field" <?=($type=='Field')? "selected" : "" ?>> Text Field</option>
<option value="Email" <?=($type=='Email')? "selected" : "" ?>> E-mail</option>
<option value="Area"  <?=($type=='Area') ? "selected" : "" ?>> Text Area</option>
<option value="List"  <?=($type=='List') ? "selected" : "" ?>> List</option>
<option value="Checkbox" <?=($type=='Checkbox') ? "selected" : "" ?>> Checkbox</option>
</select>
</TD>
<TD><input type="Text" name="plus" size="20" value="<?php echo stripslashes($plus)?>" /></TD>
<TD><input type="Checkbox" name="required" size="20" value="1" <?php echo ($required)? "checked" : ""?>  /></TD>
<TD colspan="4"><?php echo print_save_icon("Insert"); ?></TD>
</TR><?php
}// Enter record
$i=0;
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$field_label= MYSQL_RESULT($result,$i,"field_label");
$type= MYSQL_RESULT($result,$i,"type");
$plus= MYSQL_RESULT($result,$i,"plus");
$required= MYSQL_RESULT($result,$i,"required");
$form_id= MYSQL_RESULT($result,$i,"form_id");
$order= MYSQL_RESULT($result,$i,"item_order");
if($action=="Edit"  && $_REQUEST['id'] == $id){?>
<TR>
<TD>&nbsp;<input type="Hidden" name="id" size="20" value="<?php echo $id?>" />
<input type="Text" name="field_label" size="20" value="<?php echo stripslashes($field_label)?>" /></TD>
<TD>
<select name="type">
<option value="Label" <?=($type=='Label')? "selected" : "" ?>> Label</option>
<option value="Field" <?=($type=='Field')? "selected" : "" ?>> Text Field</option>
<option value="Email" <?=($type=='Email')? "selected" : "" ?>> E-mail</option>
<option value="Area"  <?=($type=='Area') ? "selected" : "" ?>> Text Area</option>
<option value="List"  <?=($type=='List') ? "selected" : "" ?>> List</option>
<option value="Checkbox" <?=($type=='Checkbox') ? "selected" : "" ?>> Checkbox</option>
</select>
</TD>
<TD><input type="Text" name="plus" size="20" value="<?php echo stripslashes($plus)?>" /></TD>
<TD><input type="Checkbox" name="required" size="20" value="1" <?php echo ($required)? "checked" : ""?>  /></TD>
<TD colspan="4"><?php echo print_save_icon("Update"); ?></TD>
</TR><?php
}else{?>
<TR>
<TD><?php echo stripslashes($field_label)?></TD>
<TD><?php echo stripslashes($type)?></TD>
<TD>&nbsp;<?php echo stripslashes($plus)?></TD>
<td><a href="../includes/checkbox.php?t=form_fields&fn=required&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($required); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $required?>_.png" border="0"  fv="<?php echo !($required); ?>"/></a></td>
<?
/**Ordering_functions(part 2 of 2)********************************************/
showUpDownIcons($result, $i, "id", "item_order", "&form_id=".$form_id);
/**Ordering_functions********************************************/
?>
<TD width="42" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id."&form_id=".$form_id)?></TD>
<TD width="29" align="center"><?php echo print_delete_ckbox($id); ?></TD>
</TR>
<?php
}//end else
$i++;
}//End While
?>
</tbody></TABLE>
</div>
<div align="CENTER">
<input type="button" value="<?php echo _GoBack?>" onClick="document.location='listQuery_forms.php?form_id=<?php echo $form_id?>';" />
</div></form>
<script>
function actionf(act){
subForm.action.value = act;
subForm.submit();
}
</script>
<?php include_once("../common/footer-admin.php"); ?>
