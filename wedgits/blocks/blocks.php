<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/blocks/blocks_<?php echo $pageLang; ?>.css'/>

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
		<a href="http://<?php echo lookupField('site_settings','id','value',$links[0]); ?>" ><img src="<?php echo _PREF; ?>images/block1_<?php echo $pageLang; ?>.png" /></a>
		<span><?php echo lookupField('site_settings','id','value',$ids[0]); ?></span>
	</div>
	
	<div class="blocks_image">
		<a href="http://<?php echo lookupField('site_settings','id','value',$links[1]); ?>" ><img src="<?php echo _PREF; ?>images/block2_<?php echo $pageLang; ?>.png" /></a>
		<span><?php echo lookupField('site_settings','id','value',$ids[1]); ?></span>
	</div>
	
	<div class="blocks_image">
		<a href="http://<?php echo lookupField('site_settings','id','value',$links[2]); ?>" ><img src="<?php echo _PREF; ?>images/block3_<?php echo $pageLang; ?>.png" /></a>
		<span><?php echo lookupField('site_settings','id','value',$ids[2]); ?></span>
	</div>
	
	<!-- <div class="blocks_calender"><a href="#"><img src="<?php echo _PREF; ?>images/calender.png" /></a></div> -->
	<?php include('wedgits/calender/calender.php');?>
	</div>