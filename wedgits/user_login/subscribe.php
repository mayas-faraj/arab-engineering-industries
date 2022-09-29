<?php include_once("../../view/common/top.php"); 

$_SESSION['security_code']= "";
$email = ($_REQUEST['email']);
$full_name = ($_REQUEST['full_name']);
$address = ($_REQUEST['address']);
$profession = ($_REQUEST['profession']);
$date = date('Y-m-d');
$work = "";

$SQL = "INSERT INTO mailing_list (email , uid , full_name , active , work, address, date ) VALUES ('$email' , '$uid' , '$full_name' , '1' , '$profession', '$address', '$date' )";
$result = mysql_query($SQL);
//echo "<script>document.location='"._PREF."'</script>";
if($result)
echo thanks_done;
else echo sorry_error ;

 ?>