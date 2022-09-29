<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/bod/bod_<?=$pageLang?>.css'/>	
<div class="page_content" dir='<?=_DIR?>'>
	<div class="title2"><?=bod?></div>

	<?
$photo_path ="../../uploads/";

$brief_count = 150;

if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
if(cleanString($_REQUEST['llp'])) {
	$LPP = cleanString($_REQUEST['llp']);
}else{
	$LPP = 6;
}

$members_ids = 0;
$start = $pn*$LPP;
$limit = " LIMIT  $start, $LPP";
$limit = "";
$term_id =  cleanString($_REQUEST['term_id']);
if(!$term_id){
	$terms_sql = "SELECT * FROM terms WHERE end_year = (SELECT MAX(end_year) FROM terms) ";
	$terms_result = mysql_query($terms_sql);
	$terms_numrows = mysql_numrows($terms_result);
	if($terms_numrows){
		$term_id = mysql_result($terms_result,0,'id');
	}	
}


$terms_sql = "SELECT * FROM term_members WHERE term_id = '$term_id' ";
$terms_result = mysql_query($terms_sql);
$terms_numrows = mysql_numrows($terms_result);
if($terms_numrows){
	$i=0;
	
	while($i<$terms_numrows){
		$member_id = mysql_result($terms_result,$i,'member_id');
		if(!$members_ids){
			$members_ids .= $member_id;
		}else{
			$members_ids .= ','.$member_id;
		}
		$i++;
	}
	
}


$whereStm = " WHERE mc.active='1' AND mc.id in($members_ids) AND term_id = '$term_id'";
$sql =  "SELECT *,`tm`.`position_$pageLang` as poss FROM  mem_council mc LEFT JOIN term_members tm  ON tm.member_id=mc.id $whereStm ORDER BY tm.ord ASC $limit ";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		$id=mysql_result($result, $i,"id");
		$position=mysql_result($result, $i,"poss");
		$name=mysql_result($result, $i,"name_".$pageLang);
		$company=mysql_result($result, $i,"company_".$pageLang);
		$country=mysql_result($result, $i,"country");
		$country = lookupField('country','id','country_'.$pageLang,$country);
		
		$photo = str_replace('','',mysql_result($result, $i,"photo"));
		
		$root_path ="../../uploads/";
		if($photo){
			$photos = basename($photo);
			$thumb = resizeToFile($root_path.$photo, 120 , 100 , $root_path."cash/bod_".$photos);
			$src = str_replace("../../", _PREF, $thumb );
		}else{
			$src = '../../css/def.png';		
		}
		
		?>
	<div class="bod_item">
		
		<div class="bod_content">
			<div onclick='document.location="<?=_PREF?>view/bod/viewBod.php?id=<?=$id?>"' class="bod_img_all"><img src=<?=$src ?> /></div>
			<div class="bod_txt">
				<div onclick='document.location="<?=_PREF?>view/bod/viewBod.php?id=<?=$id?>"' class="bod_title"><?=$name?> <?if($country){ echo ' - '.$country;}?></div>
				<div class='pos_div'> <?=$position?></div>
				<div class='com_div'><?=$company?></div>
			</div>
			<!--div class="more"><a href="<?=_PREF?>view/bod/viewBod.php?id=<?=$id?>"><?=More?><img src="<?=_PREF?>images/search_button_<?=$pageLang?>.png" /></a></div-->
		</div>

	
	</div>
		<?
		$i++;
	}
	/*$tp = count_items("mem_council", str_replace("WHERE", "", $whereStm));
	if($tp>0){
		if(($tp/$LPP)>1){
			echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
		}
	}*/
}

?>                                                   
                            

</div>