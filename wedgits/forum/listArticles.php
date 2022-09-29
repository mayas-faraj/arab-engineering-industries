<? if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";exit();} 
$cat_id = cleanString($_REQUEST['cat_id']);
?>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/forum/articles_<?=$pageLang?>.css'/>
<div class= "page_content">

	
	
<?
if($cat_id){
	if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
	$LPP = 20;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	/***********Default Sorting Option*************/
	$sb = cleanString($_REQUEST['sb']);
	$so = cleanString($_REQUEST['so']);
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

		
		<?
			$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
			$forum_name = lookupField('art_categories','id','name',cleanString($_REQUEST['cat_id']));
		?>
		<div class="title2"><?=our_articles?> (<?=$forum_name?>) <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.cleanString($_SESSION["us_id"]).'&cat_id='.cleanString($_REQUEST['cat_id']).'">'.$user_name.'</a></font>'?></span></div>
	
	<?if($publish){?>
		
		<div class="add_link"><a style='color:#187ba7;' href='<?=_PREF?>view/forum/addArticle.php?cat_id=<?=cleanString($_REQUEST['cat_id'])?>'><?=add_article?></a></div>
		
	<?}?>
		
		
		<?
	
		if($_SESSION["us_id"]==$admin){
			$whereStm = " WHERE (publish_date <= date(now())) and  active='1' and cat_id='$cat_id'  ";
		}else{
			$whereStm = " WHERE (publish_date <= date(now())) and  active='1' and cat_id='$cat_id' and user_id in($allowed_users,".$_SESSION["us_id"].") ";
		}
		
		$sql =  "SELECT * FROM art_articles arts $whereStm $sort  $limit";
		$result = MYSQL_QUERY($sql);
		
		$numrows = MYSQL_NUMROWS($result);
		if ($numrows>0) {
			$i=0;
			echo "<table cellspacing='0' class='arts_table'>";
			?>

					<!--tr class='no_hover form_header'>
						<td class='art_title' ><a href="viewAllArticles.php?id=<?=cleanString($_REQUEST['id'])?>&so=<?=$soo?>&sb=title"><?=title?></a></td>
						<td class='art_autor' align='center'><a href="viewAllArticles.php?id=<?=cleanString($_REQUEST['id'])?>&so=<?=$soo?>&sb=user_id"><?=author?></a></td>
						<td class='art_date' align='center'><a href="viewAllArticles.php?id=<?=cleanString($_REQUEST['id'])?>&so=<?=$soo?>&sb=publish_date"><?=publish_date?></a></td>
						<td class='art_date' align='center'><?=last_comment_date?></td>
					</tr-->
					
					<tr class='no_hover form_header'>
						<td class='art_title' ><?=title?></td>
						<td class='art_autor' align='center'><?=author?></td>
						<td class='art_date' align='center'><?=publish_date?></td>
						<td class='art_date' align='center'><?=last_comment_date?></td>
					</tr>

			<?
			while ($i<$numrows){
				$id=mysql_result($result, $i,"id");
				$title= stripslashes(mysql_result($result, $i,"title"));
				$publish_date=mysql_result($result, $i,"publish_date");
				$brief=stripslashes(limit(mysql_result($result, $i,"brief"),$brief_count));
				$u_id = mysql_result($result, $i,"user_id");
				$cat_id = mysql_result($result, $i,"cat_id");
				$author = lookupField('users','user_id','full_name',$u_id);

				?>
				

					<tr >
						<td class='art_title'><a href="<?=_PREF?>view/forum/viewArticles.php?cat_id=<?=$cat_id?>&id=<?=$id?>"><?=$title?></a></td>
						<td class='art_autor' align='center'><?=$author?></td>
						<td class='art_date' align='center'><?=$publish_date?></td>
						<td class='last_art_date' align='center'>
							<?
								$com_sql =  "SELECT max(publish_date) FROM art_comments where art_id = '$id'";
								$com_result = MYSQL_QUERY($com_sql);
								$com_numrows = MYSQL_NUMROWS($com_result);
								if($com_numrows>0){
									$com_date = mysql_result($com_result,0,'max(publish_date)');
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

					
				
				<?
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
