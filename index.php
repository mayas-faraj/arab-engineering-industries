<?php
session_start();
$HP=1;
$dots='';
include_once("config.php");

if(!$_SESSION[SESSION_PREF.'pageLang']){ $_SESSION[SESSION_PREF.'pageLang']="en";}
if($_REQUEST['pageLang']=='en' OR $_REQUEST['pageLang']=='ar'){ $pageLang=$_SESSION[SESSION_PREF.'pageLang']=$_REQUEST['pageLang'];}
$pageLang=$_SESSION[SESSION_PREF.'pageLang'];
$_SESSION['pageLang']=$_SESSION[SESSION_PREF.'pageLang'];

include_once("modules/common/dbConnection.php");
include_once("lang/label_$pageLang.inc.php");
require_once("modules/includes/dbUtils.php");
include_once("modules/includes/pathUtil.php");

function mysqli_result($link, $res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}
$seo = getSEO($pageLang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
	<TITLE><?php echo $seo["title"]; ?></TITLE>
	<meta name="title" content="<?php echo $seo["title"]; ?>">
	<meta name="keywords" content="<?php echo $seo["keywords"]; ?>">
	<meta name="description" content="<?php echo $seo["description"]; ?>">
	<link rel="stylesheet" type="text/css" href='css/main_<?php echo $pageLang; ?>.css'/>
	<script type="text/javascript" src="js/jquery-1.6.3.js"></script>
	<!--***********************************Wedgits************************************-->	
	<!--********************************Wedgits fonts*********************************-->	
	<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/fonts/GE_SS_Two_Light/stylesheet.css'/>	

</head>
<body>

	<div class="main">
		
		<?include('wedgits/header/index_header.php')?>
		<?include('wedgits/user_login/user_login.php')?>
		<?include('wedgits/user_logout/user_logout.php')?>
		
		<?php include('wedgits/highlight/highlight.php')?>
		<?php include('wedgits/pages/page.php')?>
		<?php include('wedgits/blocks/blocks.php')?>

		<?include('wedgits/footer/footer.php')?>
	</div>
</body>
</html>
