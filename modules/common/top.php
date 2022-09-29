<?
session_start();
include_once("../../config.php");
include_once("../../modules/common/dbConnection.php");
include_once("../../modules/login/login.inc.php");
include_once("../../modules/includes/dbUtils.php");
include_once("../../modules/includes/voting.inc.php");
$thisfile = getCurrentFormName();
$thisUserId = getCurrentUserId();
/*if($thisUserId=="") checkCurrentUser();
if(!authentication($thisfile) && $thisfile != "login") {
	echo '<script>
		if(history.length == 0) window.location="../../index.php";
		else	history.back();
	</script>';
}*/
$_SESSION['pageLang']="ar";
//if($_SESSION['pageLang']=="") $_SESSION['pageLang']="ar";
//if($_REQUEST['pageLang']) $pageLang=$_SESSION['pageLang']=$_REQUEST['pageLang'];
//else $pageLang=$_SESSION['pageLang'];
$pageLang=$_SESSION['pageLang'];

$pageDir=($pageLang=="ar")?"r":"l";

include_once("../../languages/label_$pageLang.inc.php");
require_once("../../modules/includes/pathUtil.php");
getSEO();
?>