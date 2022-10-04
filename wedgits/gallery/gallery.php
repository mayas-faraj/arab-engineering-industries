	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/gallery/zoombox/zoombox.css'/>	
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/gallery/zoombox/zoombox.js"></script>
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/gallery/gallery.js"></script>

<!-- Start VideoLightBox.com HEAD section -->
<link rel="stylesheet" type="text/css" href="<?php echo _PREF; ?>wedgits/gallery/video_lightBox/css/videolightbox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo _PREF; ?>wedgits/gallery/video_lightBox/css/overlay-minimal.css"/>

<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/gallery/video_lightBox/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/gallery/video_lightBox/js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/gallery/video_lightBox/js/videolightbox.js"></script>

<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/gallery/gallery_<?php echo $pageLang; ?>.css'/>

<!-- End VideoLightBox.com HEAD section -->

<div class="page_content" dir='<?php echo _DIR; ?>'>
<?php
$gid = cleanString($_REQUEST['gid']);
if($gid){
	$lang_v = ($_SESSION['pageLang']=="ar")?'_ar':'';
	$gallery_name = lookupField('galleries_galleries','id','gallery_name'.$lang_v,$gid);
	?>
	<div class='title2'><?php echo $gallery_name; ?></div>
	<?php
	echo "<div class='gallery_show'>".ShowGallery3($gid)."</div>";
	
}


?>
<br/><br/>
<div class='back'><input type='button' value='<?php echo Back; ?>' class='more_btn' onClick='javascript:document.location="viewAllGalleries.php"'></div>

</div>