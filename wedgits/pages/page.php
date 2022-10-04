<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/pages/page_<?php echo $pageLang; ?>.css'/>	

<?php
if($pageLang=='en'){
	$id = 1;
	$count = 640;
}else{
	$id = 4;
	$count = 1450;
}
if($id){
	$title = lookupField('pages','id','title',$id);
	$txt = lookupField('pages','id','brief',$id);
	$txt = limit($txt ,$count);
}

?>
<div class="text">
		<div class="title"><?php echo $title; ?></div>
		<div class="text_content">
			<?php echo $txt; ?>
			<div class="more"><a href="<?php echo _PREF; ?>view/page/page.php?id=<?php echo $id; ?>"><?php echo More; ?> <img class='sp_more' src="images/search_button_<?php echo $pageLang; ?>.png" /></a></div>
		</div>
	</div>