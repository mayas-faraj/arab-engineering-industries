<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("FYI", "FYI", "enterNewResource.php?$url", 1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del"){
	deleteRecord("resources","id = '$id'",true);
	@mysql_query(" DELETE FROM `highlight` WHERE table_name = 'resources' AND record_id='$id'");
}

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'keyword'; $fields[] = '%keyword';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

echo create_lang_switcher($lang);


/***********Query*************/
$static_filtering = "lang='$lang'";
if($static_filtering != ""){
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt AND $static_filtering";
else	$whereStmt = " WHERE $static_filtering";
}
else{
if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";
}
	
$sql = "SELECT * FROM resources  $whereStmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("resources", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?=print_AdminRecordHead("title", "Title", $sb, $so)?></th>
<?if($_SESSION['USER'] == 2){?>
	<th width="277"><?=print_AdminRecordHead("special", "special", $sb, $so)?></th>
<?}?>
<th colspan="4">Controls  </th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$title= MYSQL_RESULT($result,$i,"title");
$special= MYSQL_RESULT($result,$i,"special");
?>
<TR>
<TD><?=stripslashes($title)?></TD>
<?if($_SESSION['USER'] == 2){?>
	<td><a href="../includes/checkbox.php?t=resources&fn=special&idn=id&idv=<?=$id?>&fv=<?=!($special)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $special?>_.png" border="0"  fv="<?=!($special)?>"/></a></td>
<?}?>
<TD align="center" WIDTH="42"><?=print_edit_icon("editResource.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?=print_delete_icon("?id=".$id."&sub=del");?></TD>
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
