<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/members/members_<?php echo $pageLang; ?>.css'/>
<div class="page_content" dir='<?php echo _DIR; ?>'>
	<div class="title2"><?php echo MEMBERS; ?></div>
	<?
	$pn = 0;
	if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
	$LPP = 15;
	$start = $pn*$LPP;
	$limit = " LIMIT  $start, $LPP";
	
	
	$specialization = cleanString($_REQUEST['specialization']);
	$country = cleanString($_REQUEST['country']);
	$com = cleanString($_REQUEST['com']);
	
	$whereStmt = " WHERE m.country = c.id AND m.active = 1";
	if($specialization)		$whereStmt .= " AND ( m.specialization like '%,$specialization,%' OR m.specialization like '$specialization,%' OR m.specialization like '%,$specialization' OR m.specialization = '$specialization')";
	if($country)		$whereStmt .= " AND m.country='$country'";
	if($com&& $com!=com_name)		$whereStmt .= " AND ( m.name_".$pageLang." LIKE '%$com%' OR brief_".$pageLang." LIKE '%$com%' )";
	
	$sql = "SELECT * FROM mem_members m,country c  $whereStmt ORDER By c.country_".$pageLang.", m.name_".$pageLang." $limit";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);
	$i = 0;	
		
		
	if($numberOfRows>0){	
		echo "<table cellspacing='0' cellpadding='0' class='memTable'>
				<tr>
					<th  class='art_title' align="._SALI.">"._Member_name."</th>
					
					<th class='art_autor'>"._Member_specialty."</th>
					
					<th class='art_date' >"._Member_Country."</th>

				</tr>";
		
		while ($i<$numberOfRows){
			$id= MYSQL_RESULT($result,$i,"id");
			//$name = limit(MYSQL_RESULT($result,$i,"name_".$pageLang),25); 
			$name = MYSQL_RESULT($result,$i,"name_".$pageLang); 
			$specialization= MYSQL_RESULT($result,$i,"specialization");
			$specialization= lookupFieldAll("specialization", "id", "specialization_".$pageLang, $specialization);
			if(!$specialization){
				$specialization = '&nbsp;';
			}
			$country= MYSQL_RESULT($result,$i,"country");
			$active= MYSQL_RESULT($result,$i,"active");
			$products = MYSQL_RESULT($result,$i,"products".$pageLang); 
			$brief= MYSQL_RESULT($result,$i,"brief_".$pageLang); 
			$tel= MYSQL_RESULT($result,$i,"tel");
			$fax= MYSQL_RESULT($result,$i,"fax");
			$address= MYSQL_RESULT($result,$i,"address_".$pageLang); 
			$email= MYSQL_RESULT($result,$i,"email");
			$website= MYSQL_RESULT($result,$i,"website");
			$logo= MYSQL_RESULT($result,$i,"logo");

			?>
			
			
				<tr onClick='document.location="viewMember.php?id=<?php echo $id; ?>"'>
					<td class='art_title' align="<?php echo _SALI; ?>"><?php echo $name; ?></td>
					
					<td class='art_autor'><?php echo $specialization; ?></td>
					
					<td class='art_date' ><?php echo lookupField("country", "id", "country_".$pageLang, $country); ?></td>
					
				</tr>
			
			<?
			$i++;
		}
		echo "</table>";
		$tp = count_items("mem_members m , country c", str_replace("WHERE", "", $whereStmt));
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