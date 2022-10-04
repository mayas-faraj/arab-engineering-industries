<?php
include('top.php');
$dots='../../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
	<TITLE><?php echo $seo[title]; ?></TITLE>
	<meta name="title" content="<?php echo $seo[title]; ?>">
	<meta name="keywords" content="<?php echo $seo[keywords]; ?>">
	<meta name="description" content="<?php echo $seo[description]; ?>">
	<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>css/main_<?php echo $pageLang; ?>.css'/>
	<script type="text/javascript" src="<?php echo _PREF; ?>js/jquery-1.6.3.js"></script>
	<script type="text/javascript" src="<?php echo _PREF; ?>modules/includes/jquery/jconfirmaction.jquery.js" ></script>
	<!--***********************************Wedgits************************************-->	
	<!--********************************Wedgits fonts*********************************-->	
	<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/fonts/GE_SS_Two_Light/stylesheet.css'/>	
	<?$page_name = getCurrentFormName();?>
</head>

<body>

	<div class='main'>
		<?php include ($dots.'wedgits/user_login/user_login.php')?>
		<?php include ($dots.'wedgits/user_logout/user_logout.php')?>
		
		<?php include ($dots.'wedgits/preLoads/preLoads.php')?>
		<?php include ($dots.'wedgits/header/index_header.php')?>
		
		<div class='page_path'><?php echo get_current_path(); ?></div>
		<div class='site_inner_main_con'>
			<?php include ($dots.'wedgits/left_menu/left_menu.php')?>