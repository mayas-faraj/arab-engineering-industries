<?php
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("Announcements", "Announcements", "enterNewNews.php?$url", 1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del"){
	deleteRecord("news_news","id = '$id'",true);
	@mysqli_query($GLOBALS["db_link_conn"], " DELETE FROM `highlight` WHERE table_name = 'news_news' AND record_id='$id'");
}


/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'subject'; $fields[] = '%subject';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);




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
	$u_stmt = " $u_stmt (creator_id = '".$_SESSION['USER']."')";
}
$sql = "SELECT * FROM news_news  $whereStmt $u_stmt $sort $limit ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);

/***********Top pagination*************/
$tp = count_items("news_news", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
echo "<div class='pagination'style=' height:20px; margin-top:9px;'>".print_seo_icon("viewAnnouncements.php")."</div>";

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?php echo print_AdminRecordHead("subject", "Subject", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("publish_date", "Publish Date", $sb, $so); ?></th>

<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>
<?if($_SESSION['USER'] == 2){?>
<th width="277"><?php echo print_AdminRecordHead("special", "special", $sb, $so); ?></th>
<?}?>

<th colspan="4">Controls  </th>
</tr>
</thead>
<tbody>
<?php
while ($i<$numberOfRows){
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$subject = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"subject");
$publish_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"publish_date");
$special= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"special");
$active= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"active");
?>
<TR>
<TD><?php echo stripslashes($subject); ?></TD>

<TD><?php echo stripslashes($publish_date); ?></TD>
<?php
?>


<td><a href="../includes/checkbox.php?t=news_news&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
<?if($_SESSION['USER'] == 2){?>
<td><a href="../includes/checkbox.php?t=news_news&fn=special&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($special); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $special?>_.png" border="0"  fv="<?php echo !($special); ?>"/></a></td>
<?}?>
<td align="center" width="30"><?php echo print_seo_icon("viewAnnounceDetails.php?id=".$id);?></td>
<TD align="center" WIDTH="42"><?php echo print_edit_icon("editNews.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?php echo print_delete_icon("?id=".$id."&sub=del");?></TD>
<TD align="center" WIDTH="42"><?php echo print_view_icon("../../view/Anouncements/viewAnnounceDetails.php?id=".$id);?></TD>
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
