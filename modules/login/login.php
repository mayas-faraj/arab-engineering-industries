<?php
session_start();
include_once("../../config.php");
include_once("../common/dbConnection.php");
include_once("../includes/dbUtils.php");
include_once("../login/login.inc.php");
$curr_ip = VisitorIP();
/*$_SESSION['GRP'] = 2;
$_SESSION['USER'] = 2;
echo $_SESSION['GRP'];*/
if($_SESSION['GRP'] && $_SESSION['GRP'] != 1){
	//header("Location:admin.php");
	//exit();
}
if($_POST['submit']){
	$user=strip_tags($_REQUEST['user']);
	$pass=strip_tags($_REQUEST['pass']);
	
	$result = mysqli_query($GLOBALS["db_link_conn"],  " SELECT * FROM blocked_ips WHERE (ip='$curr_ip') " );
	if (mysqli_num_rows($result) > 0 ) {
		//echo "<div style='color:red; width:100%; float:left; text-align:center;'>Sorry: You are blocked because you have exceeded the allowed number of login attempts</div>";
	}else{
		if(!isset($_SESSION['log_count'.$curr_ip])){	
			$_SESSION['log_count'.$curr_ip] = 0;
		}else{
			$_SESSION['log_count'.$curr_ip]++;
		}
		if($_SESSION['log_count'.$curr_ip]>5){
			mysqli_query($GLOBALS["db_link_conn"], " INSERT INTO blocked_ips(ip) value('$curr_ip') ");
		}else{
			if(logfnc($user,$pass)){
				$_SESSION['log_count'.$curr_ip]=0;
				header("Location:admin.php");
			}
			else{
				$login_error= "<span style='width:600px;text-align:center;color:#f00;'>Incorrect username/password ! try again please! </span>";
			}
		}
	}
}
?>







<!DOCTYPE HTML>
<html lang="en-US">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enter CMS</title>
<style type="text/css">
body,td,th {
	color: #000;
	font-family:calibri;
	font-size:14px;
}
body {
	background: url(../../images/icons/adminVoila-bg.gif) top center repeat-x;
	padding-top: 498px;
	margin:0;
}
label{
	background:url(../../images/icons/adminVoila-label.png) no-repeat;
	width:74px;
	height:27px;
	color:#FFF;
	line-height:27px;
	position:absolute;
	padding-left:2px;
}
input{
	border:#000 1px solid;
	color:#000;
	margin-left:70px;
	height:24px;
	padding-left:4px;
}
.bt{
	background:url(../../images/icons/adminVoila-submit.png) no-repeat;
	width:74px;
	height:27px;
	color:#FFF;
	line-height:25px;
	border:0;
	margin-left:0;
}
.bt:hover{
	opacity:0.8;
	margin:0;
}
</style>
</head>
<body>
<?php
$result = mysqli_query($GLOBALS["db_link_conn"],  " SELECT * FROM blocked_ips WHERE (ip='$curr_ip') " );
if (mysqli_num_rows($result) > 0 ) {
	echo "<div style='color:red; width:100%; float:left; margin-left:-200px; text-align:center;'>Sorry: You been blocked because you exceeded the allowed number of login attempts</div>";
}else{?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="logAction" value="login">
<table width="960" height="78" border="0" align="center">
  <tr>
    <td width="230">
    <label for="username">Username</label><input type="text" name="user">   
     </td>
     <td width="230">
   	<label for="username">Password </label><input type="password" name="pass">  
    </td>
    <td width="560" align="left">
    <input type="submit" name="submit" value="LogIn" class="bt">
    </td>
    </tr>
</table>
<?}?>

</form>
</body>
</html>