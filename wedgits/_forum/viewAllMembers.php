<? 
if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} 
$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
$cat_id = $_REQUEST['id'];
?>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/forum/articles_<?=$pageLang?>.css'/>
<div class= "page_content">
	
	
	<div class="title2"><?=form_members_inner?> (<?=lookupField('art_categories','id','name',$cat_id)?>) <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$cat_id.'">'.$user_name.'</a></font>'?></span></div>
	
<?

if($_REQUEST['pn'])	$pn = $_REQUEST['pn'];
	$LPP = 10;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	/***********Default Sorting Option*************/
	$sb = $_REQUEST['sb'];
	$so = $_REQUEST['so'];
	if( !$sb )	$sb="full_name";
	if( !$so )	$so="ASC";
	$sort  = ($sort=="")?"ORDER BY full_name $so":$sort ;
	if($so=='DESC'){
		$soo="ASC";
	}else{
		$soo="DESC";
	}
	
	
	$grp_ids = returnImplode_ids('topic_groups'," topic_id = '".$cat_id."' ",'grp_id');
	$admin = lookupField('art_categories','id','grp_admin',$cat_id);
	$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
	$allowed_users_arr = explode(',',$allowed_users);
	/*if(in_array($_SESSION["us_id"],$allowed_users_arr) || $_SESSION["us_id"]==$admin){*/
		//if($_SESSION["us_id"]!=$admin){
			if(!$allowed_users){
				$allowed_users=0;
				
			}
			$whereStm = " WHERE  user_id in ($allowed_users)  ";
		//}
		
		$sql =  "SELECT * FROM users $whereStm $sort  $limit";
		$result = MYSQL_QUERY($sql);
		$numrows = MYSQL_NUMROWS($result);
		if ($numrows>0) {
			$i=0;
			echo "<table cellspacing='0' class='arts_table'>";
			echo "<tr class='form_header'>";		
				echo "<td width='100px' align='center'>&nbsp;</td>";
				echo "<td>".mem_name."</td>";
				echo "<td>".mem_signature."</td>";
				echo "<td>".mem_email."</td>";
				
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
					<tr class='no_link'>
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
						<td ><?=$full_name?></td>
						<td width='200px' align='<?=_SALI?>'><?=$user_desc?></td>
						<td><?=$email?></td>
					
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
	/*}else{
		echo not_allowed_to_view_forum;
	}*/	
?>                                                   
                            

</div>
