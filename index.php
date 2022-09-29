<?
session_start();
$HP=1;
$dots='';

if(!$_SESSION[SESSION_PREF.'pageLang']){ $_SESSION[SESSION_PREF.'pageLang']="en";}
if($_REQUEST['pageLang']=='en' OR $_REQUEST['pageLang']=='ar'){ $pageLang=$_SESSION[SESSION_PREF.'pageLang']=$_REQUEST['pageLang'];}
$pageLang=$_SESSION[SESSION_PREF.'pageLang'];
$_SESSION['pageLang']=$_SESSION[SESSION_PREF.'pageLang'];

include_once("config.php");
include_once("modules/common/dbConnection.php");
include_once("lang/label_$pageLang.inc.php");
require_once("modules/includes/dbUtils.php");
include_once("modules/includes/pathUtil.php");

$seo = getSEO($pageLang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
	<TITLE><?=$seo[title]?></TITLE>
	<meta name="title" content="<?=$seo[title]?>">
	<meta name="keywords" content="<?=$seo[keywords]?>">
	<meta name="description" content="<?=$seo[description]?>">
	<link rel="stylesheet" type="text/css" href='css/main_<?=$pageLang?>.css'/>
	<script type="text/javascript" src="js/jquery-1.6.3.js"></script>
	<!--***********************************Wedgits************************************-->	
	<!--********************************Wedgits fonts*********************************-->	
	<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/fonts/GE_SS_Two_Light/stylesheet.css'/>	

</head>
<body>

	<div class="main">
		
		<?include('wedgits/header/index_header.php')?>
		<?include('wedgits/user_login/user_login.php')?>
		<?include('wedgits/user_logout/user_logout.php')?>
		
		<? include('wedgits/highlight/highlight.php')?>
		<? include('wedgits/pages/page.php')?>
		<? include('wedgits/blocks/blocks.php')?>

		<?include('wedgits/footer/footer.php')?>
	</div>
</body>
</html>
