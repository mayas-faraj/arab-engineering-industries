<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/menu/menu_<?php echo $pageLang; ?>.css'/>
<script src="<?php echo _PREF; ?>wedgits/menu/menu.js" language="javascript" type="text/javascript"></script>

<div class='menu' dir='<?php echo _DIR; ?>'>
	<ul id="cssdropdown">
	<?php
	$act = cleanString($_REQUEST['act']);
	$menu_sql = "SELECT * FROM menus WHERE (lang = '$pageLang') AND p_id=0 order by item_order ASC";
	$menu_result = MYSQL_QUERY($menu_sql);
	$menu_numrows = MYSQL_NUMROWS($menu_result);
	if ($menu_numrows>0) {
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
			if($i!=0){
				echo "<li class='seperator'> </li>";
			}
			if($p_item_link == '#'){
				echo "<li class='mainitems'>
					<a  href='#'>$p_item_name</a>";
			}else{
				if($p_id == $parent){
					echo "<li class='mainitems'>
					<a class='selected' href='"._PREF."$p_item_link'>$p_item_name</a>";
					$current_parent = $p_id;
				}else{
					echo "<li class='mainitems'>
					<a  href='"._PREF."$p_item_link'>$p_item_name</a>";
				}
			}	
			$sub_menu_sql = "SELECT * FROM menus WHERE (lang = '$pageLang') AND p_id='$p_id' order by item_order ASC";
			$sub_menu_result = MYSQL_QUERY($sub_menu_sql);
			$sub_menu_numrows = MYSQL_NUMROWS($sub_menu_result);
			if ($sub_menu_numrows>0) {
				echo "<ul class='subuls'>";
				$ii=0;
				while ($ii<$sub_menu_numrows){
					$sub_id= MYSQL_RESULT($sub_menu_result,$ii,"menu_id");
					$sub_item_name= MYSQL_RESULT($sub_menu_result,$ii,"item_label");
					$sub_item_link= MYSQL_RESULT($sub_menu_result,$ii,"item_link");
					
					if($sub_item_link == '#'){
						echo "<li ><a href='#' >$sub_item_name</a></li>";
					}else{
						echo "<li ><a href='"._PREF."$sub_item_link' >$sub_item_name</a></li>";
					}
					$ii++;
				}
				echo "</ul>";
			}
			echo "</li>";
			
			$i++;
		}
	}
	if($_SESSION["us_id"]){
		$uri = getFileURI();
		if ($uri=='viewAllCat.php'){$class='selected';}
		echo "<li class='mainitems'>
					<a  class='$class' href='"._PREF."view/forum/viewAllCat.php'>".Aricles."</a>
			</li>";
					
	}
	?>
	</ul>
</div>