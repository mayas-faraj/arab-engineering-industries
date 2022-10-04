<?php
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("dbUtilsGallary.php");
if(checkGallogin()){  
	if(isset($_POST['path'])){
		$path=$_POST['path'];
		$actPath=$_POST['actPath'];
		echo loadFolders($path,$actPath);
	}
}
?>