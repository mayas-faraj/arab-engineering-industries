<?php include_once("../common/header-admin.php"); ?>
<?php
$sub =  $_GET['sub'];


/***********Print Header*************/
print_ListAdminHead("Gallery", "Gallery", 'javascript:winopen("../includes/gallery/addGallery.php",850,480)', 1);

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
$isGallery =  $_REQUEST['isGallery'];

changeOrder("galleries_galleries", "id", "ord", getNewItemOrder("galleries_galleries", "ord", " isGallery = $isGallery "));

if($_REQUEST['sub'] == "del")
deleteRecord("galleries_galleries","id = '$id'",true);

/***********Default Sorting Option*************/
//$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$whereStmt = createFilter(array('gallery_name'), array('%gallery_name'), "AND");
if($_SESSION['USER']!=2){
	$staticStm = " creator_id = ".$_SESSION['USER'];
}else{
	$staticStm = " 1 = 1";
}

/***********Query*************/

if($whereStmt!=""){	$whereStmt = " WHERE $whereStmt AND $staticStm ";}else{	$whereStmt = " WHERE $staticStm ";}

$sql = "SELECT * FROM galleries_galleries  $whereStmt order by isGallery DESC, ord DESC $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
/***********Top pagination*************/
$tp = count_items("galleries_galleries", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div>";
if ($numberOfRows>0) {
$i=0;?>

<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list"><thead>
<TR>
<tr>
<th width="277"><?php echo print_AdminRecordHead("gallery_name_en", "Gallery name", $sb, $so); ?></th>
<th width="277"><?php echo print_AdminRecordHead("main_phto", "Main photo", $sb, $so); ?></th>
<th width="277"><?php echo print_AdminRecordHead("isGallery", "Is Gallery?", $sb, $so)?></th>
<th colspan="4">Controls  </th>
</tr>
</TR>
</thead><tbody><?php
while ($i<$numberOfRows){
$id= mysql_result($result,$i,"id");
$gallery_name= mysql_result($result,$i,"gallery_name");
$description= mysql_result($result,$i,"description");
$main_photo= mysql_result($result,$i,"main_photo");
$folder= mysql_result($result,$i,"folder");
$photos= mysql_result($result,$i,"photos");
$isGallery= mysql_result($result,$i,"isGallery");
?>
<TR>
<input type='hidden' value='<?php echo $isGallery; ?>' name='isGallery'/>
<TD><?php echo stripslashes($gallery_name); ?></TD>
<td><?php echo  lookupGallery($id); ?></td>
<TD><a href="../includes/checkbox.php?t=galleries_galleries&fn=isGallery&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($isGallery); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $isGallery?>_.png" border="0"  fv="<?php echo !($isGallery); ?>"/></a></TD>
<?php echo showUpDownIcons($result, $i, "id", "ord", "&term=".$term);; ?>
<TD align="center" WIDTH="42"><?php echo print_edit_icon("javascript:winopen('../includes/gallery/editGallery.php?gid=$id',850,480)");?></TD>
<TD align="center" WIDTH="42"><?php echo print_delete_icon("?id=".$id."&sub=del");?></TD>
</TR>
<?php
$i++;
}//End While?>
</tbody>
</TABLE>

<?php
/***********Bottom pagination*************/
echo createPagination($tp,$pn,$LPP);

}
include_once("../common/footer-admin.php"); ?>
