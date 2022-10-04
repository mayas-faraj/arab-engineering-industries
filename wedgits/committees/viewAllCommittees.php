<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/committees/committees_<?php echo $pageLang; ?>.css'/>	
<?php
if($pageLang=='en'){
	$id = 2;
	$brief_count = 350;
}else{
	$id = 1;
	$brief_count = 450;
}

if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
$LPP = 10;


$start = $pn*$LPP;
$limit = " LIMIT  $start, $LPP";

$currentdate=date("Y-m-d");
$whereStm = " WHERE  active='1' ";
 $sql = "SELECT * FROM mem_committees  $whereStm ORDER BY ord DESC $limit ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
?>
<div class='page_content'>
<div class='title2'><?php echo Committees; ?></div>
<?php
if ($numberOfRows>0) {
	$i=0;
	while ($i<$numberOfRows){
		$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
		$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
		$subject=stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"name_".$pageLang));
		
		$start_date=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"creation_date");
		if($start_date=='0000-00-00'){
			$start_date='';
		}else{
			if($pageLang == 'en'){
				$start_date=date('d / m / Y',strtotime($start_date));
			}else{
				$start_date=date('Y / m / d',strtotime($start_date));
			}
		}
		
		$brief=stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"brief_".$pageLang));
		$brief =  limit($brief, $brief_count);
		

				
					echo "
				<div class='activities_item' dir='"._DIR."'>
				
					
					
					<table class='activities_brief' cellspacing='0' cellpadding='0'>
						<tr>
							<td valign='top' ><span class='subtitle' onClick='document.location=\"viewCommittees.php?id=$id\"'>$subject</span></td>
						</tr>
						<tr><td><span class='ln_date_all'>$start_date</span></td></tr>
						<tr><td valign='top' onClick='document.location=\"viewCommittees.php?id=$id\"' style='cursor:pointer;'>$brief</td></tr>
					</table>
					
						
					<div class='sep_act'></div>
				</div>";
		$i++;
	}
	$tp = count_items("mem_committees", str_replace("WHERE", "", $whereStm));
	if($tp>0){
		if(($tp/$LPP)>1)
		echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
	}
}
	
?>
</div>

