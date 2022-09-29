<?
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	echo "<form id='filter' method='post' >";
	
	echo "<div class='filter_title' dir='"._DIR."'>".Filter_By."</div>";
	//echo $_REQUEST['type'].''.$_REQUEST['level'].''.$_REQUEST['field'];
	echo "<input type='hidden' name='type' value='".cleanString($_REQUEST['type'])."'/>";
	echo "<div class='styled-select'>".createComboBox("fields", "id", "name_".$pageLang, cleanString($_REQUEST['field']), "field" , "styled-select", "", "", Fields)."</div>";
	echo "<div class='styled-select'>".createComboBox("levels", "id", "name_".$pageLang, cleanString($_REQUEST['level']), "level" , "styled-select", "", "", Levels)."</div>";
	
	?>
	<div class="side_filter">
	<?
	echo "<input type='button' value='".reset_filter."' onClick='document.location=\"viewAllActivities.php\"' class='filter' />";
	echo "<input type='submit' value='".Filter."' class='filter' />";
	?>
	</div>
	<?
	echo "</form>";
	
?>
