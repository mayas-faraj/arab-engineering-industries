<?php
@session_start();
if($_SESSION['GRP'] && $_SESSION['GRP'] != 1){
	header("Location:login/admin.php");
	exit();
}else{
	header("Location:login/login.php");
}
?>
