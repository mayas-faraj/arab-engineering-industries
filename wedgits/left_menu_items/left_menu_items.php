<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/left_menu_items/left_menu_items_<?php echo $pageLang; ?>.css'/>
<?php
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	$act = cleanString($_REQUEST['act']);
	$cur_id = getMenuId(getFileURI(),$pageLang);
	$parent = $p_id = getTopParent($pageLang, $cur_id);
	if(!$p_id){$parent=$sub_menu_parent;}
	$menu_sql = "SELECT * FROM menus WHERE (lang = '$pageLang') AND (p_id ='$parent' && p_id<>0) order by item_order ASC";
	$menu_result = MYSQL_QUERY($menu_sql);
	$menu_numrows = MYSQL_NUMROWS($menu_result);
	if($menu_numrows==0){
		$current_form =  getCurrentFormName();
		$parent_link = get_parent_link($current_form);
		$parent_link = basename($parent_link[0]);
		if($parent_link){
			
			$p_id = getMenuId($parent_link,$pageLang);
			
			$menu_sql = "SELECT * FROM menus WHERE (lang = '$pageLang') AND (p_id ='$p_id' && p_id<>0) order by item_order ASC";
			$menu_result = MYSQL_QUERY($menu_sql);
			$menu_numrows = MYSQL_NUMROWS($menu_result);
		}
	}
	
	if ($menu_numrows>0) {
	?>
	
	<div class='left_menu_items'>
	<?php
		$i=0;
		while ($i<$menu_numrows){
			$p_id= MYSQL_RESULT($menu_result,$i,"menu_id");
			$p_item_name= MYSQL_RESULT($menu_result,$i,"item_label");
			$p_item_link= MYSQL_RESULT($menu_result,$i,"item_link");
			
			if($p_item_link  != '#'){
				$has_items = strrpos($p_item_link, "?");
				$uri = getFileURI();
				
					if($has_items){
						$p_item_link = $p_item_link;
					}else{
						$p_item_link = $p_item_link;
					}	
			}
			$uri = getFileURI();
			if( $uri && $uri != 'index.php' ){
				$cur_id = getMenuId(getFileURI(),$pageLang);
				$parent = getTopParent($pageLang, $cur_id);
			}
				
				$cur_url = $_SERVER["REQUEST_URI"];
				$isCurrent = strstr($cur_url,$p_item_link);
				if($isCurrent){
					$curr_class = 'curr_sub_item';
				}else{
					$curr_class = '';
				}
				
				echo "<div class='sub_menu_item $curr_class'>";
				
				

				if($p_item_link == '#'){
					echo "<a  href='#'><div class=''>$p_item_name</div></a>";
				}else{
					echo "<a  href='"._PREF."$p_item_link'><div class=''>$p_item_name</div></a>";
				}
				echo "</div>";
			
			
			$i++;
		}
		?>
		
</div>
		<?php
	}else{
		
	}
?>