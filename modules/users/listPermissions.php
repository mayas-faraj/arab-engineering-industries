<?php include_once("../common/header-admin.php"); ?>
<h1 class="title"><?php echo Permissions?></h1>
<br/><br/>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];
if($sub){
	$permissions = addslashes($_REQUEST['permissions']);
	$grp_id = addslashes($_REQUEST['grp_id']);
	$per_arr = split(',',$permissions);
	
	@mysql_query("DELETE FROM permissions WHERE grp_id = '$grp_id'");
	
	$SQL= "INSERT INTO permissions (grp_id ,role_id ) VALUES ";
	for($i =0 ; $i < count($per_arr)-1 ; $i++)
		$SQL .= "('$grp_id' ,'$per_arr[$i]'),\n";
	$SQL = substr($SQL,0,-2); 
	$SQL .= ";";
	$result = mysql_query($SQL);
	if($result)	echo '<script>correctMessage("'.Record_Update.'")</script>';
}
?>
<?
$grp_id = $_REQUEST['grp_id'];
$pn =  $_REQUEST['pn'];
$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];
$LPP = _LPP;
$st = $pn*$LPP ;
$limit = "LIMIT $st,$LPP " ;
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;

$sql = "SELECT r.role_id , p.role_id FROM roles_forms r LEFT JOIN permissions p
 		ON r.role_id= p.role_id AND p.grp_id='$grp_id' GROUP BY r.role_id   ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows<=0) echo _Sorry;
if ($numberOfRows>0) {
$i=0;
?>
<form name="subForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input name="permissions" type="hidden">
<input name="permission" type="hidden">
<input type="hidden" value="<?php echo $grp_id?>" name="grp_id" />
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<?
while ($i<$numberOfRows){
	$p= MYSQL_RESULT($result,$i,"p.role_id");
	$r= MYSQL_RESULT($result,$i,"r.role_id");

?>
	<TR>
		<TD class="tableData"><input name="permission" type="checkbox" value="<?php echo $r; ?>" <?=($r==$p) ? "checked" : "" ?>  onClick="f();"> <?php echo lookupField('roles','role_id','role_name',$r) ?> </TD>
	</TR>
<?php 	$i++;
	}//End While
?>
</TABLE>
<br><br>
<? 
}// End numberOfRows ?> 

<div align="CENTER">
<input type="submit" value="<?php echo _Save?>" name="sub" onClick="return f();" />
<input type="button" value="<?php echo _GoBack?>" onClick="document.location='listUsers_groups.php?grp_id=<?php echo $grp_id?>';" />
</div>
</form>
<script>
function f(){
	var st = '';
	for (i = 0; i < subForm.permission.length; i++)
		if(subForm.permission[i].checked == true) st=st+subForm.permission[i].value+',' ;
	subForm.permissions.value=st;
	return true;
}
</script>

<?php include_once("../common/footer-admin.php"); ?>