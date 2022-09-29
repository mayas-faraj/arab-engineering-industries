<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/news/news_<?php echo $pageLang; ?>.css'/>	
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/news/news.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo _PREF; ?>wedgits/news/flexcrollstyles_<?php echo $pageLang; ?>.css" />
<script type="text/javascript" src="<?php echo _PREF; ?>wedgits/news/flexcroll.js"></script>
	
<?
$item_counts =3;
$root_path ="../../uploads/";
//$sql = "SELECT * FROM highlight_highlight where  lang='$pageLang' and active ='1' ORDER BY item_order DESC limit 0,$item_counts";
$sql = "SELECT * FROM highlight_highlight where (publish_date <= date(now())) AND (end_date >= date(now())) ORDER BY publish_date DESC ";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		
		$id= MYSQL_RESULT($result,$i,"id");
		$title= MYSQL_RESULT($result,$i,"title_".$pageLang);
		$brief= limit(MYSQL_RESULT($result,$i,"description_".$pageLang),400);
		$button_label= MYSQL_RESULT($result,$i,"type_".$pageLang);		
		$photo= MYSQL_RESULT($result,$i,"photo_".$pageLang);
		$link= str_replace('http://','',MYSQL_RESULT($result,$i,"link_".$pageLang));
		
		

		
		if($photo){
			$photo = basename($photo);
			$thumb = resizeToFile($root_path.$photo, 229 , 170 , $root_path."cash/news_".$photo);	
			$src = str_replace("../../", _PREF, $thumb );
			
		}else{
			$src = 'css/def_home.png';
		}
					
		
		$item_num = $i + 1;
		if($item_num==1)
		{
			$curr_high = 'curr_high';
			$curr_content = '';
		}	
		else
		{
			$curr_high = '';
			$curr_content = 'style="display:none;"';
		}

		$buttons .= '<div num="'.$item_num.'" id="bt'.$item_num.'" class="bt '.$curr_high.'" onclick="next_news('.$item_counts.','.$item_num.')"><a onmouseover="'."this.style.cursor='pointer'".'"><div class="bt_img bt_img'.$item_num.'">'.$item_num.'</div><div class="bt_txt">'.$button_label.'</div></a></div>';

		$contents .='
		<div class="news_block " id="news_block'.$item_num.'" '.$curr_content.'>
			<div class="news_content">
				<div class="news_content_img"><img src="'.$src.'" /></div>
				<div class="news_content_txt">
				'.$brief'
				</div>
			</div>
		</div>';

		$i++;
	}
}
?>
	
	<div id="news" dir='ltr'>
		<div id="news_number" class='flexcroll'>
			<?php echo $buttons; ?>
		</div>
		<?php echo $contents; ?>
	</div>
	
	
	<? echo"<script>var current;var timer_news = setTimeout('next_news($item_counts,1)',500);</script>"?>