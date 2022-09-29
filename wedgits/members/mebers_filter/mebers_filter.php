<?
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	
	if($_REQUEST['com']){
		$keyword = $_REQUEST['com'];
	}else{
		$keyword = com_name;
	}
	
	echo "<form id='filter'>";
	
	echo "<div class='filter_title' dir='"._DIR."'>".Filter_By.":</div>";
	
	echo "<div class='styled-select'>".createComboBox("specialization", "id", "specialization_".$pageLang, $_REQUEST['specialization'], "specialization" , "styled-select", "", "", _FTR_SPECIALIZATION)."</div>";
	
	echo "<div class='styled-select'>".createComboBox("country", "id", "country_".$pageLang, $_REQUEST['country'], "country" , "styled-select", "", "",  _FTR_COUNTRY)."</div>";

	?>
	<div class='styled-select'><input type='text' id='keyword' name='com'  value='<?php echo $keyword; ?>' onfocus='$(this).attr("value","")' onblur='if($(this).attr("value")=="" && $(this).attr("value")!="<?php echo $keyword; ?>"){$(this).attr("value","<?php echo $keyword; ?>");}'/></div>
	<?
	echo "<input type='submit' value='".Filter."' class='filter' />";
	echo "<input type='button' value='".reset_filter."' onClick='document.location=\"viewAllMembers.php\"' class='filter' />";
	
	echo "</form>";
	
?>
