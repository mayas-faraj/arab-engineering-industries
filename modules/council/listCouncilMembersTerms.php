<?php include _once("../common/header-admin.php");?>
<div class='head'><h1 class='title'>BOD Terms</h1></div>
<?php
/***********Print Header*************/
//print_ListAdminHead("BOD Terms","",  "enterNewCouncilMember.php",0, 0);
/***********Delete Option:*************/
$id =  $_REQUEST['id'];


/***********Query*************/

$sql = "SELECT * FROM terms order by start_year DESC";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);

/***********Print Result*************/

if ($numberOfRows<=0) echo "<div class='no_items_msg'>"._Sorry."</div><br/>";
if ($numberOfRows>0) {
$i=0;?>
<TABLE class="selectable" CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" id="list">
<thead>
<tr>
<th width="277"><?php echo print_AdminRecordHead("start_year", "Term", $sb, $so); ?></th>

</tr>
</thead>
<tbody>
<?php
while ($i<$numberOfRows){
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$start_year= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"start_year");
$end_year= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"end_year");
?>
<TR><TD><a href='listCouncilMembers.php?term=<?php echo $id; ?>'><?php echo stripslashes($start_year); ?>&nbsp; - &nbsp;<?php echo stripslashes($end_year); ?></TD></a></TR>
<?$i++;
}//End While?>
</tbody>
</TABLE>

<?php

?><br/><?php
}?>
<br/><br/>
<?php
include_once("../common/footer-admin.php"); ?>
