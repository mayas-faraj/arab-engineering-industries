<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("Pages", "Pages", "enterNewPages.php", 1);
echo create_lang_switcher($lang);
/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY is_static DESC,$sb $so";
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
deleteRecord("pages","id in ($ids)",true);
}
/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'page_title'; $fields[] = '%title';
$whereStmt = createFilter( $filters , $fields , "AND");

/***********Query*************/
$static_filtering = "lang='$lang'";
if($static_filtering != ""){
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt AND $static_filtering";
else	$whereStmt = " WHERE $static_filtering";
}
else{
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";
}
$sql = "SELECT * FROM pages  $whereStmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("pages", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div>";
if ($numberOfRows>0) {
$i=0;?>

<div class="data">
<form method='post' name='main' action='<?=$_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?=print_AdminRecordHead("title", "Title", $sb, $so)?></th>
<?
?>
<th width="277"><?=print_AdminRecordHead("lang", "Language", $sb, $so)?></th>
<?
?>
<th colspan="5">Controls</th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$title= MYSQL_RESULT($result,$i,"title");
$is_static= MYSQL_RESULT($result,$i,"is_static");
$lang= MYSQL_RESULT($result,$i,"lang");
?>
<TR>
<TD><?=stripslashes($title)?>&nbsp;</TD>
<?
?>
<TD><?=stripslashes($lang)?>&nbsp;</TD>

<?
?>
<td align="center" width="30"><?=print_seo_icon("page.php?id=".$id,$lang);?></td>
<TD align="center" WIDTH="42"><?=print_edit_icon("editPages.php?id=".$id);?></TD>
<TD align="center" WIDTH="42"><?=print_view_icon(_PREF."view/page/page.php?id=".$id);?></TD>
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
