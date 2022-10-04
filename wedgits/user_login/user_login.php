<script src="<?php echo _PREF; ?>wedgits/user_login/user_login.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/user_login/user_login_<?php echo $pageLang; ?>.css'/>
<?php
$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
?>
<input type='hidden' name='path' value='<?php echo $path; ?>' class='path'/>
<div class='login_form' style='display:none;'>
	<div class='ajax_loader'><img src='<?php echo _PREF; ?>wedgits/ajax_effects/ajax_loader.gif'/></div>
	<div class='ajax_msg'><?php echo logging_in; ?></div>
	<table cellspacing='0' cellpadding='0' class='form_table' dir="<?php echo _DIR; ?>">
		<tr>
			<td><?php echo Username; ?>: </td>
			<td><input type='text' name='username' class='requireds username'/></td>
		</tr>
		<tr>
			<td><?php echo Password; ?>: </td>
			<td><input type='password' name='pass' class='requireds pass'/></td>
		</tr>
	</table>
	<div class='login_nav'>
		<input type='submit' value='<?php echo Login; ?>' onclick="submitMemForm('<?php echo logging_in; ?>','<?php echo logged_in_successfuly; ?>','<?php echo invalid_username; ?>')"/> 
		<input type='button' value='<?php echo Cancel; ?>' class='close_form'/> 
	</div>
</div>

<div class='site_mask'></div>