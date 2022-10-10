<?php
$pageLang=$_SESSION['pageLang'];

include_once("../../config.php");
include_once("../../modules/common/dbConnection.php");
include_once("../../lang/label_$pageLang.inc.php");
require_once("../../modules/includes/dbUtils.php");
include_once("../../modules/includes/pathUtil.php");
session_start();
$HP=1;
if(!$_SESSION[SESSION_PREF.'pageLang']){ $_SESSION[SESSION_PREF.'pageLang']="en";}
if($_REQUEST['pageLang']=='en' OR $_REQUEST['pageLang']=='ar'){ $pageLang=$_SESSION[SESSION_PREF.'pageLang']=$_REQUEST['pageLang'];}
$pageLang=$_SESSION[SESSION_PREF.'pageLang'];
$_SESSION['pageLang']=$_SESSION[SESSION_PREF.'pageLang'];

/*$pageLang='ar';
$_SESSION['pageLang']='ar';*/
$seo = getSEO($pageLang);
?>
