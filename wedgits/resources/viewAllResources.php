<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/resources/resources_<?=$pageLang?>.css'/>	
<?
if($pageLang=='en'){
	$brief_count = 400;
}else{
	$brief_count = 500;
}
$currentdate=date("Y-m-d");
$keyword = cleanString($_REQUEST['keyword']);
if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
if(cleanString($_REQUEST['llp'])) {
	$LPP = cleanString($_REQUEST['llp']);
}else{
	$LPP = 20;
}
$start = $pn*$LPP;
$limit = " LIMIT  $start, $LPP";

$whereStm = " WHERE lang='$pageLang' ";
if($keyword && $keyword!=_Keyword){
	$whereStm .= " AND  keyword LIKE '%$keyword%' ";
}
$sql = "SELECT * FROM resources $whereStm ORDER BY id DESC $limit";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
?>
<div class='page_content'>
<div class='title2'><?=Resources?></div>
<?
if ($numberOfRows>0) {
		echo "<table cellspacing='0' class='recTable'>";
		$i=0;
		while ($i<$numberOfRows){
			$id=mysql_result($result, $i,"id");
			$subject=mysql_result($result, $i,"title");
			$brief=mysql_result($result, $i,"details");
			$brief =  limit($brief, $brief_count);
			
		?>
			<tr onClick='document.location="viewResources.php?id=<?=$id?>"'>
				<td class='art_title' align="<?=_SALI?>"><?=$subject?></td>
			</tr>
		<?	
						
			$i++;
		}
	echo "</table>";
	$tp = count_items("resources", str_replace("WHERE", "", $whereStm));
	if($tp>0){
		if(($tp/$LPP)>1){
			echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
		}
	}
}else{
	echo "<p>".no_result_found."</p>";
}
	


	
?>

</div>

