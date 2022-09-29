<?php
session_start();
require_once("../../config.php");
require_once("../common/top.php");
require_once("../includes/dbUtils.php");
include_once("login.inc.php");

if($_SESSION['pageLang']=="") $_SESSION['pageLang']="en";
if($_REQUEST['pageLang']) $pageLang=$_SESSION['pageLang']=$_REQUEST['pageLang'];
else $pageLang=$_SESSION['pageLang'];

$currentFile=$_REQUEST['currentFile']."&";


if(($_SESSION['USER']=='')||($_SESSION['USER']=='23')||($_SESSION['USER']==null))
{
	echo "<div class='userNavigation'><a href='"._PREF."'>"._Home."</a></div>
			<div class='userNavigation'><a href='"._PREF."forms/users/register.php'>"._Register."</a></div>
			<div class='userNavigation'><a href='#' class='showLogin'>"._Login."</a></div>
			<div class='userNavigation langNavigator' style='border:0;font-weight: bold;'><a href='{$currentFile}pageLang="._SLANG."'>"._SLANGUAGE."</a></div>
			<div class='userNavigation langNavigator'><a href='{$currentFile}pageLang="._LANG."'>"._LANGUAGE."</a></div>
			";
}
else
{
	echo "<div class='userNavigation'><a href='"._PREF."'>"._Home."</a></div>
	<div class='userWelcome'>"._Welcome." {$_SESSION['FULL_NAME']} | <a href='#' class='myProfile'>"._Profile."</a>

	<div class='userMenu'>
		<div class='userMenuItem'><a href='"._PREF."forms/auction/viewAllAuction.php?show=my'>"._MyProducts."</div>
		<div class='userMenuItem'><a href='"._PREF."forms/auction/addAuction.php'>"._AddProduct."</a></div>
		<div class='userMenuItem'><a href='"._PREF."forms/users/profile.php'>"._MyProfile."</a></div>
		<div class='userMenuItem'><a href='"._PREF."?logAction=logout'>"._Logout."</a></div>
	</div>
	
	</div>
	
		<div class='userNavigation langNavigator' style='border:0;font-weight: bold;'><a href='{$currentFile}pageLang="._SLANG."'>"._SLANGUAGE."</a></div>
		<div class='userNavigation langNavigator'><a href='{$currentFile}pageLang="._LANG."'>"._LANGUAGE."</a></div>
	";
}

?>