<?
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	if(cleanString($_REQUEST['keyword'])){
		$keyword = cleanString($_REQUEST['keyword']);
	}else{
		$keyword = _Keyword;
	}
	echo "<form id='filter'>";
	
		echo "<div class='filter_title' dir='"._DIR."'>".Filter_By.":</div>";
		echo "<div class='styled-select'>";
			?><input type='text' id='keyword' name='keyword'  value='<?php echo $keyword; ?>' onfocus='$(this).attr("value","")' onblur='if($(this).attr("value")=="" && $(this).attr("value")!="<?php echo $keyword; ?>"){$(this).attr("value","<?php echo $keyword; ?>");}'/> <?
		echo "</div>";
		?>
		<div class="side_filter">
		<?
		echo "<input type='button' value='".reset_filter."' onClick='document.location=\"viewAllResources.php\"' class='filter' />";
		echo "<input type='submit' value='".Filter."' class='filter' />";
		?>
		</div>
		<?
	echo "</form>";
	
?>
