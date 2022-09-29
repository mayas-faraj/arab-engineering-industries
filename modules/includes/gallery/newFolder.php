<?
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("dbUtilsGallary.php");
if(checkGallogin()){  
	if(isset($_POST['p']) && isset($_POST['n'])){
		$c=$_POST['p'];
		$f=$_POST['n'];
		echo $dir='../../../uploads/'.$c.$f;
		mkdir($dir, 0700);
	}
}
?>