<? 
if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";}
$mem_id = $_REQUEST['mem_id']; 
$cat_id = $_REQUEST['id'];
$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
$mem_name = lookupField('users','user_id','full_name',$mem_id);

?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>
<div class= "page_content">
	
	<div class="title2"><?php echo $mem_name; ?> <span><?echo Welcome.' <font><a href="viewForumMember.php?mem_id='.$_SESSION["us_id"].'&id='.$cat_id.'">'.$user_name.'</a></font>'?></span></div>

	
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
	
	
		
	$sql =  "SELECT * FROM users where user_id = '$mem_id'";
	$result = MYSQL_QUERY($sql);
	$numrows = MYSQL_NUMROWS($result);
	if ($numrows>0) {
		$i=0;
		

		$user_id= MYSQL_RESULT($result,$i,"user_id");
		$username= MYSQL_RESULT($result,$i,"username");
		$password= MYSQL_RESULT($result,$i,"password");
		$full_name= MYSQL_RESULT($result,$i,"full_name");
		$email= MYSQL_RESULT($result,$i,"email");
		$grp_id= MYSQL_RESULT($result,$i,"grp_id");
		$user_desc= MYSQL_RESULT($result,$i,"user_desc");
		$photo= basename(MYSQL_RESULT($result,$i,"photo"));
		$signature= basename(MYSQL_RESULT($result,$i,"signature"));
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
