<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/members/members_<?php echo $pageLang; ?>.css'/>
<div class="page_content" dir='<?php echo _DIR; ?>'>
	
	<?
	$mid = cleanString($_REQUEST['id']);
	$sql = "SELECT * FROM mem_members WHERE id = '$mid'";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);
	$i = 0;	
	if($numberOfRows>0){
			$id= MYSQL_RESULT($result,$i,"id");
			$name = MYSQL_RESULT($result,$i,"name_".$pageLang); 
			$specialization= MYSQL_RESULT($result,$i,"specialization");
			$specialization= lookupFieldAll("specialization", "id", "specialization_".$pageLang, $specialization);
			$country= MYSQL_RESULT($result,$i,"country");
			$country= lookupField("country", "id", "country_".$pageLang, $country);
			
			$products = MYSQL_RESULT($result,$i,"products_".$pageLang); 
			$representer = MYSQL_RESULT($result,$i,"representer_".$pageLang); 
			$brief= MYSQL_RESULT($result,$i,"brief_".$pageLang); 
			$tel= MYSQL_RESULT($result,$i,"tel");
			$fax= MYSQL_RESULT($result,$i,"fax");
			$address= MYSQL_RESULT($result,$i,"address_".$pageLang); 
			$email= MYSQL_RESULT($result,$i,"email");
			$website= str_replace('http://','',mysql_result($result, $i,"website"));
			$logo= MYSQL_RESULT($result,$i,"logo_".$pageLang);
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