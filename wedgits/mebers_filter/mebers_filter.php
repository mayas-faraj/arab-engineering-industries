<?
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	
	if(cleanString($_REQUEST['com'])){
		$keyword = cleanString($_REQUEST['com']);
	}else{
		$keyword = com_name;
	}
	
	echo "<form id='filter'>";
	
	echo "<div class='filter_title' dir='"._DIR."'>".Filter_By.":</div>";
	
	echo "<div class='styled-select'>".createComboBox("specialization", "id", "specialization_".$pageLang, cleanString($_REQUEST['specialization']), "specialization" , "styled-select", "", "", _FTR_SPECIALIZATION)."</div>";
	
	echo "<div class='styled-select'>".createComboBox("country", "id", "country_".$pageLang, cleanString($_REQUEST['country']), "country" , "styled-select", "", "",  _FTR_COUNTRY)."</div>";

	?>
	<div class='styled-select'><input type='text' id='keyword' name='com'  value='<?=$keyword?>' onfocus='$(this).attr("value","")' onblur='if($(this).attr("value")=="" && $(this).attr("value")!="<?=$keyword?>"){$(this).attr("value","<?=$keyword?>");}'/></div>
	<div class="side_filter">
	<?
	echo "<input type='button' value='".reset_filter."' onClick='document.location=\"viewAllMembers.php\"' class='filter' />";
	echo "<input type='submit' value='".Filter."' class='filter' />";
	?>
	</div>
	<?
	echo "</form>";
	
?>
