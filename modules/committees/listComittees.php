<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("Committees","","enterNewComittee.php", 0,1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del")
deleteRecord("mem_committees","id = '$id'",true);

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'name_en'; $fields[] = '%name_en';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);


/***********Query*************/

if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";

$u_stmt = "";
if($_SESSION['USER'] != 2){
	if($whereStmt)	$u_stmt = " AND ";
	else 	$u_stmt = " WHERE ";
	$u_stmt .= "(creator_id = '".$_SESSION['USER']."')";
}

$sql = "SELECT * FROM mem_committees  $whereStmt $u_stmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("mem_committees", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
echo "<div class='pagination'style=' height:20px; margin-top:9px;'>".print_seo_icon("viewAllCommittees.php")."</div>";
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<th width="277"><?php echo print_AdminRecordHead("name_en", "Name", $sb, $so); ?></th>
<?
?>
<th width="277"><?php echo print_AdminRecordHead("creation_date", "Creation Date", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("creator_id", "Creator", $sb, $so); ?></th>

<?
?>
<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>
<?
?>
<th colspan="4">Controls  </th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$name_en= MYSQL_RESULT($result,$i,"name_en");
$name_ar= MYSQL_RESULT($result,$i,"name_ar");
$creation_date= MYSQL_RESULT($result,$i,"creation_date");
//$major= MYSQL_RESULT($result,$i,"major");
$active= MYSQL_RESULT($result,$i,"active");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
?>
<TR>
<TD><?php echo stripslashes($name_ar); ?><br/><?php echo stripslashes($name_en); ?></TD>
<?
?>
<TD><?php echo stripslashes($creation_date); ?></TD>

<TD><?php echo lookupField("users", "user_id", "username", $creator_id); ?></TD>
<?
?>
<td><a href="../includes/checkbox.php?t=mem_committees&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
<?
?>
<td align="center" width="30"></td>
<TD align="center" WIDTH="42"><?=print_edit_icon("editComittee.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?=print_delete_icon("?id=".$id."&sub=del");?></TD>
<TD align="center" WIDTH="42"></TD>
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
