<? if(!cleanString($_SESSION["us_id"])){echo"<script>document.location='"._PREF."index.php'</script>";exit();} ?>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/forum/articles_<?=$pageLang?>.css' />
<script src="<?=_PREF?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>


<?php 


$results='';
$sub = cleanString($_REQUEST['sub']);
if($sub)
{
	$uname = cleanString($_REQUEST['uname']);
	$oldp = cleanString($_REQUEST['oldp']);
	$newp = cleanString($_REQUEST['newp']);
	$repp = cleanString($_REQUEST['repp']);
	$user_id = cleanString($_SESSION["us_id"]);
	$lang = _LANG;
	
	$sql = "select * from users where password='$oldp' AND user_id='$user_id'";
	$result =  MYSQL_QUERY($sql);
	$numrows = mysql_numrows($result);
	if(!$numrows){
		$results = invalid_pass;
		
	}elseif($newp != $repp){
		$results = pass_match;
	}else{
		$sql = "update  users set  password='$newp' where user_id='$user_id'";
		$result =  MYSQL_QUERY($sql);
		if($result){
			$results = pass_succ;
		}else{
			$results = xsend;
		}
		
	}
}



?>

<div class= "page_content">
	<?$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
	$publish = lookupField('art_categories','id','publish',cleanString($_REQUEST['cat_id']));?>
	<div class="title2"><?=changePass?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.cleanString($_SESSION["us_id"]).'&cat_id='.cleanString($_REQUEST['cat_id']).'">'.$user_name.'</a></font>'?></span></div>

	<?if($publish){?>
		<div class="add_link"><a href='<?=_PREF?>view/forum/addArticle.php?cat_id=<?=cleanString($_REQUEST['cat_id'])?>'><img src='<?=_PREF?>wedgits/forum/addArticle.png'/><?//=AddArticle?></a> </div>
		<div class="add_link">&nbsp;</div>
	<?}?>			
	<div class="add_link"><a href='<?=_PREF?>view/forum/myPage.php?cat_id=<?=cleanString($_REQUEST['cat_id'])?>'><img src='<?=_PREF?>wedgits/forum/myPage.png'/><?//=MyAricles?></a></div>
	<div class="add_link">&nbsp;</div>
	<div class="add_link"><a href='<?=_PREF?>view/forum/changePass.php?cat_id=<?=cleanString($_REQUEST['cat_id'])?>'><img src='<?=_PREF?>wedgits/forum/changePass.png'/><?//=changePass?></a></div>
	
	
	
	<div class="add_article">
		<form  method="post" name="subForm" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input type="hidden" name="art" value="<?=$article_id ?>" />
			<input type="hidden" name="cat_id" value="<?=cleanString($_REQUEST['cat_id']) ?>" />
			<input type="hidden" name="sub" value="1" />

			<table class='changePass' border="0" cellpadding="0" cellspacing="0">
				<tr><td width="130px"><?=oldPassword ?>:</td><td width=1>*&nbsp;</td><td><input type="password" name="oldp" id="title" class="required1" /></td></tr>
				<tr><td width="130px"><?=newPassword ?>:</td><td width=1>*&nbsp;</td><td><input type="password" name="newp" id="title" class="required1" /></td></tr>
				<tr><td width="130px"><?=repPassword ?>:</td><td width=1>*&nbsp;</td><td><input type="password" name="repp" id="title" class="required1" /></td></tr>
				<tr><td colspan='3' style='width:100%;'><input type="button" name="save" value="<?=Save?>" class="" onclick='validate_form1();' /></td></tr>
			</table>
		</form>
	</div>	

	<div class='add_result'><?=$results?></div>

</div>
	