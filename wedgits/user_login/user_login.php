<script src="<?=_PREF?>wedgits/user_login/user_login.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/user_login/user_login_<?=$pageLang?>.css'/>
<?
$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
?>
<input type='hidden' name='path' value='<?=$path?>' class='path'/>
<div class='login_form' style='display:none;'>
	<div class='ajax_loader'><img src='<?=_PREF?>wedgits/ajax_effects/ajax_loader.gif'/></div>
	<div class='ajax_msg'><?=logging_in?></div>
	<table cellspacing='0' cellpadding='0' class='form_table' dir="<?=_DIR?>">
		<tr>
			<td><?=Username?>: </td>
			<td><input type='text' name='username' class='requireds username'/></td>
		</tr>
		<tr>
			<td><?=Password?>: </td>
			<td><input type='password' name='pass' class='requireds pass'/></td>
		</tr>
	</table>
	<div class='login_nav'>
		<input type='submit' value='<?=Login?>' onclick="submitMemForm('<?=logging_in?>','<?=logged_in_successfuly?>','<?=invalid_username?>')"/> 
		<input type='button' value='<?=Cancel?>' class='close_form'/> 
	</div>
</div>

<div class='site_mask'></div>