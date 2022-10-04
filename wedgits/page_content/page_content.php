<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/page_content/page_content_<?php echo $pageLang; ?>.css'/>	
<div class="page_content" dir='<?php echo _DIR; ?>'>
<?php 
	$id = cleanString($_REQUEST['id']);
	if($id){
		$title = lookupField('pages','id','title',$id);
		?>

		<?php
		echo lookupField('pages','id','details',$id);
	}
	
?>
</div>