<? 
include_once("../common/header-admin.php");


$cat_id = $_REQUEST['cat_id'];
	
/***********Print Header*************/
print_ListAdminHead("Discussions", "Discussions", "enterNewArticles.php", 0);

/*******Page Languages switcher******/



changeOrder("art_articles", "id", "ord", getNewItemOrder("art_articles", "ord", ""));

/***********Delete Option:*************/
$id =  $_REQUEST['id'];
if($_REQUEST['sub'] == "del"){
	deleteRecord("art_articles","id = '$id'",true);
	deleteRecord("art_comments"," art_id = '$id'",false);
}
	

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id $so":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
$filters = array(); $fields = array();
$filters[] = 'title'; $fields[] = '%title';

$whereStmt = createFilter( $filters , $fields , "AND", $extention);

/***********Query*************/

if($whereStmt!=""){	$whereStmt = " WHERE cat_id = '$cat_id' $whereStmt";}else{	$whereStmt = " WHERE cat_id = '$cat_id' ";}

$sql = "SELECT * FROM art_articles  $whereStmt $sort $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

/***********Top pagination*************/
$tp = count_items("art_articles", str_replace("WHERE", "", $whereStmt));
if($tp!=0)
	echo createPagination($tp,$pn,$LPP);

/***********Print Result*************/	
if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div>";
if ($numberOfRows>0) {
	$i=0;?>
   <TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
   <thead>
	<tr>
		<th width="277"><?php echo print_AdminRecordHead("title", "Title", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("author", "Author", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("publish_date", "Publish Date", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("active", "Show", $sb, $so); ?></th>
		<th width="277"><?php echo print_AdminRecordHead("publish", "Active", $sb, $so); ?></th>
		<th colspan="5">Controls  </th>
	</tr>
	</thead>
	<tbody>
	<?
    while ($i<$numberOfRows){
        $id= MYSQL_RESULT($result,$i,"id");
        $title= MYSQL_RESULT($result,$i,"title");
        $brief= MYSQL_RESULT($result,$i,"brief");
		$u_id = mysql_result($result, $i,"user_id");
		$author = lookupField('users','user_id','full_name',$u_id);
        $details= MYSQL_RESULT($result,$i,"details");
        $publish_date= MYSQL_RESULT($result,$i,"publish_date");
        $active= MYSQL_RESULT($result,$i,"active");
        $publish= MYSQL_RESULT($result,$i,"publish");
		$ord = mysql_result($result,$i,"ord");
        ?>
		<TR>
			<TD><?php echo stripslashes($title); ?></TD>
			<TD><?php echo stripslashes($author); ?></TD>
			<TD><?php echo stripslashes($publish_date); ?></TD>
			<td><a href="../includes/checkbox.php?t=art_articles&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
			<td><a href="../includes/checkbox.php?t=art_articles&fn=publish&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($publish); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $publish?>_.png" border="0"  fv="<?php echo !($publish); ?>"/></a></td>
			<?//=showUpDownIcons($result, $i, "id", "ord", "");?>
			<?
				$comment_count = mysql_result(mysql_query("SELECT count(*) FROM art_comments where art_id = '$id'"),0,'count(*)');
				if($comment_count>0){?>
					<td align="center" width="30"><a href="listArticlesComments.php?art_id=<?php echo $id; ?>">Comments(<?php echo $comment_count; ?>)</a></td>
				<?}else{?>
					<td align="center" width="30">No Comments</td>
				<?}?>
			
			<td align="center" width="30"><?=print_seo_icon("viewArticles.php?id=".$id);?></td>
			<TD align="center" WIDTH="42"><?=print_edit_icon("editArticles.php?id=".$id);?></TD>
			<TD align="center" WIDTH="42"><?=print_delete_icon("?id=".$id."&sub=del");?></TD>
        </TR>
		<?$i++;
    }//End While?>
    </tbody>
	</TABLE>
	
	<?
	/***********Bottom pagination*************/
	echo createPagination($tp,$pn,$LPP);
	
}?>

<input name="sub4" type="button" id="sub3" value="<?php echo Back; ?>" style='float:left; clear:both;' onClick=" document.location='listArticlesCat.php'">
<?include_once("../common/footer-admin.php"); ?>