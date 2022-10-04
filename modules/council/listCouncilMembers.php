<?php
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("BOD","",  "enterNewCouncilMember.php",0, 1);
/***********Delete Option:*************/
$id =  $_REQUEST['id'];
$term =  $_REQUEST['term'];
if($_REQUEST['sub'] == "del")
deleteRecord("mem_council","id = '$id'",true);

$member_ids = returnImplode_ids('term_members'," term_id = $term ",'member_id');
//$staticStmt = " WHERE id in($member_ids)";


/**Update order********************************************/

changeOrder("mem_council", "id", "ord", getNewItemOrder("mem_council", "ord", $staticStmt));

//---------------------------------------------------------------------------------


/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY ord DESC":$sort ;
if( !isset($sb) )	$sb="ord";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'name'; $fields[] = '%name_en';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

$u_stmt = "";
if($_SESSION['USER'] != 2){
	if($whereStmt)	$u_stmt = " AND ";
	else 	$u_stmt = " WHERE ";
	$u_stmt .= "(creator_id = '".$_SESSION['USER']."')";
}


/***********Query*************/

if($whereStmt!="")	$whereStmt = " WHERE  $whereStmt";
//else $whereStmt = " $staticStmt ";
$sql = "SELECT * FROM mem_council  $whereStmt $u_stmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("mem_council", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
echo "<div class='pagination'style=' height:20px; margin-top:9px;'>".print_seo_icon("viewAllBod.php")."</div>";

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?php echo print_AdminRecordHead("name_en", "Name", $sb, $so); ?></th>
<?php
?>
<th width="277"><?php echo print_AdminRecordHead("position_en", "Position", $sb, $so); ?></th>
<?php
?>
<th width="277"><?php echo print_AdminRecordHead("company_en", "Company", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("creator_id", "Creator", $sb, $so); ?></th>

<th colspan="3">Controls</th>
</tr>
</thead>
<tbody>
<?php
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$name_en= MYSQL_RESULT($result,$i,"name_en");
$name_ar= MYSQL_RESULT($result,$i,"name_ar");
$position_en= MYSQL_RESULT($result,$i,"position_en");
$position_ar= MYSQL_RESULT($result,$i,"position_ar");
$company_en= MYSQL_RESULT($result,$i,"company_en");
$active= MYSQL_RESULT($result,$i,"active");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
$ord= MYSQL_RESULT($result,$i,"ord");
?>
<TR>
<TD><?php echo stripslashes($name_en); ?><br/><?php echo stripslashes($name_ar); ?></TD>
<?php
?>
<TD><?php echo stripslashes($position_en); ?><br/><?php echo stripslashes($position_ar); ?></TD>
<?php
?>
<TD><?php echo $company_en; ?></TD>

<TD><?php echo lookupField("users", "user_id", "username", $creator_id); ?></TD>
<td><a href="../includes/checkbox.php?t=mem_council&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>


<?//=showUpDownIcons($result, $i, "id", "ord", "&term=".$term);?>
<TD align="center" WIDTH="42"><?php echo print_edit_icon("editCouncil.php?cat_id=$cat_id&id=".$id."&term=".$term);?></TD>
<TD align="center" WIDTH="42"><?php echo print_delete_icon("?id=".$id."&sub=del&sub=del");?></TD>
</TR>
<?$i++;
}//End While?>
</tbody>
</TABLE>

<?php
/***********Bottom pagination*************/
echo createPagination($tp,$pn,$LPP);
?><br/><?php
}?>
<br/><br/>
<?php
include_once("../common/footer-admin.php"); ?>
