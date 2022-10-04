<?php 
include_once("../common/header-admin.php");


$art_id = $_REQUEST['art_id'];
	
/***********Print Header*************/
print_ListAdminHead("Discussions Comments", "Discussions Comments", "", 0);




changeOrder("art_comments", "id", "ord", getNewItemOrder("art_comments", "ord", "art_id = '$art_id'"));

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del")
	deleteRecord("art_comments","id = '$id'",false);

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY ord $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'title'; $fields[] = '%title';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

/***********Query*************/

if($whereStmt!=""){	$whereStmt = " WHERE art_id='$art_id' $whereStmt";}else{	$whereStmt = " WHERE art_id='$art_id' ";}

$sql = "SELECT * FROM art_comments  $whereStmt $sort $limit ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);

/***********Top pagination*************/
$tp = count_items("art_comments", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
	echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/	
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div>";
if ($numberOfRows>0) {
	$i=0;?>
   <TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
   <thead>
	<tr>
		<th width="277"><?php echo print_AdminRecordHead("art_id", "Article_id", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("pub_name", "Publisher name", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("pub_email", "Publisher email", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("publish_date", "Publish Date", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("comment", "comment", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("active", "Active", $sb, $so); ?></th>
		<th colspan="2">Controls  </th>
	</tr>
	</thead>
	<tbody>
	<?php
    while ($i<$numberOfRows){
        $id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
        $art_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"art_id");
        $article= lookupField('art_articles','id','title',$art_id);
        $comment= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"comment");
        
		$u_id =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"user_id");
		$pub_name = lookupField('users','user_id','full_name',$u_id);
		$pub_email = lookupField('users','user_id','email',$u_id);

        $publish_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"publish_date");
        $active= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"active");
		$ord = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"ord");
        ?>
		<TR>
			<TD><?php echo stripslashes($article); ?></TD>
			<TD><?php echo stripslashes($pub_name); ?></TD>
			<TD><?php echo stripslashes($pub_email); ?></TD>
			<TD><?php echo stripslashes($publish_date); ?></TD>
			<TD><?php echo stripslashes($comment); ?></TD>
			<td><a href="../includes/checkbox.php?t=art_comments&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
			<?//=showUpDownIcons($result, $i, "id", "ord", " art_id=$art_id ");?>
			<TD align="center" WIDTH="42"><?php echo print_edit_icon("editArticlesComments.php?id=".$id);?></TD>
			<TD align="center" WIDTH="42"><?php echo print_delete_icon("?id=".$id."&sub=del&art_id=$art_id");?></TD>
        </TR>
		<?$i++;
    }//End While?>
    </tbody>
	</TABLE>
	</form>
	
	
	<?php
	/***********Bottom pagination*************/
	echo createPagination($tp,$pn,$LPP);
	
}
include_once("../common/footer-admin.php"); ?>