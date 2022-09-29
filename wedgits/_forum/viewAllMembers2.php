<? 
if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} 
$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
$cat_id = $_REQUEST['id'];
?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">
	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
	$publish = lookupField('art_categories','id','publish',$_REQUEST['cat_id']);?>
	<div class="title2"><?php echo forum_members; ?> <span><?echo Welcome.' <font>'.$user_name.'</font>'?></span></div>
	
	<?if($publish){?>
		<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/addArticle.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/addArticle.png'/><?//=AddArticle?></a> </div>
		<div class="add_link">&nbsp;</div>
	<?}?>			
	<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/myPage.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/myPage.png'/><?//=MyAricles?></a></div>
	<div class="add_link">&nbsp;</div>
	<div class="add_link"><a href='<?php echo _PREF; ?>view/forum/changePass.php?cat_id=<?php echo $_REQUEST['cat_id']; ?>'><img src='<?php echo _PREF; ?>wedgits/forum/changePass.png'/><?//=changePass?></a></div>


	
<?

if($_REQUEST['pn'])	$pn = $_REQUEST['pn'];
	$LPP = 10;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	/***********Default Sorting Option*************/
	$sb = $_REQUEST['sb'];
	$so = $_REQUEST['so'];
	if( !$sb )	$sb="full_name";
	if( !$so )	$so="DESC";
	$sort  = ($sort=="")?"ORDER BY full_name $so":$sort ;
	if($so=='DESC'){
		$soo="ASC";
	}else{
		$soo="DESC";
	}
	
	
	$grp_ids = returnImplode_ids('topic_groups'," topic_id = '".$cat_id."' ",'grp_id');
	$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
	$allowed_users_arr = explode(',',$allowed_users);
	if(in_array($_SESSION["us_id"],$allowed_users_arr)){
		$whereStm = " WHERE user_id in($allowed_users) ";
		$sql =  "SELECT * FROM users $whereStm $sort  $limit";
		$result = MYSQL_QUERY($sql);
		$numrows = MYSQL_NUMROWS($result);
		if ($numrows>0) {
			$i=0;
			echo "<table cellspacing='0' class='arts_table'>";
			echo "<tr class='form_header'>";		
				echo "<td>".mem_name."</td>";
				echo "<td>".mem_signature."</td>";
				echo "<td>".mem_email."</td>";
				echo "<td width='100px' align='center'>&nbsp;</td>";
			echo "</tr>";
			while ($i<$numrows){
					$user_id= MYSQL_RESULT($result,$i,"user_id");
					$username= MYSQL_RESULT($result,$i,"username");
					$password= MYSQL_RESULT($result,$i,"password");
					$full_name= MYSQL_RESULT($result,$i,"full_name");
					$email= MYSQL_RESULT($result,$i,"email");
					$grp_id= MYSQL_RESULT($result,$i,"grp_id");
					$user_desc= MYSQL_RESULT($result,$i,"user_desc");
					$photo= basename(MYSQL_RESULT($result,$i,"photo"));
					$signature= basename(MYSQL_RESULT($result,$i,"signature"));
				?>
					<tr>
						<td ><?php echo $full_name; ?></td>
						<td ><?php echo $signature; ?></td>
						<td><?php echo $email; ?></td>
						<td width='100px' align='center'>
							<?
								if($photo){
									$thumb = resizeToFile('../../uploads/'.$photo, 100 , 100 , '../../uploads/cash/admin_forum_user_'.$photo);
									echo "<img src='$thumb'/>";
								}else{
									echo "&nbsp;";
								}
							?>						
						</td>
					</tr>
				<?
				$i++;
			}
			echo "</table>";
		}
		$tp = count_items("users", str_replace("WHERE", "", $whereStm));
		if($tp>0){
			if(($tp/$LPP)>1)
			echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
		}
	}else{
		echo not_allowed_to_view_forum;
	}	
?>                                                   
                            

</div>
