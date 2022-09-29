<?php
session_start();
require_once("../../config.php");
require_once("../common/dbConnection.php");
require_once("../includes/dbUtils.php");
?>
<script type="text/javascript">
<!--
window.realAlert = window.alert;
window.alert = function() {};
//-->
</script>
<?
include_once("login.inc.php");

if($_SESSION['pageLang']=="") $_SESSION['pageLang']="en";
if($_REQUEST['pageLang']) $pageLang=$_SESSION['pageLang']=$_REQUEST['pageLang'];
else $pageLang=$_SESSION['pageLang'];

//un:user,
$user=$_REQUEST['un'];
$pass=$_REQUEST['pw'];

if(logfnc($user,$pass))
{
	$full_name=lookupField("users", "username", "full_name", $user);
	echo "Welcome $full_name!";
	echo "<script>window.location.reload();</script>";
}
else
{
	echo "Sorry, you failed to login!";
}

?>
<script type="text/javascript">
<!--
window.alert = window.realAlert;
//-->
</script>