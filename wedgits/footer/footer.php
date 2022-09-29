<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/footer/footer_<?php echo $pageLang; ?>.css'/>	
<?$linkedIn = basename(lookupField('site_settings','id','value',2));?>
<div id="footer" class='footer'>
	<div class="footer_left"><?php echo copyright_footer; ?></div>
	<div class="footer_middle"><?php echo Powerd_by; ?></div>
	<div class="footer_right"><a href="<?php echo _PREF; ?>view/contact/contact.php"><?php echo Contact_Us; ?></a>  |  <a href="http://<?php echo $linkedIn; ?>" target='_blank'><?php echo follow_Us; ?></a>  <a href="http://<?php echo $linkedIn; ?>" target='_blank'><img style='border:0;' src="<?php echo _PREF; ?>images/footer_in.png" /></a></div>
</div>