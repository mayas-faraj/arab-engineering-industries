<script src="<?=_PREF?>wedgits/user_logout/user_logout.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/user_logout/user_logout_<?=$pageLang?>.css'/>
<?
$page_name = getCurrentFormName();
	if($page_name=='index'){
		$paths='';
	}else{
		$paths='../../';
	}
?>
<input type='hidden' name='paths' value='<?=$paths?>' class='paths'/>
<div class='logout_form' style=''>

	<div class='ajax_msgs'><?=logging_out?></div>
</div>


<div class='site_mask'></div>