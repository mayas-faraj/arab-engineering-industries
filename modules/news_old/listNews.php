<?
include_once("../common/header-admin.php");
/***********Print Header*************/
print_ListAdminHead("News", "News", "enterNewNews.php?$url", 1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del")
deleteRecord("news_news","id = '$id'",true);

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'subject'; $fields[] = '%subject';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

echo create_lang_switcher($lang);


/***********Query*************/

if($whereStmt!="")	$whereStmt = " WHERE $whereStmt";

$sql = "SELECT * FROM news_news  $whereStmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("news_news", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?=print_AdminRecordHead("subject", "Subject", $sb, $so)?></th>
<?
?>
<th width="277"><?=print_AdminRecordHead("publish_date", "Publish Date", $sb, $so)?></th>
<?
?>
<th width="277"><?=print_AdminRecordHead("special", "Special", $sb, $so)?></th>
<?
?>
<th width="277"><?=print_AdminRecordHead("active", "Active", $sb, $so)?></th>
<?
?>
<th colspan="4">Controls  </th>
</tr>
</thead>
<tbody>
<?
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$subject= MYSQL_RESULT($result,$i,"subject");
$publish_date= MYSQL_RESULT($result,$i,"publish_date");
$special= MYSQL_RESULT($result,$i,"special");
$active= MYSQL_RESULT($result,$i,"active");
?>
<TR>
<TD><?=stripslashes($subject)?></TD>
<?
?>
<TD><?=stripslashes($publish_date)?></TD>
<?
?>
<td><a href="../includes/checkbox.php?t=news_news&fn=special&idn=id&idv=<?=$id?>&fv=<?=!($special)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $special?>_.png" border="0"  fv="<?=!($special)?>"/></a></td>
<?
?>
<td><a href="../includes/checkbox.php?t=news_news&fn=active&idn=id&idv=<?=$id?>&fv=<?=!($active)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?=!($active)?>"/></a></td>
<?
?>
<td align="center" width="30"><?=print_seo_icon("viewNews.php?id=".$id);?></td>
<TD align="center" WIDTH="42"><?=print_edit_icon("editNews.php?cat_id=$cat_id&id=".$id);?></TD>
<TD align="center" WIDTH="42"><?=print_delete_icon("?id=".$id."&sub=del");?></TD>
<TD align="center" WIDTH="42"><?=print_view_icon("viewNews.php?id=".$id);?></TD>
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
