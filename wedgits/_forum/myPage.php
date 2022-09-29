<? if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} ?>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/forum/articles_<?=$pageLang?>.css' />
<script src="<?=_PREF?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="<?=_PREF?>modules/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="<?=_PREF?>modules/includes/config_user.js" language="javascript" type="text/javascript"></script>
<script> initEditor();</script>

<?php 


$results='';
$sub = $_REQUEST['sub'];
if($sub){


	$oldp = $_REQUEST['oldp'];
	$newp = $_REQUEST['newp'];
	$repp = $_REQUEST['repp'];
	$user_id = $_SESSION["us_id"];
	if($oldp){
		$sql = "select * from users where password='$oldp' AND user_id='$user_id'";
		$result =  MYSQL_QUERY($sql);
		$numrows = mysql_numrows($result);
		if(!$numrows){
			$results .= invalid_pass;
			
		}elseif($newp != $repp){
			$results .= '<br/>'.pass_match;
		}else{
			$sql = "update  users set  password='$newp' where user_id='$user_id'";
			$updatePass_result =  MYSQL_QUERY($sql);
		}
	}
	


	

	$full_name = $_REQUEST['full_name'];
	$email = $_REQUEST['email'];
	$signature = $_REQUEST['signature'];
	$photo = $_FILES['photo']['name'];
	if($photo){
		$uploadfile = '../../uploads/'.$photo;
		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$photo_stm = " , photo= '$photo' ";
		}
	}
	
	$user_id = $_SESSION["us_id"];
	$lang = _LANG;
	$sql = "update  users set  full_name='$full_name' , email='$email' , user_desc='$signature' $photo_stm where user_id='$user_id'";
	$result =  MYSQL_QUERY($sql);
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
			$('.popup_result').html('<?=$results?>');
			$('.popup_result').fadeIn('fast');
			$('.site_mask').css('width',mask_width+'px');
			$('.site_mask').css('height',mask_height+'px');
			setTimeout(" $('.popup_result').fadeOut('fast'); $('.site_mask').css('width','0'); $('.site_mask').css('height','0');",3000);
		});
		
	</script>
	<?	
	
}

$full_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
$email = lookupField('users','user_id','email',$_SESSION["us_id"]);
$signature = lookupField('users','user_id','user_desc',$_SESSION["us_id"]);
$photo = basename(lookupField('users','user_id','photo',$_SESSION["us_id"]));
if($photo){
	$thumb = resizeToFile('../../uploads/'.$photo, 100 , 100 , '../../uploads/cash/admin_forum_user_'.$photo);
	$thumb_img =  "<img src='$thumb' width='15'/>";
}else{
	$thumb_img =  "";
}
?>

<div class= "page_content">

	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
	$publish = lookupField('art_categories','id','publish',$_REQUEST['cat_id']);?>
	<div class="title2"><?=myPage?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font>'?></span></div>

	<div class="add_article">
		<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input type="hidden" name="art" value="<?=$article_id ?>" />
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id'] ?>" />
			<input type="hidden" name="sub" value="1" />

			<table class='changePass' border="0" cellpadding="0" cellspacing="0">
				<tr><td width="130px"><?=full_name?>:</td><td width='25'>*&nbsp;</td><td><input type="text" value='<?=$full_name?>' name="full_name" id="" class="required1" /></td></tr>
				<tr><td width="130px"><?=mem_email?>:</td><td width='25'> &nbsp;</td><td><input type="text" value='<?=$email?>' name="email" id="" class="" /></td></tr>
				<tr>
					<td width="130px"><?=mem_signature?>:</td><td width='25'> &nbsp;</td><td>
					<textarea style='width:350px; height:150px' class='simpleEditor' name='signature'> <?=stripslashes($signature)?></textarea>
					</td>
				</tr>
				<tr><td width="130px"><?=per_picture?>:</td><td width='25' valign='bottom'>&nbsp;<?=$thumb_img?></td><td valign='bottom'><input type="file"  name="photo" id="title" class="" /></td></tr>
				<tr><td width="130px"><?=oldPassword?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="oldp" id="" class="" /></td></tr>
				<tr><td width="130px"><?=newPassword?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="newp" id="" class="" /></td></tr>
				<tr><td width="130px"><?=repPassword?>:</td><td width='25'> &nbsp;</td><td><input type="password" name="repp" id="" class="" /></td></tr>

				<tr><td colspan='3' style='width:100%;'><input type="button" name="save" value="<?=Save?>" class="" onclick='validate_form1();' /></td></tr>
			</table>
		</form>
	</div>	

	<div class='popup_result'></div>
	
</div>
	