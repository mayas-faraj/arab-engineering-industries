<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/activities/activities_<?php echo $pageLang; ?>.css'/>	
<?php
if($pageLang=='en'){
	$id = 2;
	$brief_count = 120;
}else{
	$id = 1;
	$brief_count = 290;
}
$currentdate=date("Y-m-d");


$type = $_REQUEST['type'];
$level = $_REQUEST['level'];
$field = $_REQUEST['field'];

$whereStm = " WHERE  active='1' ";

if($type){
	$whereStm .= " AND atype ='$type' ";
}
if($level){
	$whereStm .= " AND alevel ='$level' ";
}
if($field){
	$whereStm .= " AND afield ='$field' ";
}

if($_SESSION['pageLang']=='ar'){
	$lang_prex = '_ar';
}

if(cleanString($_REQUEST['pn']))	$pn = cleanString($_REQUEST['pn']);
if(cleanString($_REQUEST['llp'])) {
	$LPP = cleanString($_REQUEST['llp']);
}else{
	$LPP = 10;
}
$start = $pn*$LPP;
$limit = " LIMIT  $start, $LPP";


$sql = "SELECT * FROM mem_activities  $whereStm ORDER BY activity_date DESC $limit ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
?>
<div class='page_content'>
<div class='title2'><?php echo Activities; ?></div>
<?php
if ($numberOfRows>0) {
	$i=0;
	while ($i<$numberOfRows){
		$id=mysql_result($result, $i,"id");
		$subject=stripslashes(mysql_result($result, $i,"subject".$lang_prex));
		$start_date=mysql_result($result, $i,"activity_date");
		if($start_date=='0000-00-00'){
			$start_date='';
		}else{
			if($pageLang == 'en'){
				$start_date=date('d / m / Y',strtotime($start_date));
			}else{
				$start_date=date('d / m / Y',strtotime($start_date));
			}
		}
		$end_date=mysql_result($result, $i,"end_date");
		$brief = stripslashes(mysql_result($result, $i,"brief".$lang_prex));
		$brief =  limit($brief, $brief_count);
		
		//if($end_date=='0000-00-00' OR $end_date>date('Y-m-d') OR $end_date==date('Y-m-d'))
		{
			$gallery=mysql_result($result, $i,"gal_id");
			$src='';
			$main_photo_id=0;
			
			if($gallery){
                            
				$main_photo_id = lookupField('galleries_galleries','id','main_photo',$gallery);
				$main_photo = basename(lookupField('galleries_photos','id','photo',$main_photo_id));
				$main_photo_folder = lookupField('galleries_photos','id','folder',$main_photo_id);
                                
				$photo_path = str_replace('//','/',"../../uploads/$main_photo_folder");
				$upload_path = str_replace('//','/',"../../uploads/");
				$thumb = basename(resizeToFile($photo_path.$main_photo, 60 , 60 , $upload_path."cash/viewAllActivities1_".$main_photo));	
			}	
					
			if($main_photo_id!=0){			
                            
				if(file_exists("../../uploads/cash/$thumb")){
                        
					$src = $upload_path.'cash/'.$thumb;
				}else{	
					$src = $photo_path.$main_photo;
                                        if($src==""){
                                            $src = '../../css/def_inner.png';		
                                        }
                                        
				}
			}else{
				$src = '../../css/def_inner.png';		
			}
			$link=_PREF."view/activities/viewActivities.php?id=$id";
			echo "
					<div class='activities_item' dir='"._DIR."'>
						<div class='subtitle'><span></span> <div class='ln_date'></div></div>
						
						<div class='activities_img'><table cellspacing='0' cellpadding='0'><tr><td align='center' valign='top'><img src='$src'/></td></tr></table></div>
						
						<table class='activities_brief' cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td valign='top' ><a href='$link'><span class='subtitle' >$subject</span></a></td>
								<td valign='top' rowspan='2' width='120px' class='date_cell'><span class='ln_date_all'>$start_date</span></td>
							</tr>
							<tr><td valign='top' onClick='document.location=\"viewActivities.php?id=$id\"' style='cursor:pointer;'>$brief</td></tr>
							
						</table>
						
							
						<div class='sep_act'></div>
					</div>";
			}
		
		$i++;
	}
	$tp = count_items("mem_activities", str_replace("WHERE", "", $whereStm));
	if($tp>0){
		if(($tp/$LPP)>1)
		echo "<div class='pagination_con'>".createPagination_simple($tp,$pn,$LPP)."</div>";
	}
}else{
	echo "<p>".no_result_found."</p>";
}
	
?>
</div>

