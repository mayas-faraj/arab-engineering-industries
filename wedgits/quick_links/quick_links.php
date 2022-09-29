<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/quick_links/quick_links_<?php echo $pageLang; ?>.css'/>	
<?

if($pageLang=='en'){
	$ids = array(3,5,7);
}else{
	$ids = array(4,6,8);
}
$links = array(11,12,13);		
?>

<div class="quick_links" >
	<div class='quick_title'><?php echo quick_links; ?></div>
	<a href='http://<?php echo lookupField('site_settings','id','value',$links[2]); ?>'  class='quick quick1'><?php echo lookupField('site_settings','id','value',$ids[2]); ?></a>
	<a href='http://<?php echo lookupField('site_settings','id','value',$links[1]); ?>'  class='quick quick2'><?php echo lookupField('site_settings','id','value',$ids[1]); ?></a>
	<a href='http://<?php echo lookupField('site_settings','id','value',$links[0]); ?>'  class='quick quick3'><?php echo lookupField('site_settings','id','value',$ids[0]); ?></a>
</div>
	