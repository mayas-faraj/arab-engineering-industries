<?
include('top.php');
$dots='../../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
	<TITLE><?=$seo[title]?></TITLE>
	<meta name="title" content="<?=$seo[title]?>">
	<meta name="keywords" content="<?=$seo[keywords]?>">
	<meta name="description" content="<?=$seo[description]?>">
	<link rel="stylesheet" type="text/css" href='<?=_PREF?>css/main_<?=$pageLang?>.css'/>
	<script type="text/javascript" src="<?=_PREF?>js/jquery-1.6.3.js"></script>
	<script type="text/javascript" src="<?=_PREF?>modules/includes/jquery/jconfirmaction.jquery.js" ></script>
	<!--***********************************Wedgits************************************-->	
	<!--********************************Wedgits fonts*********************************-->	
	<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/fonts/GE_SS_Two_Light/stylesheet.css'/>	
	<?$page_name = getCurrentFormName();?>
</head>

<body>

	<div class='main'>
		<?include($dots.'wedgits/user_login/user_login.php')?>
		<?include($dots.'wedgits/user_logout/user_logout.php')?>
		
		<?include($dots.'wedgits/preLoads/preLoads.php')?>
		<?include($dots.'wedgits/header/index_header.php')?>
		
		<div class='page_path'><?=get_current_path()?></div>
		<div class='site_inner_main_con'>
			<?include($dots.'wedgits/left_menu/left_menu.php')?>