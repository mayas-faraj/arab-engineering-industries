<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/blocks/blocks_<?=$pageLang?>.css'/>

	<?
		if($pageLang=='en'){
			$ids = array(3,5,7);
		}else{
			$ids = array(4,6,8);
		}
		$links = array(11,12,13);
	?>
	<div class="blocks">
	<div class="blocks_image">
		<a href="http://<?=lookupField('site_settings','id','value',$links[0])?>" ><img src="<?=_PREF?>images/block1_<?=$pageLang?>.png" /></a>
		<span><?=lookupField('site_settings','id','value',$ids[0])?></span>
	</div>
	
	<div class="blocks_image">
		<a href="http://<?=lookupField('site_settings','id','value',$links[1])?>" ><img src="<?=_PREF?>images/block2_<?=$pageLang?>.png" /></a>
		<span><?=lookupField('site_settings','id','value',$ids[1])?></span>
	</div>
	
	<div class="blocks_image">
		<a href="http://<?=lookupField('site_settings','id','value',$links[2])?>" ><img src="<?=_PREF?>images/block3_<?=$pageLang?>.png" /></a>
		<span><?=lookupField('site_settings','id','value',$ids[2])?></span>
	</div>
	
	<!-- <div class="blocks_calender"><a href="#"><img src="<?=_PREF?>images/calender.png" /></a></div> -->
	<?php include('wedgits/calender/calender.php');?>
	</div>