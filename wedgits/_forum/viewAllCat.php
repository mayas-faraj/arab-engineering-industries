<?php 
if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} 

?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">
	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);?>
	<div class="title2"><?php echo Topics; ?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font></font>'?></span></div>

	
<?php

	if($_REQUEST['pn'])	$pn = $_REQUEST['pn'];
	$LPP = 20;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";

	$grp_ids = returnImplode_ids('forum_users_groups'," user_id = '".$_SESSION["us_id"]."' ",'grp_id');
	$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
	$whereStm = " WHERE active='1' ";
	$sql =  "SELECT * FROM art_categories $whereStm ORDER BY id DESC, id DESC ";
	$result = MYSQL_QUERY($sql);
	$numrows = MYSQL_NUMROWS($result);
	if ($numrows>0) {
		$i=0;
		echo "<table cellspacing='0' class='arts_table'>";
		echo "<tr class='form_header'>";		
			echo "<td>".form_title."</td>";
			echo "<td>".form_create_date."</td>";
			echo "<td>".form_admin."</td>";
			echo "<td width='100px' align='center'>".form_members."</td>";
		echo "</tr>";
		while ($i<$numrows){
			$id=mysql_result($result, $i,"id");
			$name=mysql_result($result, $i,"name");
			$create_date=mysql_result($result, $i,"create_date");
			$grp_admin_id=mysql_result($result, $i,"grp_admin");
			$grp_admin = lookupField('users','user_id','full_name',$grp_admin_id);
			
			if(!$grp_admin){
				$grp_admin='';
			}
			?>
				<tr>
					<td ><a href="<?php echo _PREF; ?>view/forum/viewAllArticles.php?cat_id=<?php echo $id; ?>"> <?php echo $name; ?></a></td>
					<td ><?php echo $create_date; ?></td>
					<td><?php echo $grp_admin; ?></td>
					<td width='100px' align='center'><a class='forum_admin' href='viewAllForumMembers.php?id=<?php echo $id; ?>'><img src='../../wedgits/forum/members_ico.png'/></a></td>
				</tr>
			<?php
			$i++;
		}
		echo "</table>";
	}

	

		
?>                                                   
                            

</div>
