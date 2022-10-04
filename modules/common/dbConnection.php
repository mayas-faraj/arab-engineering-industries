<?php
$dbHostname = DATABASE_URL;
$dbUsername = DATABASE_USER;
$dbPassword = DATABASE_PASS;
$dbName     = DATABASE_NAME; 


//  Make connection to database 
//  If no connection made, display error Message          
$GLOBALS["db_link_conn"] = mysqli_connect($dbHostname, $dbUsername, $dbPassword) OR DIE("Error !! Unable to connect to database");       

// Select the database name to be used or else print error message if unsuccessful*/
mysqli_select_db($GLOBALS["db_link_conn"], $dbName) or die( "Unable to select database ".$dbName); 
mysqli_query($GLOBALS["db_link_conn"], "SET NAMES 'utf8'"); 
?>
