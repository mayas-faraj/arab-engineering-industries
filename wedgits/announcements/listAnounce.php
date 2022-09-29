<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/announcements/announcements_<?=$pageLang?>.css'/>	


<div class='page_content'>
<div class='title2'><?=Announcements?></div>
<?
$photo_path ="../../uploads/";

$brief_count = 150;

if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
if(cleanString($_REQUEST['llp'])) {
	$LPP = cleanString($_REQUEST['llp']);
}else{
	$LPP = 4;
}
$start = $pn*$LPP;
$limit = " LIMIT  $start, $LPP";

$whereStm = " WHERE (publish_date <= date(now())) and  active='1' ";
$sql =  "SELECT * FROM news_news  $whereStm ORDER BY publish_date DESC, id DESC  $limit";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		$id=mysql_result($result, $i,"id");
		if($pageLang=='ar'){$langPref = '_ar';}else{$langPref = '';}
		$subject=mysql_result($result, $i,"subject".$langPref);
		$brief=limit(mysql_result($result, $i,"brief".$langPref),$brief_count);

		$start_date=mysql_result($result, $i,"publish_date");
		if($start_date=='0000-00-00'){
			$start_date='';
		}else{
			if($pageLang == 'en'){
				$start_date=date('d / m / Y',strtotime($start_date));
			}else{
				$start_date=date('d / m / Y',strtotime($start_date));
			}
		}
		
		$prepared = mysql_result($result, $i,"prepared");
		
		$gallery= MYSQL_RESULT($result,$i,"gallery");		
		$src='';
		$main_photo_id=0;
		if($gallery){
			$main_photo_id = lookupField('galleries_galleries','id','main_photo',$gallery);
			$main_photo = basename(lookupField('galleries_photos','id','photo',$main_photo_id));
			$folder = lookupField('galleries_galleries','id','folder',$gallery);
			$photo_path = str_replace('//','/',"../../uploads/$folder/");
			$upload_path = str_replace('//','/',"../../uploads/");
			$thumb = basename(resizeToFile($photo_path.$main_photo, 115 , 109 , $upload_path."cash/viewAllAnnouncement_".$main_photo));	
		}	
					
		if($main_photo_id!=0){			
			if(file_exists("../../uploads/cash/$thumb")){
				$src = $upload_path.'cash/'.$thumb;
			}else{	
				$src = $photo_path.$thumb;		
			}
		}else{
			$src = '../../css/def.png';		
		}
		

		/*echo "
				<div class='activities_item' dir='"._DIR."'>
					<div class='activities_img'><table cellspacing='0' cellpadding='0'><tr><td align='center' valign='top'><img style='cursor:pointer;' onClick='document.location=\"viewAnnounceDetails.php?id=$id\"' src='$src'/></td></tr></table></div>
					<table class='activities_brief' cellspacing='0' cellpadding='0'>
						<tr>
							<td valign='top' ><span style='cursor:pointer;' class='subtitle' onClick='document.location=\"viewAnnounceDetails.php?id=$id\"'>$subject</span></td>
							<td valign='top' rowspan='2' width='100px' align='right'><span class='ln_date_all'>$start_date</span></td>
						</tr>
						<tr><td colspan='2' valign='top'>$brief</td></tr>
					</table>
					<div class='sep_act'></div>
				</div>";*/
		echo "
					<div class='activities_item' dir='"._DIR."'>
						<div class='subtitle'><span></span> <div class='ln_date'></div></div>
						
						<div class='activities_img'><table cellspacing='0' cellpadding='0'><tr><td align='center' valign='top'><img src='$src'/></td></tr></table></div>
						
						<table class='activities_brief' cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td valign='top' ><span class='subtitle' onClick='document.location=\"viewAnnounceDetails.php?id=$id\"'>$subject</span></td>
								<td valign='top' rowspan='2' width='120px' class='date_cell'><span class='ln_date_all'>$start_date</span></td>
							</tr>
							<tr><td valign='top' onClick='document.location=\"viewAnnounceDetails.php?id=$id\"' style='cursor:pointer;'>$brief</td></tr>
							
						</table>
						
							
						<div class='sep_act'></div>
					</div>";
		
		$i++;
	}
	$tp = count_items("news_news", str_replace("WHERE", "", $whereStm));
	if($tp>0){
		if(($tp/$LPP)>1)
		echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
	}
}
	
?>
</div>

