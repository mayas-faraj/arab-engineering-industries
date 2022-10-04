<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/header/index_header_<?php echo $pageLang; ?>.css'/>	
<?php
if($_REQUEST['word']){
	$search = $_REQUEST['word'];
}else{
	$search = "Search";
}


?>
	<div id="header">
		<div id="header_logo"><a href="<?php echo _PREF; ?>index.php"></a></div>
		<div id="header_items">
			<div id="header_icons">
				
				<a id="header_icon1" href="<?php echo _PREF; ?>"></a>
				<a id="header_icon2" href="<?php echo _PREF; ?>view/sitemap/viewSitemap.php"></a>
				<a id="header_icon3" href="<?php echo _PREF; ?>view/contact/contact.php"></a>
				<?if($_SESSION["us_id"]){?>
					<a id="" href="#" class='logout'><?php echo Logout; ?></a>
				<?}else{?>
					<a id="header_icon4" href="#" class='show_m_form'></a>
				<?}?>
				
				<a class="lang_sw" href="<?php echo _PREF; ?>index.php?pageLang=<?php echo _SLANG; ?>"><?php echo ($pageLang=='ar')?_SLANGUAGE:''?></a>
				
			</div>
			<div id="header_search">
				<form action='<?php echo _PREF; ?>view/search/viewSearch.php' method='post'>
				
				<input type='submit' value=''/>
				<div><input type="text" value="<?php echo $search; ?>" name="word" onfocus='$(this).attr("value","")' onblur='if($(this).attr("value")=="" && $(this).attr("value")!="<?php echo $search; ?>"){$(this).attr("value","<?php echo $search; ?>");}' /></div>
			</form>
			</div>
		</div>
	</div>
	<?php include ($_SERVER['DOCUMENT_ROOT']._PREF.'wedgits/menu/menu.php')?>
