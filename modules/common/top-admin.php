<?
session_start();
include_once("../../config.php");
include_once("../common/dbConnection.php");
include_once("../login/login.inc.php");
include_once("../includes/dbUtils.php");
$thisfile = getCurrentFormName();
$thisUserId = getCurrentUserId();
if($thisUserId=="") checkCurrentUser();
if(!authentication($thisfile) && $thisfile != "login") {
	echo '<script>
		if(history.length == 0) window.location="../../index.php";
		else	history.back();
	</script>';
	exit;
}
$pageLang=$_SESSION['pageLang']="en";
include_once("../../languages/label_$pageLang.inc.php");
include_once("../includes/dbUtils.php");
//getSEO();


///Lang (this variable is used in DB operations: Data filtering & lang switcher)------------------------------
$lang_res = MYSQL_QUERY("SELECT * FROM languages");
$numberOfLang = MYSQL_NUMROWS($lang_res);
$def = "ar";
if($numberOfLang==1)	$def = MYSQL_RESULT($lang_res,0,"lang");
if(isset($_REQUEST['lang']) && $_REQUEST['lang']!= ''){$lang=$_REQUEST['lang'];$_SESSION['lang']=$lang;}
else if(isset($_SESSION['lang'])){$lang=$_SESSION['lang'];}else{$lang=$_SESSION['lang']=$def;}
//----------------------------------------------------------------------------------------------------

//common variables:
$so	= $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
$pn =  $_REQUEST['pn'];
$LPP = (isset($_REQUEST['llp']))?$_REQUEST['llp']:_LPP;
$st = $pn*$LPP ;
$limit = "LIMIT $st,$LPP " ;
$so    = ($so=="DESC")? "ASC" : "DESC" ; 
$sort  = (isset($sb))?"ORDER BY $sb $so":"" ;

$like =  $_REQUEST['like'];


switch($thisfile){
	case "editNews":
		$table = "news_news";
		$pk = "id";
		$request_name = "id";
		break;
	case "editActivity":
		$table = "mem_activities";
		$pk = "id";
		$request_name = "id";
		break;
	case "editComittee":
		$table = "mem_committees";
		$pk = "id";
		$request_name = "id";
		break;
	case "editmember":
		$table = "mem_members";
		$pk = "id";
		$request_name = "id";
		break;
	case "editCouncil":
		$table = "mem_council";
		$pk = "id";
		$request_name = "id";
		break;
		
}
$request_value = $_REQUEST[$request_name];
$creator_id = "creator_id";
if($table && ($_SESSION['USER'] != 2)){
	$cur_value = trim(lookupField($table, $pk, $creator_id, $request_value));
	if( $cur_value != $_SESSION['USER']){
		exit;
	}
}
$uploads_folder = lookupField('users','user_id','uploads_folder',$_SESSION['USER']);

?>