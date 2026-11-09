<?php  
// this function allows guest to browse the site with out password
//in case ther is no password entered the user is a guest 
function checkCurrentUser() {
   if($_SESSION['USER']=='')
    {
		logfnc("guest","");
	}
	   
}

function logfnc($user,$pass) {
  $login = false;
  $user = addslashes($user); 
  $passwd = md5($pass);
  $query = "SELECT * FROM users u WHERE (u.username='$user') AND (u.password = '$passwd') " ;
  $result = mysqli_query($GLOBALS["db_link_conn"], $query);
  if (!mysqli_num_rows($result) <=0 ) {
	echo'<script>
			alert("'.LoginError.'");
			document.location="../login/login.php"
		 </script>';
	exit();
  } else {
		$login = true;	// if they are in the database register the user for the session

		$_SESSION['USER'] = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "u.user_id");
		$_SESSION['USER_FOLDER'] = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "u.uploads_folder");
		
		$_SESSION['FULL_NAME'] = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "u.full_name");
				
		$_SESSION['GRP'] = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"u.grp_id"); 
		
   }
  return $login;
}

//function getCurrentFormName(){
//   $file  = substr(strrchr($_SERVER['PHP_SELF'],"/"),1);
//   $thisfile = substr($file ,0,strpos($file ,'.php'));
//   return $thisfile;
//}

function getCurrentUserId(){
  return $_SESSION['USER'];
}

function getUserFullName(){
  return $_SESSION['FULL_NAME'];
}

function getUserGrp(){
  return $_SESSION['GRP'];
}


// Check the permision to access this file
function authentication($thisfile) {
  $grp = $_SESSION['GRP'];	
  if($grp == 2 ) return (1 > 0);
  
  $sql_auth = "SELECT p.grp_id
   FROM
	  permissions p,
	  roles_forms rf,
	  forms f
   WHERE
        (p.grp_id = $grp)
    AND	(p.role_id = rf.role_id)
    AND (rf.form_id = f.form_id)
    AND (f.form_name = '$thisfile')";

$result = mysqli_query($GLOBALS["db_link_conn"], $sql_auth);
$numberOfRows = mysqli_num_rows($result);
return ($numberOfRows > 0);
}

function logout(){
 $lang = $_SESSION['pageLang'];
 session_destroy();
 $_SESSION['pageLang'] = $lang;
}


function session_authenticated(){
 //session_start();
  if(isset($_SESSION['HTTP_USER_AGENT']))
    {
     if( $_SESSION['HTTP_USER_AGENT']!= md5($_SERVER['HTTP_USER_AGENT']))
	   {return false;}
	 else return true;
    }
   else{
	      $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
          return true;
	   } 
}
 
?>
