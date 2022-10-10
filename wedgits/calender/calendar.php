<?php
header("cache-control: no-cache"); 
include_once("../../config.php");
include_once("../../lang/label_$pageLang.inc.php");
include_once("../../modules/common/dbConnection.php");
include_once("../../modules/includes/dbUtils.php");
//check if time is set in the URL
//$pl="ar";
$pl=$_REQUEST['pl'];
if(isset($_GET['time']))
	$time = $_GET['time'];
else
	$time = time();

$today = date("Y/n/j", time());
$current_month = date("n", $time);
$current_month2 = date("m", $time);
$current_year = date("Y", $time);
//include_once("../../lang/label_$pl.inc.php");
if($pl=='en'){
$current_month_text=array("","January","February","March","April","May","June","July","August","September","October","November","December");
$days=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
$Dir="ltr";
}else{
$current_month_text=array("","January","February","March","April","May","June","July","August","September","October","November","December");
$current_month_text_ar=array("","كانون الثاني","شباط","أذار","نيسان","أيار","حزيران","تموز","آب","أيلول","تشرين الأول","تشرين الثاني","كانون الأول");
$days=array("ح","ن","ث","ر","خ","ج","س");
$Dir="rtl";
}


//$current_month_text = date("F Y", $time);
$total_days_of_current_month = date("t", $time);

$sMonth=intval($current_year.$current_month2."01");
$eMonth=intval($current_year.$current_month2."31");
$events = array();
$events_type = array();

$result = mysqli_query($GLOBALS["db_link_conn"], "SELECT * FROM events_events " );
$mn=mysqli_num_rows($result);
while($row_event = mysqli_fetch_array($result)){
	/*$Eid=$row_event['id'];
	$Es=$row_event['start_date'];
	$Ee=$row_event['start_date'];
	$Ety=1;//$row_event['eventType'];
	$Eti=$row_event['title_'.$pl];
	$Ec=limit($row_event['brief_'.$pl],50);
	$Ed=limit($row_event['brief_'.$pl],50);*/
	if($pl=='ar'){
		$lang_pref = '_ar';
	}else{
		$lang_pref = '';
	}
	$Eid=$row_event['id'];
	$Es=$row_event['publish_date'];
	$Ee=$row_event['publish_date'];
	$Ety=1;//$row_event['event_type'];
	$Eti=$row_event['subject'.$lang_pref];
	$Ec=$row_event['details'.$lang_pref];
	$Ed='<p>'.$row_event['brief'.$lang_pref].'</p>';
	$link=$row_event['link'];
	
	
	$Ess=str_replace("-","",$Es);
	$Eee=str_replace("-","",$Ee);
	$Ds=0;
	$De=0;
	if($sMonth<=$Ess && $Eee<=$eMonth){
		$Ds=intval(substr($Ess,6,2));
		$De=intval(substr($Eee,6,2));
	}
	elseif($sMonth>=$Ess && $Eee<=$eMonth && $Eee>=$sMonth){
		$Ds=1;
		$De=intval(substr($Eee,6,2));
	}
	elseif($sMonth<=$Ess && $Eee>=$eMonth && $Ess<=$eMonth){
		$Ds=intval(substr($Ess,6,2));
		$De=$total_days_of_current_month;
	}
	elseif($Ess<=$sMonth && $eMonth<=$Eee){
		$Ds=1;
		$De=$total_days_of_current_month;
	}

	for($DD=$Ds;$DD<$De+1;$DD++){
		$events[intval($DD)] .= '<li>';
		
		if($link){
			$events[intval($DD)] .='<a href="javascript:Swin('.$Eid.')" class="popup">';
		}else{
			$events[intval($DD)] .='<a class="popup">';
		}
		
		
		$events[intval($DD)] .='<span class="title">'.stripslashes($Eti).'</span>
		<span class="desc">'.stripslashes($Ec).'</span></a><br/>'.stripslashes($Ed).'</li>';
		if($events_type[intval($DD)]!=$Ety){
			$events_type[intval($DD)] .=$Ety;
		}
	}
}							
$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
$first_w_of_month = date("w", $first_day_of_month);
//how many rows will be in the calendar to show the dates
$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
//trick to show empty cell in the first row if the month doesn't start from Sunday
$day = -$first_w_of_month;

$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
$next_month_text = date("F \'y", $next_month);

$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
$previous_month_text = date("F \'y", $previous_month);

$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
$next_year_text = date("F \'y", $next_year);

$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
$previous_year_text = date("F \'y", $previous_year);
?>
<script src="<?php echo _PREF; ?>wedgits/calender/js/coda.js" type="text/javascript"> </script>


<div id="Evt" style="display:none"></div>

<table border="0" align="center" cellpadding="0" cellspacing="0" class="current_month" dir="ltr">
	<tr>

		
		<?if($pl=='en'){?>
			<td width="13"><a href="javascript:getNextTime(<?php echo $previous_month; ?>)"><img src="<?php echo _PREF; ?>wedgits/calender/left_arrow.png"  border="0" /></a></td>
			<td width="160" align="center"><?php echo $current_month_text[$current_month].' - '.$current_year; ?></td>
			<td width="13"><a href="javascript:getNextTime(<?php echo $next_month; ?>)"><img src="<?php echo _PREF; ?>wedgits/calender/right_arrow.png"  border="0" /></a></td>
		<?}else{?>
			<td width="13"><a href="javascript:getNextTime(<?php echo $next_month; ?>)"><img src="<?php echo _PREF; ?>wedgits/calender/left_arrow.png"  border="0" /></a></td>
			<td width="160" align="center"><?php echo $current_month_text_ar[$current_month].' - '.$current_month_text[$current_month].' - '.$current_year; ?></td>
			<td width="13"><a href="javascript:getNextTime(<?php echo $previous_month; ?>)"><img src="<?php echo _PREF; ?>wedgits/calender/right_arrow.png"  border="0" /></a></td>
		<?}?>
		
		
		

	</tr>
</table>

<div class='cal_header'></div>
<table align="center" cellspacing="0" cellpadding="0" border="0" class="cal" >
<tr id='days_title'><td><?php echo $days[0]; ?></td><td><?php echo $days[1]; ?></td><td><?php echo $days[2]; ?></td><td><?php echo $days[3]; ?></td><td><?php echo $days[4]; ?></td><td><?php echo $days[5]; ?></td><td><?php echo $days[6]; ?></td></tr>
<tr style="height:5px;"></tr>
<tr class="first_row">
<?php
for($i=0; $i< $total_rows; $i++){
	$ee='';
	for($j=0; $j<7;$j++){
		$day++;					
		$ee="";
		$cls="";
		if(($j == 5) || ($j == 6)){
			$cls='class="holiday"';
		}
		else $border_off = '';
		$date_form = "$current_year/$current_month/$day";
		if($date_form == $today){
			$cls='class="today"';
		}else{
			//$cls='class="day_td"';
		}
		if($day>0 && $day<=$total_days_of_current_month){
			//YYYY-MM-DD date format			
			echo '<td  onMouseOver="s(1,'.$day.')" onMouseOut="s(0,'.$day.')" '.$cls.'>
			<table  dir="'._DIR.'" width="25" border="0" cellspacing="0" cellpadding="0">
			<tr></td>
			<td class="day_td" style="border:0;" width=""';
			if($date_form == $today){
				//echo 'class="today"';
			}
			if(array_key_exists($day,$events)	&& ($events_type[intval($day)] == '2')){
				if($date_form == $today){echo '';}else{echo '';}
				
			}elseif(array_key_exists($day,$events)	&& ($events_type[intval($day)] == '1')){
				if($date_form == $today){echo '';}else{echo '';}
			}else{
				echo'"';
			}
			echo '>'.$day.'</td></tr></table>';
			if(array_key_exists($day,$events)){
				echo '<div class="events" id="d'.$day.'" dir="'._DIR.'"><ul>'.$events[$day].'</ul></div>';
					/*if($events_type[$day]>2){
						$ee='<img src="'._PREF.'images/e1.png"/><br><img src="'._PREF.'images/e2.png"/>';	
											
					}else{
						$ee='<img src="'._PREF.'images/e'.$events_type[$day].'.png"/>';	
					}*/

						echo $ee='<img class="event_ind" src="'._PREF.'wedgits/calender/e1.png"/>';	

				
			}
		}else {
			//showing empty cells in the first and last row
			echo '<td class="padding">&nbsp;</td>';
		}
		
		?><script>
		if(document.getElementById('eee<?php echo $day; ?>')){
			//$('#eee<?php echo $day; ?>').innerHTML= '<?php echo $ee; ?>';
			//alert($('#eee<?php echo $day; ?>').css('background-color','red'))//innerHTML= '<?php echo $ee; ?>';
			//alert('<?php echo $day; ?>');
		}
        </script> <?php
	}
	echo "</tr><tr>";
	
}

?>
</tr>
</table>


<script>
$('document').ready(function(){
	$('.cal td:last-child').css('border','solid 1px #6b6b6a');
	$('.cal td:last-child').css('border-top','0');
	$('.cal td:last-child').css('border-top','0');
	$('.first_row td:last-child').css('border-top','1px solid #6b6b6a');
	$('#days_title td').css('border-top','1px solid #6b6b6a');
	
	$('td.day_td').css('border-top','0');
	$('td.day_td').css('border','0');

});
function s(s,D){
	if(document.getElementById('d'+D)){
		if(s==1){
			document.getElementById('d'+D).style.display="block";
		}else{
			document.getElementById('d'+D).style.display="none";
		}
	}
}
function Swin(id){
	document.location='http://'+'<?php echo $link; ?>'
	/*var rn =Math.random();
	ajaxPage='<?php echo _PREF; ?>all/viewEvents.php';
	$.get(ajaxPage,{ id:id ,rndom:rn }, function(data){
		$('#Evt').html(data);
		$('#Evt').dialog("open");
	});*/

}



</script>

