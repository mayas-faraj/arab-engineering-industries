<?php 
session_start();
?>
<script>
function loadData(){
	var d=document.getElementById('des1').value;
	//alert(d)
	document.getElementById('des2').value=d;
}
</script>
<?php
include_once("../../../config.php");
include_once("../../common/dbConnection.php");
if(isset($_REQUEST['id'])){
	$Mid=$_REQUEST['id'];
	$_SESSION['Mid']=$Mid;
	$sql = "SELECT * FROM galleries_photos where id=$Mid LIMIT 1 ";
	$res= mysqli_query($GLOBALS["db_link_conn"], $sql);
	$rows = mysqli_num_rows($res);
	if ($rows>0) {
		$id= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"id");
		$des= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"description");
		?>معلومات عن الصور :<br><textarea cols="40" rows="4" id="des1" onkeyup="loadData()" ><?php echo $des; ?></textarea><?php
	}
}
else if(isset($_SESSION['Mid'])&&$_SESSION['Mid']!=0){
	/*----------------update----------- */
	$des=($_REQUEST['des']);
	$Mid=$_SESSION['Mid'];
	$sql2 = "UPDATE `galleries_photos` SET `description` = '$des' WHERE `id` =$Mid LIMIT 1 ;";
	$res2= mysqli_query($GLOBALS["db_link_conn"], $sql2);
	echo $_SESSION['Mid'];
	$_SESSION['Mid']=0;
}
?>
<script>loadData()</script>
