<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/pages/page_<?=$pageLang?>.css'/>	

<?
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
		<div class="title"><?=$title?></div>
		<div class="text_content">
			<?=$txt?>
			<div class="more"><a href="<?=_PREF?>view/page/page.php?id=<?=$id?>"><?=More?> <img class='sp_more' src="images/search_button_<?=$pageLang?>.png" /></a></div>
		</div>
	</div>