<?php 
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php");
require_once("dbUtilsGallary.php");
if(checkGallogin()){  
	$id = $_POST['id'];
	$des = $_POST['des'];
	echo $sql = "update galleries_photos set description='$des' WHERE (id = '$id')";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
}
?>
