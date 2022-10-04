<?php
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("dbUtilsGallary.php");
if(checkGallogin()){  
	if(isset($_POST['id'])){
		$id=$_POST['id'];
		$gid=$_SESSION['gid'];	
		$sql2="update galleries_galleries set main_photo='$id' where id='$gid'";
		$res2=mysql_query($sql2);
	}
}
?>