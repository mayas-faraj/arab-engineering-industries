<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("Highlight", "Highlight", "enterNewHighlight.php", 1);

/***********Default Sorting Option*************/
$sb="item_order";
$sort  = "ORDER BY $sb $so";


/**Ordering_functions(part 1 of 2)********************************************/
//define ordering cretiria:
function getNewHighlightOrder(){
$lang = $_SESSION['lang'];
return getNewItemOrder("highlight_highlight", "item_order", "");
}
//apply updating:
changeOrder("highlight_highlight", "id", "item_order", getNewHighlightOrder());
$action = $_REQUEST['action'];
if($action=="Insert")	$item_order = getNewHighlightOrder();
$static_order = 1;
//---------------------------------------------------------------------------------


/***********Delete Option:*************/
/**delete_grp_functions(part 1 of 2)********************************************/
?>
<script>
function actionf(act){
main.action.value = act;
main.submit();
}
</script>
<?
$action = $_REQUEST['action'];
if($action=="Delete"){
$array = $_POST['rid'];
$ids = implode(",", $array);
deleteRecord("highlight_highlight","id in ($ids)",true);
}
/***********Filtering Option*************/
$filters = array(); $fields = array();
$field = '%title';
$field .= (($field!='')?"|":"").'%link';
if($field){
$filters[] = 'Name'; $fields[] = $field;
}
$whereStmt = createFilter( $filters , $fields , "AND");

/***********Query*************/
//$static_filtering = "lang='$lang'";
if($static_filtering != ""){
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt AND $static_filtering";
else	$whereStmt = " WHERE $static_filtering";
}
else{
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";
}
$sql = "SELECT * FROM highlight_highlight  $whereStmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("highlight_highlight", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);
/***********Print Result*************/
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div>";
if ($numberOfRows>0) {
$i=0;?>

<div class="data">
<form method='post' name='main' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("photo_en", "Photo", $sb, $so, $static_order); ?></th>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("link_en", "Link", $sb, $so, $static_order); ?></th>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("title_en", "Title", $sb, $so, $static_order); ?></th>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>

<th colspan="4">Controls</th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id = MYSQL_RESULT($result,$i,"id");
$photo_en = MYSQL_RESULT($result,$i,"photo_en");
$link_en = MYSQL_RESULT($result,$i,"link_en");
$title_en = MYSQL_RESULT($result,$i,"title_en");
$ord = mysql_result($result,$i,"item_order");
$active = mysql_result($result,$i,"active");
?>


<TR>
<?
?>
<td><? if($photo_en!=""){?><img src="<?php echo resizeToFile('../../uploads/'.($photo_en),100,100,'../../uploads/mcith/mcith_'.basename($photo_en)); ?>"><? }else echo "&nbsp;"?></td>
<?
?>
<td>&nbsp;<?php echo stripslashes($link_en)?>&nbsp;</td>
<?
?>
<td>&nbsp;<?php echo stripslashes($title_en)?></td>
<?
?>
<td><a href="../includes/checkbox.php?t=highlight_highlight&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>


<TD align="center" WIDTH="42"><?=print_edit_icon("editHighlight.php?id=".$id);?></TD>
<?
/**Ordering_functions(part 2 of 2)********************************************/
showUpDownIcons($result, $i, "id", "item_order", "");
/**Ordering_functions********************************************/
?>
<?/**delete_grp_functions(part 1 of 2)********************************************/?>



<TD width="29" align="center"><?=($is_static == 0)? print_delete_ckbox($id):print_delete_ckbox()?></TD>
<?//-------------------------------------------------------?>
</TR>
<?$i++;
}//End While?>
</tbody>
</TABLE>
</form></div>
<?
/***********Bottom pagination*************/
echo createPagination($tp,$pn,$LPP);
}
include_once("../common/footer-admin.php"); ?>
