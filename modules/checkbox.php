<?php require_once("../common/top.php");
$table = $_GET['t'];
$fname = $_GET['fn'];
$fvalue = ($_GET['fv']) ? "1" : "0";
$idname = $_GET['idn'];
$idvalue = $_GET['idv'];
if(@mysqli_query($GLOBALS["db_link_conn"], "UPDATE $table SET  $fname = '$fvalue' WHERE $idname = '$idvalue'")) echo $fvalue;
else echo !$fvalue;

if($table == 'mem_activities' || $table == 'news_news' || $table == 'resources'){
	if ($fvalue == '0'){
		@mysqli_query($GLOBALS["db_link_conn"], " DELETE FROM `highlight` WHERE table_name = '$table' AND record_id='$idvalue'");
	}else{
		@mysqli_query($GLOBALS["db_link_conn"], " INSERT INTO highlight (`table_name`,`record_id`) VALUES ('$table','$idvalue')");
	}
	
}
?>