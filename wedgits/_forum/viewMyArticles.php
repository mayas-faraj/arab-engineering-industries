<?php if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} ?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">
	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
	$publish = lookupField('art_categories','id','publish',$_REQUEST['cat_id']);?>

	<div class="title2"><?php echo MyAricles; ?> <span><?echo Welcome.' <font><a href="viewForumMember.php?mem_id='.$_SESSION["us_id"].'&id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font>'?></span></div>
	<?if($publish){?>
		<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/addArticle.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/addArticle.png'/><?//=AddArticle?></a> </div>
		<div class="add_link">&nbsp;</div>
	<?}?>			
	<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/myPage.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/myPage.png'/><?//=MyAricles?></a></div>
	<div class="add_link">&nbsp;</div>
	<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/changePass.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/changePass.png'/><?//=changePass?></a></div>


	
<?php
	$user_id = $_SESSION["us_id"];
	if($_REQUEST['pn'])	$pn = $_REQUEST['pn'];
	$LPP = 20;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";

	/***********Default Sorting Option*************/
	$sb = $_REQUEST['sb'];
	$so = $_REQUEST['so'];
	if( !$sb )	$sb="publish_date";
	if( !$so )	$so="DESC";
	$sort  = ($sort=="")?"ORDER BY publish_date $so":$sort ;
	if($so=='DESC'){
		$soo="ASC";
	}else{
		$soo="DESC";
	}
	
	
	$grp_ids = returnImplode_ids('forum_users_groups'," user_id = '".$_SESSION["us_id"]."' ",'grp_id');
	$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
	$whereStmt = "WHERE (publish_date <= date(now())) and  active='1'  and user_id = '$user_id'";
	$sql =  "SELECT * FROM art_articles $whereStmt $sort  $limit";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numrows = mysqli_num_rows($result);
	
	if ($numrows>0) {
		$i=0;
		echo "<table cellspacing='0' class='arts_table'>";
		?>
		<tr class='no_hover'>

			
			<td class='art_title'><a href="viewMyArticles.php?cat_id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=title"><?php echo title; ?></a></td>
			<td class='art_autor'><a href="viewMyArticles.php?cat_id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=user_id"><?php echo author; ?></a></td>
			<td class='art_date'><a href="viewMyArticles.php?cat_id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=publish_date"><?php echo publish_date; ?></a></td>
			<td class='art_date'><?php echo last_comment_date; ?></td>
		</tr>
	<?php
		while ($i<$numrows){
			$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
			$title=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"title");
			$publish_date=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"publish_date");
			$brief=limit(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"brief"),$brief_count);
			$u_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"user_id");
			$author = lookupField('users','user_id','full_name',$u_id);

			?>
			
			
				<tr onClick='document.location="<?php echo _PREF; ?>view/forum/viewArticles.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>&id=<?php echo $id; ?>"'>
					<td class='art_title'><?php echo $title; ?></td>
					<td class='art_autor'><?php echo $author; ?></td>
					<td class='art_date'><?php echo $publish_date; ?></td>
					<td class='last_art_date'>
						<?php
							$com_sql =  "SELECT max(publish_date) FROM art_comments where art_id = '$id'";
							$com_result = mysqli_query($GLOBALS["db_link_conn"], $com_sql);
							$com_numrows = mysqli_num_rows($com_result);
							if($com_numrows>0){
								$com_date = mysqli_result($GLOBALS["db_link_conn"], $com_result,0,'max(publish_date)');
								if($com_date){
									$last_com_date=date('Y-m-d',strtotime($com_date));
								}else{
									$last_com_date = '';
								}
								
								echo $last_com_date;
							}
						?>
					
					</td>
				</tr>
			
		
			<?php
			$i++;
		}
		echo "</table>";
	}
	$tp = count_items("art_articles", str_replace("WHERE", "", $whereStmt));
	if($tp>0){
		if(($tp/$LPP)>1)
		echo "<div class='pagination_con'>".createPagination($tp,$pn,$LPP)."</div>";
	}

		
?>                                                   
                            

</div>
