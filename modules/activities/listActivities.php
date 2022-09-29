<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("Activities", "Activities", "enterNewActivity.php?$url", 1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del"){
	deleteRecord("mem_activities","id = '$id'",true);
	@mysql_query(" DELETE FROM `highlight` WHERE table_name = 'mem_activities' AND record_id='$id'");
}


/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'subject'; $fields[] = '%subject';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

//echo create_lang_switcher($lang);


/***********Query*************/
//$static_filtering = "lang='$lang'";
if($static_filtering != ""){
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt AND $static_filtering";
else	$whereStmt = " WHERE $static_filtering";
}
else{
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";
}


$u_stmt = "";
if($_SESSION['USER'] != 2){
	if($whereStmt)	$u_stmt = " AND ";
	else 	$u_stmt = " WHERE ";
	$u_stmt .= "(creator_id = '".$_SESSION['USER']."')";
}

	
$sql = "SELECT * FROM mem_activities  $whereStmt $u_stmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("mem_activities", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
echo "<div class='pagination'style=' height:20px; margin-top:9px;'>".print_seo_icon("viewAllActivities.php")."</div>";
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?php echo print_AdminRecordHead("subject", "Subject", $sb, $so); ?></th>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("activity_date", "Activity Date", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("creator_id", "Creator", $sb, $so); ?></th>

<?
?>
<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>
<?if($_SESSION['USER'] == 2){?>
	<th width="277"><?php echo print_AdminRecordHead("special", "Special", $sb, $so); ?></th>
<?}?>
<th colspan="5">Controls  </th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$subject= MYSQL_RESULT($result,$i,"subject");
$activity_date= MYSQL_RESULT($result,$i,"activity_date");
$special= MYSQL_RESULT($result,$i,"special");
$active= MYSQL_RESULT($result,$i,"active");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
?>
<TR>
<TD><?php echo stripslashes($subject); ?></TD>
<?
?>
<TD><?php echo stripslashes($activity_date); ?></TD>
<TD><?php echo lookupField("users", "user_id", "username", $creator_id); ?></TD>
<?
?>
<td><a href="../includes/checkbox.php?t=mem_activities&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
<?if($_SESSION['USER'] == 2){?>
<td><a href="../includes/checkbox.php?t=mem_activities&fn=special&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($special); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $special?>_.png" border="0"  fv="<?php echo !($special); ?>"/></a></td>
<?}?>
<?
?>
<TD align="center" WIDTH="42"><?=print_edit_icon("editActivity.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?=print_delete_icon("?id=".$id."&sub=del");?></TD>
<TD align="center" WIDTH="42"><?=print_seo_icon("viewActivities.php?id=".$id);?></TD>
</TR>
<?$i++;
}//End While?>
</tbody>
</TABLE>

<?
/***********Bottom pagination*************/
echo createPagination($tp,$pn,$LPP);
?><br/><?
}?>
<br/><br/>
<?
include_once("../common/footer-admin.php"); ?>
