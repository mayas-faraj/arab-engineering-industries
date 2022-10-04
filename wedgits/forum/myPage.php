<?php if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";exit();} ?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css' />
<script src="<?php echo _PREF; ?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo _PREF; ?>modules/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="<?php echo _PREF; ?>modules/includes/config_user.js" language="javascript" type="text/javascript"></script>
<script> initEditor();</script>

<?php 


$results='';
$sub = cleanString($_REQUEST['sub']);
if($sub){


	$oldp = cleanString($_REQUEST['oldp']);
	$newp = cleanString($_REQUEST['newp']);
	$repp = cleanString($_REQUEST['repp']);
	$user_id = cleanString($_SESSION["us_id"]);
	if($oldp){
		$sql = "select * from users where password='$oldp' AND user_id='$user_id'";
		$result =  mysqli_query($GLOBALS["db_link_conn"], $sql);
		$numrows = mysqli_num_rows($result);
		if(!$numrows){
			$results .= invalid_pass;
			
		}elseif($newp != $repp){
			$results .= '<br/>'.pass_match;
		}else{
			$sql = "update  users set  password='$newp' where user_id='$user_id'";
			$updatePass_result =  mysqli_query($GLOBALS["db_link_conn"], $sql);
		}
	}
	


	

	$full_name = cleanString($_REQUEST['full_name']);
	$email = cleanString($_REQUEST['email']);
	$signature = cleanString($_REQUEST['signature']);
	$photo = cleanString($_FILES['photo']['name']);
	if($photo){
		$uploadfile = '../../uploads/'.$photo;
		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$photo_stm = " , photo= '$photo' ";
		}
	}
	
	$user_id = cleanString($_SESSION["us_id"]);
	$lang = _LANG;
	$sql = "update  users set  full_name='$full_name' , email='$email' , user_desc='$signature' $photo_stm where user_id='$user_id'";
	$result =  mysqli_query($GLOBALS["db_link_conn"], $sql);
	if($result){
		$results .= '<br/>'.data_succ;
	}else{
		$results .= '<br/>'.xsend;
	}
	?>
	<script>	
		$('document').ready(function(){
			mask_width = $(window).width();
			mask_height = $(window).height();
			$('.popup_result').html('<?php echo $results; ?>');
			$('.popup_result').fadeIn('fast');
			$('.site_mask').css('width',mask_width+'px');
			$('.site_mask').css('height',mask_height+'px');
			setTimeout(" $('.popup_result').fadeOut('fast'); $('.site_mask').css('width','0'); $('.site_mask').css('height','0');",3000);
		});
		
	</script>
	<?php	
	if($result){?>
		<script>setTimeout("document.location='viewAllCat.php'",3000);</script>
	<?}
}

$full_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
$email = lookupField('users','user_id','email',cleanString($_SESSION["us_id"]));
$signature = lookupField('users','user_id','user_desc',cleanString($_SESSION["us_id"]));
$photo = basename(lookupField('users','user_id','photo',cleanString($_SESSION["us_id"])));
if($photo){
	$thumb = resizeToFile('../../uploads/'.$photo, 100 , 100 , '../../uploads/cash/admin_forum_user_'.$photo);
	$thumb_img =  "<img src='$thumb' width='15'/>";
}else{
	$thumb_img =  "";
}
?>

<div class= "page_content">

	<?$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
	$publish = lookupField('art_categories','id','publish',cleanString($_REQUEST['cat_id']));?>
	<div class="title2"><?php echo myPage; ?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.cleanString($_SESSION["us_id"]).'&cat_id='.cleanString($_REQUEST['cat_id']).'">'.$user_name.'</a></font>'?></span></div>

	<div class="add_article">
		<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input type="hidden" name="art" value="<?php echo $article_id ; ?>" />
			<input type="hidden" name="cat_id" value="<?php echo cleanString($_REQUEST['cat_id']) ; ?>" />
			<input type="hidden" name="sub" value="1" />

			<table class='changePass' border="0" cellpadding="0" cellspacing="0">
				<tr><td width="130px"><?php echo full_name; ?>:</td><td width='25'>*&nbsp;</td><td><input type="text" value='<?php echo $full_name; ?>' name="full_name" id="" class="required1" /></td></tr>
				<tr><td width="130px"><?php echo mem_email; ?>:</td><td width='25'> &nbsp;</td><td><input type="text" value='<?php echo $email; ?>' name="email" id="" class="" /></td></tr>
				<tr>
					<td width="130px"><?php echo mem_signature; ?>:</td><td width='25'> &nbsp;</td><td>
					<textarea style='width:350px; height:150px' class='simpleEditor' name='signature'> <?php echo stripslashes($signature); ?></textarea>
					</td>
				</tr>
				<tr><td width="130px"><?php echo per_picture; ?>:</td><td width='25' valign='bottom'>&nbsp;<?php echo $thumb_img; ?></td><td valign='bottom'><input type="file"  name="photo" id="title" class="" /></td></tr>
				<tr><td width="130px"><?php echo oldPassword; ?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="oldp" id="" class="" /></td></tr>
				<tr><td width="130px"><?php echo newPassword; ?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="newp" id="" class="" /></td></tr>
				<tr><td width="130px"><?php echo repPassword; ?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="repp" id="" class="" /></td></tr>

				<tr><td colspan='3' style='width:100%;'><input type="button" name="save" value="<?php echo Save; ?>" class="" onclick='validate_form1();' /></td></tr>
			</table>
		</form>
	</div>	

	<div class='popup_result'></div>
	
</div>
	