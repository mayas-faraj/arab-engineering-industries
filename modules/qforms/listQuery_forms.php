<?
include_once("../common/header-admin.php");

/***********Print Header*************/
print_GridAdminHead("Forms", "Forms", 1, 1, 1, 1);
echo create_lang_switcher($lang);

$action = $_REQUEST['action'];
if($action=="Insert"){
$form_name = addslashes($_REQUEST['form_name']);
$send_mail_to = addslashes($_REQUEST['send_mail_to']);
$cols = "form_name , send_mail_to";
$values = "'$form_name' , '$send_mail_to' ";
$lang = addslashes($_REQUEST['lang']);
$cols .= " , lang";	$values .= ", '$lang' ";
$SQL = "INSERT INTO query_forms ( $cols ) VALUES ( $values )";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
if($action=="Update"){
$form_id = addslashes($_REQUEST['form_id']);
$form_name = addslashes($_REQUEST['form_name']);
$send_mail_to = addslashes($_REQUEST['send_mail_to']);
$values = "form_name = '$form_name' , send_mail_to = '$send_mail_to'";
$lang = addslashes($_REQUEST['lang']);
$values .= " , lang = '$lang' ";
$SQL = "UPDATE query_forms SET $values WHERE form_id = '$form_id' ";
$result = mysql_query($SQL);
if($result)
echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
if($action=="Delete"){
if(isset($_POST['rid'])){
$array = $_POST['rid'];
$ids = implode(",",$array);
deleteRecord("query_forms","form_id in ($ids)",true);
deleteRecord("form_fields","form_id in ($ids)",true);
}
}// Delete record


/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY form_id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$whereStmt = createFilter(array('name'), array('%form_name'), "AND");

/***********Query*************/
$static_filtering = "lang='$lang'";
if($static_filtering != ""){
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt AND $static_filtering";
else	$whereStmt = " WHERE $static_filtering";
}
else{
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";
}

$sql = "SELECT * FROM query_forms $whereStmt $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("query_forms", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);
?>
<div class="main">
<form method='post' name='subForm' action='<?php echo $_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='ids' value=''>
<input type="Hidden" name="form_id" size="20" value="<?php echo $_REQUEST['form_id']?>" />
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<TR>
<th><?php echo print_AdminRecordHead("form_name", "Form Name", $sb, $so); ?></th>
<th><?php echo print_AdminRecordHead("send_mail_to", "Send Mail To", $sb, $so); ?></th>
<?
?>
<th><?php echo print_AdminRecordHead("lang", "Lang", $sb, $so); ?></th>
<?
?>
<th colspan="4">&nbsp;</th>
</TR>
</thead>
<tbody><?php
if($action=="Enter"){ ?>
<TR>
<TD><input type="Text" name="form_name" size="20" value="<?php echo stripslashes($form_name)?>" /></TD>
<TD><input type="Text" name="send_mail_to" size="20" value="<?php echo stripslashes($send_mail_to)?>" /></TD>
<?
?>
<TD><?php echo createComboBox("languages" , "lang", "lang_name" , $lang , "lang");?></TD>
<?
?>
<TD>&nbsp;</TD>
<TD><?php echo print_save_icon("Insert"); ?></TD>
<TD colspan="2">&nbsp;</TD>
</TR><?php
}// Enter record
$i=0;
while ($i<$numberOfRows){
$form_id= MYSQL_RESULT($result,$i,"form_id");
$form_name= MYSQL_RESULT($result,$i,"form_name");
$send_mail_to= MYSQL_RESULT($result,$i,"send_mail_to");
$lang= MYSQL_RESULT($result,$i,"lang");
if($action=="Edit"  && $_REQUEST['form_id'] == $form_id){?>
<TR>
<TD><input type="Text" name="form_name" size="20" value="<?php echo stripslashes($form_name)?>" /></TD>
<TD><input type="Text" name="send_mail_to" size="20" value="<?php echo stripslashes($send_mail_to)?>" /></TD>
<?
?>
<TD><?php echo createComboBox("languages" , "lang", "lang_name" , $lang , "lang");?></TD>
<?
?>
<TD>&nbsp;</TD>
<TD><?php echo print_save_icon("Update"); ?></TD>
<TD colspan="2">&nbsp;</TD>
</TR><?
}else{?>
<TR>
<TD width="196"><?php echo stripslashes($form_name)?></TD>
<TD width="261"><?php echo stripslashes($send_mail_to)?></TD>
<?
?>
<TD width="193"><?php echo stripslashes($lang)?></TD>
<?
?>
<TD width="299" align="center"><a href="listForm_fields.php?form_id=<?php echo $form_id?>"><?php echo Form_fields?></a></TD>
<TD width="42" align="center"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&form_id=".$form_id)?></TD>
<TD align="center" WIDTH="42"><?=print_view_icon(_PREF."view/forms/viewForm.php?id=".$form_id);?></TD>
<TD width="29" align="center"><?php echo print_delete_ckbox($form_id); ?></TD>
</TR><?
}//end else
$i++;
}//End While
?>
</tbody>
</TABLE>
</form>
</div>
<script>
function actionf(act){
subForm.action.value = act;
subForm.submit();
}
</script>
<?php include_once("../common/footer-admin.php"); ?>
