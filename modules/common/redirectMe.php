<?php
/**
 * @abstract This script is a generic redirector that can be included in the index of any directory 
 * to prevent the user from listing the files of this directory by redirecting the user to either
 * root of the site or to the file that will show all records that the user can see in this directory
 * 
 * In some cases the index in the directory can be overriden or customized to redirect to some specific
 * location i.e. do NOT leave it to this script's smartness to decide where to redirect, you can do this
 * by setting the session variable which is (PROJECT_PREFIX_{md5(dirname)})
 * 
 * How to use :
 * 
 * 		Create a file called index.php in each and every directory of your site
 * 		in this file write just one line :
 * 
 * 			include_once('../path/to/redirectMe.php');
 * 
 * 		to redirect to some custom location you should set the session varible of the directory before 
 * 		includin the script:
 * 
 * 			$_SESSION[PROJECT_PREFIX.'_'.md5($dirName)];
 * 
 * 		where $dirName is the parent folder name. 
 * 
 * @version 1.0
 * @author Ahmad Hajjar
 */
//To get all common staff include TOP File . . 
include_once 'top.php';

//Get path information for the file that requested redirection . .
$myPath=pathinfo($_SERVER['PHP_SELF']);

//Get the parent directory from the path . .
$myDir=explode("/", $myPath['dirname']);
$c=count($myDir)-1;
$folderName=$myDir[$c];

//Check to see if there is a User-defined location to redirect to . . 
$sessionVar=md5($folderName);
if(isset($_SESSION[PROJECT_PREFIX.'_'.$sessionVar]))
{
	//if there is a user-defined location redirect to it . .
	$redirectTo=$_SESSION[PROJECT_PREFIX.'_'.$sessionVar];
	//Clear your garbage
	unset($_SESSION[PROJECT_PREFIX.'_'.$sessionVar]);
}
else 
{
	//If there is not a user-defined location then use your smartness to guess where to redirect me . . 

	//Change the first letter in the parent folder name to Upper-case to match the case of the file to open in next step
	$firstLetter=strtoupper($folderName[0]);
	$folderName[0]=$firstLetter;
	
	//Form the file name . . 
	$redirectTo="$folderName.php";
}

//Check if the file exists . . 
if(file_exists($redirectTo))
{
	//if the file exists redirect to me to it . . 
	header("location: $redirectTo");
	exit();
}
else 
{
	//if it does not exist then go to root '/'
	header("location: "._PREF);
	exit();
}
?>