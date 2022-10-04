<?php if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} 
$cat_id = $_REQUEST['cat_id'];
?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">

	
	
<?php
if($cat_id){
	if($_REQUEST['pn'])	$pn = $_REQUEST['pn'];
	$LPP = 20;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	/***********Default Sorting Option*************/
	$sb = $_REQUEST['sb'];
	$so = $_REQUEST['so'];
	if( !$sb )	$sb=" (SELECT max(publish_date) FROM art_comments where art_id = arts.id ) ";
	if( !$so )	$so="DESC";
	//$sort  = ($sort=="")?"ORDER BY (SELECT max(publish_date) FROM art_comments where art_id = arts.id ) $so":$sort ;
	$sort  = ($sort=="")?" ORDER BY id $so":$sort ;
	if($so=='DESC'){
		$soo="ASC";
	}else{
		$soo="DESC";
	}
	
	$publish = lookupField('art_categories','id','publish',$cat_id);
	$admin = lookupField('art_categories','id','grp_admin',$cat_id);
	$grp_ids = returnImplode_ids('topic_groups'," topic_id = '".$cat_id."' ",'grp_id');
	$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
	$allowed_users_arr = explode(',',$allowed_users);
	
	if(in_array($_SESSION["us_id"],$allowed_users_arr) || $_SESSION["us_id"]==$admin){
		?>

		
		<?php
			$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
			$forum_name = lookupField('art_categories','id','name',$_REQUEST['cat_id']);
		?>
		<div class="title2"><?php echo our_articles; ?> (<?php echo $forum_name; ?>) <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font>'?></span></div>
	
	<?if($publish){?>
		
		<div class="add_link"><a style='color:#187ba7;' href='<?php echo _PREF; ?>view/forum/addArticle.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><?php echo add_article; ?></a></div>
		
	<?}?>
		
		
		<?php
	
		if($_SESSION["us_id"]==$admin){
			$whereStm = " WHERE (publish_date <= date(now())) and  active='1' and cat_id='$cat_id'  ";
		}else{
			$whereStm = " WHERE (publish_date <= date(now())) and  active='1' and cat_id='$cat_id' and user_id in($allowed_users,".$_SESSION["us_id"].") ";
		}
		
		$sql =  "SELECT * FROM art_articles arts $whereStm $sort  $limit";
		$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
		
		$numrows = mysqli_num_rows($result);
		if ($numrows>0) {
			$i=0;
			echo "<table cellspacing='0' class='arts_table'>";
			?>

					<!--tr class='no_hover form_header'>
						<td class='art_title' ><a href="viewAllArticles.php?id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=title"><?php echo title; ?></a></td>
						<td class='art_autor' align='center'><a href="viewAllArticles.php?id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=user_id"><?php echo author; ?></a></td>
						<td class='art_date' align='center'><a href="viewAllArticles.php?id=<?php echo $_REQUEST['id']; ?>&so=<?php echo $soo; ?>&sb=publish_date"><?php echo publish_date; ?></a></td>
						<td class='art_date' align='center'><?php echo last_comment_date; ?></td>
					</tr-->
					
					<tr class='no_hover form_header'>
						<td class='art_title' ><?php echo title; ?></td>
						<td class='art_autor' align='center'><?php echo author; ?></td>
						<td class='art_date' align='center'><?php echo publish_date; ?></td>
						<td class='art_date' align='center'><?php echo last_comment_date; ?></td>
					</tr>

			<?php
			while ($i<$numrows){
				$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
				$title= stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"title"));
				$publish_date=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"publish_date");
				$brief=stripslashes(limit(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"brief"),$brief_count));
				$u_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"user_id");
				$cat_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"cat_id");
				$author = lookupField('users','user_id','full_name',$u_id);

				?>
				

					<tr >
						<td class='art_title'><a href="<?php echo _PREF; ?>view/forum/viewArticles.php?cat_id=<?php echo $cat_id; ?>&id=<?php echo $id; ?>"><?php echo $title; ?></a></td>
						<td class='art_autor' align='center'><?php echo $author; ?></td>
						<td class='art_date' align='center'><?php echo $publish_date; ?></td>
						<td class='last_art_date' align='center'>
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
		$tp = count_items("art_articles", str_replace("WHERE", "", $whereStm));
		if($tp>0){
			if(($tp/$LPP)>1)
			echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
		}
	}else{
		echo not_allowed_to_view_forum;
	}
	

}	
?>                                                   
                            

</div>
