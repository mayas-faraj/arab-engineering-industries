<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/members/members_<?php echo $pageLang; ?>.css'/>
<div class="page_content" dir='<?php echo _DIR; ?>'>
	
	<?php
	$mid = cleanString($_REQUEST['id']);
	$sql = "SELECT * FROM mem_members WHERE id = '$mid'";
	$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
	$numberOfRows = mysqli_num_rows($result);
	$i = 0;	
	if($numberOfRows>0){
			$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
			$name = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"name_".$pageLang); 
			$specialization= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"specialization");
			$specialization= lookupFieldAll("specialization", "id", "specialization_".$pageLang, $specialization);
			$country= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"country");
			$country= lookupField("country", "id", "country_".$pageLang, $country);
			
			$products = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"products_".$pageLang); 
			$representer = mysqli_result($GLOBALS["db_link_conn"], $result,$i,"representer_".$pageLang); 
			$brief= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"brief_".$pageLang); 
			$tel= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"tel");
			$fax= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"fax");
			$address= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"address_".$pageLang); 
			$email= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"email");
			$website= str_replace('http://','',mysqli_result($GLOBALS["db_link_conn"], $result, $i,"website"));
			$logo= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"logo_".$pageLang);
	}
	?>
	<div class="title2"><?php echo $name; ?></div>

	<table cellpadding='0' cellspacing='0' style='float:<?php echo _SALI; ?>; margin-bottom:15px; width:100%; '>
		
		<tr>
			
			<td>
				<table width='420px' border='0' cellpadding='0' cellspacing='0'>
					<tr><td class='bod_lb' valign="top"><?php echo Country; ?>: </td><td><?php echo $country; ?></td></tr>
					<?if($representer){?><tr><td class='bod_lb' valign="top"><span><?php echo Representer; ?>: </span></td><td><span><?php echo $representer; ?></span></td></tr><?}?>
					
					<?if($tel){?><tr><td class='bod_lb' valign="top"><?php echo Telephon; ?>: </td><td dir='ltr'><span dir='ltr'><?php echo $tel; ?></span></td></tr><?}?>
					<?if($fax){?><tr><td class='bod_lb' valign="top"><?php echo Fax; ?>: </td><td dir='ltr'><span dir='ltr'><?php echo $fax; ?></span></td></tr><?}?>
					<?if($email){?><tr><td class='bod_lb' valign="top"><?php echo E_mail; ?>: </td><td><?php echo $email; ?></td></tr><?}?>
					
					<?if($website){?><tr><td class='bod_lb' valign="top"><span><?php echo Website; ?>: </span></td><td><a href='<?php echo 'http://'.str_replace('http://','',$website); ?>' target=''><?php echo $website; ?></a></td></tr><?}?>
					
				</table>
			</td>
			<td valign='top'>
				<div class="logo" style="height:130px; width:300px; float:<?php echo _ALI; ?>;"><?if($logo){?><img src="../../uploads/<?php echo $logo; ?>"  style="max-width:300px; max-height:130px; float:<?php echo _ALI; ?>;"><?}?></div>
			</td>
		</tr>
		<tr>
			<td colspan='2' >
				<table width='100%' cellpadding='0' cellspacing='0'>
					<?if($address){?><tr><td class='bod_lb'  valign="top"><span><?php echo Address; ?>: </span></td><td align='<?php echo _SALI; ?>'><span><?php echo $address; ?></span></td></tr><?}?>
					<?if($specialization){?><tr><td class='bod_lb'  valign="top"><span><?php echo _FTR_SPECIALIZATION; ?>: </span></td><td align='<?php echo _SALI; ?>'><span><?php echo $specialization; ?></span></td></tr><?}?>
				</table>
			</td>
		</tr>
		
		
	</table>
	
	
	<br/><br/>

	<div class="page_dt" ><?php echo $brief; ?></div>
	<table style='float:<?php echo _SALI; ?>; width:100%'>
			<td></td> 
		<tr>
		</tr>
	</table>
<input type='button' value='<?php echo Back; ?>' class='more_btn' onClick='history.back()'/>

</div>