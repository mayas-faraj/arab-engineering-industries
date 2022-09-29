<?
include("../../config.php");
include("../../modules/common/dbConnection.php");
$table = $_GET['t'];
$fname = $_GET['fn'];
$fvalue = ($_GET['fv']) ? "1" : "0";
$idname = $_GET['idn'];
$idvalue = $_GET['idv'];
if(@mysql_query("UPDATE $table SET  $fname = '$fvalue' WHERE $idname = '$idvalue'")) echo $fvalue;
else echo !$fvalue;
?>