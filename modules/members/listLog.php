<?
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

$sql = "SELECT * FROM log  order by datetime_stamp DESC ";
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
<th width="277"><?=print_AdminRecordHead("user", "User", $sb, $so)?></th>
<th width="277"><?=print_AdminRecordHead("ip", "IP", $sb, $so)?></th>
<th width="277"><?=print_AdminRecordHead("page", "Page", $sb, $so)?></th>
<th width="277"><?=print_AdminRecordHead("datetime_stamp", "Date", $sb, $so)?></th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$user= MYSQL_RESULT($result,$i,"user");
$page= MYSQL_RESULT($result,$i,"page");
$ip= MYSQL_RESULT($result,$i,"ip");
$datetime_stamp= MYSQL_RESULT($result,$i,"datetime_stamp");

?>
<TR>
<TD><?=stripslashes($user)?></TD>

<TD><?=stripslashes($ip)?></TD>
<TD><?=stripslashes($page)?></TD>
<TD><?=stripslashes($datetime_stamp)?></TD>
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
