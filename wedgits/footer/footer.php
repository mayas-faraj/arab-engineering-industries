<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/footer/footer_<?=$pageLang?>.css'/>	
<?$linkedIn = basename(lookupField('site_settings','id','value',2));?>
<div id="footer" class='footer'>
	<div class="footer_left"><?=copyright_footer?></div>
	<div class="footer_middle"><?=Powerd_by?></div>
	<div class="footer_right"><a href="<?=_PREF?>view/contact/contact.php"><?=Contact_Us?></a>  |  <a href="http://<?=$linkedIn?>" target='_blank'><?=follow_Us?></a>  <a href="http://<?=$linkedIn?>" target='_blank'><img style='border:0;' src="<?=_PREF?>images/footer_in.png" /></a></div>
</div>