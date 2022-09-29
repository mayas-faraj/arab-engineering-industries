<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/header/index_header_<?=$pageLang?>.css'/>	
<?
if($_REQUEST['word']){
	$search = $_REQUEST['word'];
}else{
	$search = Search;
}


?>
	<div id="header">
		<div id="header_logo"><a href="<?=_PREF?>index.php"></a></div>
		<div id="header_items">
			<div id="header_icons">
				
				<a id="header_icon1" href="<?=_PREF?>"></a>
				<a id="header_icon2" href="<?=_PREF?>view/sitemap/viewSitemap.php"></a>
				<a id="header_icon3" href="<?=_PREF?>view/contact/contact.php"></a>
				<?if($_SESSION["us_id"]){?>
					<a id="" href="#" class='logout'><?=Logout?></a>
				<?}else{?>
					<a id="header_icon4" href="#" class='show_m_form'></a>
				<?}?>
				
				<a class="lang_sw" href="<?=_PREF?>index.php?pageLang=<?=_SLANG?>"><?=($pageLang=='ar')?_SLANGUAGE:''?></a>
				
			</div>
			<div id="header_search">
				<form action='<?=_PREF?>view/search/viewSearch.php' method='post'>
				
				<input type='submit' value=''/>
				<div><input type="text" value="<?=$search?>" name="word" onfocus='$(this).attr("value","")' onblur='if($(this).attr("value")=="" && $(this).attr("value")!="<?=$search?>"){$(this).attr("value","<?=$search?>");}' /></div>
			</form>
			</div>
		</div>
	</div>
	<?include($_SERVER['DOCUMENT_ROOT']._PREF.'wedgits/menu/menu.php')?>

	