<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/quick_links/quick_links_<?=$pageLang?>.css'/>	
<?

if($pageLang=='en'){
	$ids = array(3,5,7);
}else{
	$ids = array(4,6,8);
}
$links = array(11,12,13);		
?>

<div class="quick_links" >
	<div class='quick_title'><?=quick_links?></div>
	<a href='http://<?=lookupField('site_settings','id','value',$links[2])?>'  class='quick quick1'><?=lookupField('site_settings','id','value',$ids[2])?></a>
	<a href='http://<?=lookupField('site_settings','id','value',$links[1])?>'  class='quick quick2'><?=lookupField('site_settings','id','value',$ids[1])?></a>
	<a href='http://<?=lookupField('site_settings','id','value',$links[0])?>'  class='quick quick3'><?=lookupField('site_settings','id','value',$ids[0])?></a>
</div>
	