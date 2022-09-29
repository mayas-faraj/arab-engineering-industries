<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/sitemap/sitemap_<?php echo $pageLang; ?>.css'/>	
<div class="page_content" dir='<?php echo _DIR; ?>'>
<div class='title2'><?php echo Sitemap; ?></div>

<table width="100%" border="0" cellspacing="0" dir='<?php echo _DIR; ?>' cellpadding="0">


<?
$i=0;
$sql = "SELECT * FROM menus WHERE (lang = '$pageLang') ORDER BY p_id ,item_order ASC";
$menu = MYSQL_QUERY($sql);
$menus = MYSQL_NUMROWS($menu);
while($i<$menus){
	$menu_id=mysql_result($menu,$i,"menu_id");
	$item_label=mysql_result($menu,$i,"item_label");
	$item_link=mysql_result($menu,$i,"item_link");
	$p_id=mysql_result($menu,$i,"p_id");
	if($p_id==0){
                if( $item_link )
		         echo '<tr><td class="sitemap"><img src="'._PREF.'wedgits/sitemap/red_box.png" /> <a href="'._PREF.$item_link.'">'.$item_label.'</a></td></tr>';
               else
		         echo '<tr><td class="sitemap"><img src="'._PREF.'wedgits/sitemap/red_box.png" /> <a href="#">'.$item_label.'</a></td></tr>';
		$m=0;
		while($m<$menus){
			$menu_id2=mysql_result($menu,$m,"menu_id");
			$item_label2=mysql_result($menu,$m,"item_label");
			$item_link2=mysql_result($menu,$m,"item_link");
			$p_id2=mysql_result($menu,$m,"p_id");
			if($menu_id==$p_id2){
				if($item_link2)
                                        echo '<tr><td class="sitemap_sub"><img src="'._PREF.'wedgits/sitemap/red_arr_'.$pageLang.'.png" /> <a href="'._PREF.$item_link2.'">'.$item_label2.'</a></td></tr>';
                                 else
                                        echo '<tr><td class="sitemap_sub"><img src="'._PREF.'wedgits/sitemap/red_arr.png_'.$pageLang.'" /> <a href="#">'.$item_label2.'</a></td></tr>';
			}
			
			$m++;
		}
	}
	$i++;
}
?>
</table>
</div>