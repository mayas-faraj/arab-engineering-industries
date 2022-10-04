<?php
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("AFEI Members","","enterNewMember.php", 0,1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del")
deleteRecord("mem_members","id = '$id'",true);

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'name_en'; $fields[] = '%name_en';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);


/***********Query*************/

$u_stmt = "";
if($_SESSION['USER'] != 2){
	if($whereStmt)	$u_stmt = " AND ";
	else 	$u_stmt = " WHERE ";
	$u_stmt .= "(creator_id = '".$_SESSION['USER']."')";
}

if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";

$sql = "SELECT * FROM mem_members  $whereStmt $u_stmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("mem_members", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
echo "<div class='pagination'style=' height:20px; margin-top:9px;'>".print_seo_icon("viewAllMembers.php")."</div>";

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?php echo print_AdminRecordHead("name_en", "Name", $sb, $so); ?></th>
<?php
?>
<th width="277"><?php echo print_AdminRecordHead("specialization", "Sub Sector", $sb, $so); ?></th>
<?php
?>
<th width="277"><?php echo print_AdminRecordHead("country", "Country", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("creator_id", "Creator", $sb, $so); ?></th>
<?php
?>
<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>
<?php
?>
<th colspan="4">Controls  </th>
</tr>
</thead>
<tbody>
<?php
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$name_en= MYSQL_RESULT($result,$i,"name_en");
$name_ar= MYSQL_RESULT($result,$i,"name_ar");
$country= MYSQL_RESULT($result,$i,"country");
$specialization= MYSQL_RESULT($result,$i,"specialization");
$active= MYSQL_RESULT($result,$i,"active");
$creator_id= MYSQL_RESULT($result,$i,"creator_id");
?>
<TR>
<TD><?php echo stripslashes($name_en); ?><br/><?php echo stripslashes($name_ar); ?></TD>
<?php
?>
<TD><?php echo lookupField('specialization','id','specialization_en',$specialization);; ?></TD>
<?php
?>
<TD><?php echo lookupField('country','id','country_en',$country);; ?></TD>

<TD><?php echo lookupField("users", "user_id", "username", $creator_id); ?></TD>
<?php
?>
<td><a href="../includes/checkbox.php?t=mem_members&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
<?php
?>
<td align="center" width="30"></td>
<TD align="center" WIDTH="42"><?php echo print_edit_icon("editMember.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?php echo print_delete_icon("?id=".$id."&sub=del");?></TD>
<TD align="center" WIDTH="42"></TD>
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
