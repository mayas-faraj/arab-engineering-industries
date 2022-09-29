<? 
include_once("../common/header.php");

$thisAction=$_REQUEST['action'];
if ($thisAction)
{
$thisUser_name=$_REQUEST['user'];
$thisE_mail=$_REQUEST['e_mail'];
$thisUserFull_name=$_REQUEST['full_name'];
$sql="select * from users where (name='$thisUser_name') and (full_name ='$thisUserFull_name')";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);
checkerror($result,$sql);
if ($numberOfRows > 0 ){
 $thisPass=rand();
 
 $message="You recently requested a new password to sign in to your SCS! account.<br>Your new password is:".$thisPass."<br>We encourage you to sign in now and change this password to something you can remember.php ";
 $message=$message."<br><br>Please note: To avoid sign-in problems, please make sure that cookies areenabled <br>in your browser and that the date and time are set correctly on your system clock.<br>";
 $message=$message."<br>***************************************************************";
 mail($thisUser_name,$thisE_mail,$message);
 $sql1="update  users  set  password ='$thisPass' where 
( name = '$thisUser_name') and (full_name ='$thisUserFull_name')";
 $result1 = MYSQL_QUERY($sql1);
 checkerror($result1,$sql1);?>
 <b  class="stylev"  > your password has been sent successfully</b>
 <?
}
else{
  ?>
<b class="stylev"  > wrong user name</b>
<?
   }
}
else
{
?>
<br><br>
<p class="styleh" align="center">forget your password </p>
<br>
<form method="post" >
<table width="90%" align="center"  cellpadding="2" cellspacing="1" >
  
    <tr> 
      <td height="10" align="center"  class="stylev"valign="middle">username:</td>
      <td height="10" width="50%"> <input type="text" class="textbox" name="user"></td>
    </tr>
   <tr> 
      <td height="10" class="stylev"align="center" valign="middle">full name:</td>
      <td height="10" width="50%"> <input type="text" class="textbox" name="full_name"></td>
    </tr>
  
   <tr> 
    <td height="10" class="stylev" align="center" valign="middle"> e_mail address</td>
    <td height="10"> <input type="text" class="textbox" name="e_mail"> </td>
    </tr>
	
    <tr bordercolor="#3F71A4" align="center" > 
      <td colspan="2">	 
<input type="button" name="cancel" value="<?php echo GoBack; ?>" onClick="javascript:window.location='../../index.php';">
<input type="submit" class="submit" value="Get New Password" name="action">  </td>
     </tr>
  </table>
</form>
<? }
include_once("../common/footer.php");
?>
