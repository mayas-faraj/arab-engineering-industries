<?php
	session_start();
 $lang = $_SESSION['pageLang'];
 session_destroy();
 $_SESSION['pageLang'] = $lang;
header("Location:login.php");
?>