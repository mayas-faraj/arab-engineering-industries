<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/page_content/page_content_<?=$pageLang?>.css'/>	
<div class="page_content" dir='<?=_DIR?>'>
<? 
	$id = cleanString($_REQUEST['id']);
	if($id){
		$title = lookupField('pages','id','title',$id);
		?>

		<?
		echo lookupField('pages','id','details',$id);
	}
	
?>
</div>