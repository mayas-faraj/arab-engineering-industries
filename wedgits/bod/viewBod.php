<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/bod/bod_<?php echo $pageLang; ?>.css'/>	
<div class="page_content" dir='<?php echo _DIR; ?>'>

	<?php
$photo_path ="../../uploads/";
$id = cleanString($_REQUEST['id']);

$sql =  "SELECT * FROM  mem_council where id = '$id'";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		$id=mysql_result($result, $i,"id");
		$position=mysql_result($result, $i,"position_".$pageLang);
		$name=mysql_result($result, $i,"name_".$pageLang);
		$company=mysql_result($result, $i,"company_".$pageLang);
		$country=mysql_result($result, $i,"country");
		$country = lookupField('country','id','country_'.$pageLang,$country);
		$biography=mysql_result($result, $i,"biography_".$pageLang);
		$address=mysql_result($result, $i,"address_".$pageLang);
		$terms=mysql_result($result, $i,"terms");
		$tel=mysql_result($result, $i,"tel");
		$fax=mysql_result($result, $i,"fax");
		$email=mysql_result($result, $i,"email");
		$website= str_replace('http://','',mysql_result($result, $i,"website"));
		
		if(!$terms){$terms=0;}
		
		$photo = mysql_result($result, $i,"photo");
		
		$root_path ="../../uploads/";
		if($photo){
			$photos = basename($photo);
			$thumb = resizeToFile($root_path.$photo, 150 , 200 , $root_path."cash/bodSingle_".$photos);
			$src = str_replace("../../", _PREF, $thumb );
			if(!file_exists($thumb)){
				$src = "../../uploads/".$photo;
			}
			
		}else{
			$src = '../../css/def.png';		
		}
		
		?>
	
	
		<div class="bod_img"><img src=<?php echo $src; ?> /></div>
		
		<table class="mem_info">
			<tr><td colspan='3'><div class="title2"><?php echo $name; ?></div></td></tr>
			<tr><td class='bod_lb' valign="top"><?php echo Company; ?>: </td><td colspan='2'><?php echo $company; ?></td></tr>
			<tr><td class='bod_lb fixed_h' width="60px"  valign="top"><span><?php echo Position; ?>: </span></td><td width="230px"><span><?php echo $position; ?></span></td>
				<td rowspan="7" valign="top">
				<table class="term_block"><tr><td valign="top">	
				<h2><?php echo TERMS; ?></h2>
				<?php
					$sql =  "SELECT * FROM  terms t, term_members tm where tm.term_id=t.id AND tm.member_id='$id' ORDER BY t.id DESC";
					$result = MYSQL_QUERY($sql);
					$numrows = MYSQL_NUMROWS($result);
					if($numrows>0){
						//echo "<div class='subtitle'>".Terms."</div>";
						while($i<$numrows){
							$start_year=mysql_result($result, $i,"start_year");
							$end_year=mysql_result($result, $i,"end_year");
							$position=mysql_result($result, $i,"position_".$pageLang);
							echo "<div class='page_dt'>$start_year - $end_year: $position</div>";
							$i++;
						}
					}
					
				?>
				</td></tr></table>
				</td>
			</tr>
			<tr><td class='bod_lb fixed_h' valign="top"><?php echo Country; ?>: </td><td><?php echo $country; ?></td></tr>
			
			<?if($tel){?><tr><td class='bod_lb fixed_h'  valign="top"><?php echo Phone; ?>: </td><td  dir='ltr'><span dir='ltr'><?php echo $tel; ?></span></td></tr><?}?>
			<?if($fax){?><tr><td class='bod_lb fixed_h'  valign="top"><?php echo Fax; ?>: </td><td  dir='ltr'><span dir='ltr'><?php echo $fax; ?></span></td></tr><?}?>
			<?if($email){?><tr><td class='bod_lb fixed_h'  valign="top"><?php echo E_mail; ?>: </td><td><?php echo $email; ?></td></tr><?}?>
			<?if($website){?><tr><td class='bod_lb fixed_h'  valign="top"><?php echo Website; ?>: </td><td><a href='<?php echo 'http://'.str_replace('http://','',$website); ?>' target=''><?php echo $website; ?></a></td></tr><?}?>
			<?if($address){?><tr><td class='bod_lb'  valign="top"><span><?php echo Address; ?>: </span></td><td colspan='2' align='<?php echo _SALI; ?>'><span><?php echo $address; ?></span></td></tr><?}?>
			<tr><td class='bod_lb'  valign="top" colspan="2"></td></tr>
		</table>
		
		<br/>

		
			<?if($biography){
				//echo "<div class='subtitle'>".Biography."</div>";
				
				echo "<div class='page_dt'> $biography </div>";
			}
			?>
		
		<br/><br/><br/>
		


		<?php
		$i++;
	}
}

?>                                                   
                            
<input type='button' value='<?php echo Back; ?>' class='more_btn' onClick='history.back()'/>
</div>