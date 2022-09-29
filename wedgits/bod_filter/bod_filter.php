<?
	$page_name = getCurrentFormName();


	echo "<form id='filter' name='filter'>";
		$term_id = cleanString($_REQUEST['term_id']);
		echo "<div class='filter_title' dir='"._DIR."'>".Change_Term."</div>";
		echo "<div class='styled-select' onChange=\"document.forms['filter'].submit();\">";
		$terms_sql = "SELECT * FROM terms ORDER BY id DESC ";
		$terms_result = mysql_query($terms_sql);
		$terms_numrows = mysql_numrows($terms_result);
		if($terms_numrows){
			echo "<select name='term_id'>";
			$i=0;
			while($i<$terms_numrows){
				$id = mysql_result($terms_result,$i,'id');
				$start_year = mysql_result($terms_result,$i,'start_year');
				$end_year = mysql_result($terms_result,$i,'end_year');
				
				echo "<option ";
				if($id==$term_id){
					echo 'selected';
				}
				echo " value='$id'>$start_year - $end_year</option>";
				$i++;
			}
			echo "</select>";
			
		}
		echo "</div>";
	
	echo "</form>";
	
?>
