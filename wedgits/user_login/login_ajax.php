<?php include_once("../../view/common/top.php"); 

$_SESSION['security_code']= "";
$pass = md5($_REQUEST['pass']);
$username = ($_REQUEST['username']);

$date = date('Y-m-d');
$work = "";

$SQL = "SELECT * FROM users WHERE username = '$username' AND password = '$pass'";
$result = mysql_query($SQL);
$numrows = mysql_numrows($result);
if($numrows>0){
	$_SESSION["us_id"]=mysql_result($result,0,'user_id');
	echo 1;
}else{
	echo 2 ;
}

 ?>