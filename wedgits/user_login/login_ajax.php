<?php include_once("../../view/common/top.php"); 

$_SESSION['security_code']= "";
$pass = md5($_REQUEST['pass']);
$username = ($_REQUEST['username']);

$date = date('Y-m-d');
$work = "";

$SQL = "SELECT * FROM users WHERE username = '$username' AND password = '$pass'";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
$numrows = mysqli_num_rows($result);
if($numrows>0){
	$_SESSION["us_id"]=mysqli_result($GLOBALS["db_link_conn"], $result,0,'user_id');
	echo 1;
}else{
	echo 2 ;
}

 ?>