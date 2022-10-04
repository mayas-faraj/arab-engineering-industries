<?if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";exit();}
$mem_id = cleanString($_REQUEST['mem_id']); 
$cat_id = cleanString($_REQUEST['id']);
$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
$mem_name = lookupField('users','user_id','full_name',$mem_id);

?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">
	
	<div class="title2"><?php echo $mem_name; ?> <span><?echo Welcome.' <font><a href="viewForumMember.php?mem_id='.$_SESSION["us_id"].'&id='.$cat_id.'">'.$user_name.'</a></font>'?></span></div>

	
<?php

if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
	$LPP = 10;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	/***********Default Sorting Option*************/
	$sb = cleanString($_REQUEST['sb']);
	$so = cleanString($_REQUEST['so']);
	if( !$sb )	$sb="full_name";
	if( !$so )	$so="DESC";
	$sort  = ($sort=="")?"ORDER BY full_name $so":$sort ;
	if($so=='DESC'){
		$soo="ASC";
	}else{
		$soo="DESC";
	}
	
	
		
	$sql =  "SELECT * FROM users where user_id = '$mem_id'";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numrows = mysqli_num_rows($result);
	if ($numrows>0) {
		$i=0;
		

		$user_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"user_id");
		$username= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"username");
		$password= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"password");
		$full_name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"full_name");
		$email= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"email");
		$grp_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"grp_id");
		$user_desc= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"user_desc");
		$photo= basename(mysqli_result($GLOBALS["db_link_conn"], $result,$i,"photo"));
		$signature= basename(mysqli_result($GLOBALS["db_link_conn"], $result,$i,"signature"));
		if($photo){
			$thumb = resizeToFile('../../uploads/'.$photo, 100 , 100 , '../../uploads/cash/admin_forum_user_'.$photo);
			$img = "<img src='$thumb'/>";
		}else{
			$img = "&nbsp;";
		}
		echo "<div class='mem_img'>$img</div>";
		echo "<div class='mem_info_item'> $email</div><br/>";
		echo "<div class='mem_info_item'> $user_desc</div>";
	}


?>                                                   
                            

</div>
