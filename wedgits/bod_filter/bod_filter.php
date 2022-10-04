<?php
	$page_name = getCurrentFormName();


	echo "<form id='filter' name='filter'>";
		$term_id = cleanString($_REQUEST['term_id']);
		echo "<div class='filter_title' dir='"._DIR."'>".Change_Term."</div>";
		echo "<div class='styled-select' onChange=\"document.forms['filter'].submit();\">";
		$terms_sql = "SELECT * FROM terms ORDER BY id DESC ";
		$terms_result = mysqli_query($GLOBALS["db_link_conn"], $terms_sql);
		$terms_numrows = mysqli_num_rows($terms_result);
		if($terms_numrows){
			echo "<select name='term_id'>";
			$i=0;
			while($i<$terms_numrows){
				$id = mysqli_result($GLOBALS["db_link_conn"], $terms_result,$i,'id');
				$start_year = mysqli_result($GLOBALS["db_link_conn"], $terms_result,$i,'start_year');
				$end_year = mysqli_result($GLOBALS["db_link_conn"], $terms_result,$i,'end_year');
				
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
