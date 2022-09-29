<? require_once("../common/top.php");
$table = $_GET['t'];
$fname = $_GET['fn'];
$fvalue = ($_GET['fv']) ? "1" : "0";
$idname = $_GET['idn'];
$idvalue = $_GET['idv'];
if(@mysql_query("UPDATE $table SET  $fname = '$fvalue' WHERE $idname = '$idvalue'")) echo $fvalue;
else echo !$fvalue;

if($table == 'mem_activities' || $table == 'news_news' || $table == 'resources'){
	if ($fvalue == '0'){
		@mysql_query(" DELETE FROM `highlight` WHERE table_name = '$table' AND record_id='$idvalue'");
	}else{
		@mysql_query(" INSERT INTO highlight (`table_name`,`record_id`) VALUES ('$table','$idvalue')");
	}
	
}
?>