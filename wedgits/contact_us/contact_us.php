<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/contact_us/contact_us_<?=$pageLang?>.css'/>	
<script src="<?=_PREF?>wedgits/view_form/view_form.js" language="javascript" type="text/javascript"></script>
<?
//------------ Page Text----------------------------------------------------------
if($pageLang=='en'){
	$id = 2;
}else{
	$id = 3;
}
$title = lookupField('pages','id','title',$id);
//--------------------------------------------------------------------------------
?>
<div class="page_content" dir='<?=_DIR?>'>
<div class='title2'><?=$title?></div>


	<?
	$sub = $_POST['sub'];
	if($sub){?>
		<?
		if( $_SESSION['security_code'] !=  cleanString($_REQUEST['code'])){?>
			<!--script>
				$('.document').ready(function (){
					$('#success_window').html('<?=_Xkeycode?>');
					$('#success_window').show();
					setTimeout("$('#success_window').hide();",3000);
				});
			</script-->
			<?
			echo "<div class='form_msg' >"._Xkeycode."</div>";

			$xcode=1;
		}else{
			$f_name = cleanString(addslashes($_REQUEST['f_name']));
			$email = cleanString(addslashes($_REQUEST['email']));
			$address = cleanString(addslashes($_REQUEST['address']));

			$note = cleanString(addslashes($_REQUEST['note']));
			
			//--------SEND -----
			$send=0;
			$message='
			<table width="600" border="0" cellspacing="3" cellpadding="3" dir="rtl">
			
			<tr><td width="133" align="left" style="font-family:Tahoma, Geneva, sans-serif"><b>'.Name .':</b></td>
			<td width="446" style="font-family:Tahoma, Geneva, sans-serif">'.$f_name.'</td></tr>
			
			<tr><td align="left" style="font-family:Tahoma, Geneva, sans-serif"><b>'.Email .':</b></td>
			<td style="font-family:Tahoma, Geneva, sans-serif">'.$email.'</td></tr>
			
						  
			<tr><td align="left" valign="top" style="font-family:Tahoma, Geneva, sans-serif"><b>'.Message .'</b></td>
			<td style="font-family:Tahoma, Geneva, sans-serif">'.$note.'</td></tr>
			</table>';
			//echo $masseg;
		
			//$to = mysql_result(mysql_query('select * from messages where id=1'),0,'email'); //'ahmad.m@voilasyria.com';
			$to = basename(lookupField('site_settings','id','value',1));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "To: $to \r\n";
			$headers .= "From: ".$email." \r\n";
			$subject="Email from your website ($f_name)";
			$s = @mail($to, $subject, $message, $headers);
			if($s){?>
				<!--script>
					$('.document').ready(function (){
						$('#success_window').html('<?=ysend?>');
						$('#success_window').show();
						setTimeout("$('#success_window').hide();",3000);
					});
				</script-->
					<?
					echo "<div class='form_msg' >".ysend."</div>";
				
				$user_message = cleanString($_REQUEST['note']);//mysql_result(mysql_query('select * from messages where id=1'),0,'message');
				$user_headers  = "MIME-Version: 1.0\r\n";
				$user_headers .= "Content-type: text/html; charset=utf-8\r\n";
				$user_headers .= "To:".$email."\r\n";
				$user_headers .= "From: ".$to." \r\n";
				$user_subject = "AFEI";
				@mail($email, $user_subject, $user_message, $user_headers);
				
			}else {?>
				<!--script>
					$('.document').ready(function (){
						$('#success_window').html('<?=xsend?>');
						$('#success_window').show();
						setTimeout("$('#success_window').hide();",3000);
					});
				</script-->
				<?
					echo "<div class='form_msg' >".xsend."</div>";

				$xsend=1;
			}
			
			
		}// Sub 
	}else{


	}?>





	<div class='contact_us'>
	<table cellspacing='0' cellpadding='0' dir='<?=_DIR?>'>
		<tr>
		
			<td valign='top' >
				<?

				//------------ Page Text----------------------------------------------------------

				$details = lookupField('pages','id','details',$id);
				echo $details;

				//--------------------------------------------------------------------------------
				?>
			</td>
		</tr>
		<tr>
			<td valign='top'  align='<?=_SALI?>' >
				<?
				if((!$sub) || $xcode || $xsend){ ?>


				<form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
					<input type="Hidden" name="sub" size="20" value="save" />
					
					<div class='itm_con'><div class='contact_text'><span class='contact_label'><?=Name?></span> <input type='text' name='f_name' class='required1'/></div><span class='errorMsg'></span></div>
					<div class='itm_con'><div class='contact_text'><span class='contact_label'><?=Email?></span><input type='text' name='email' class='required1 email1'/></div><span class='errorMsg'></span></div>
					<div class='itm_con'><div class='contact_area'><span class='contact_label'><?=Message?></span><textarea name='note' class='required1'></textarea></div><span class='errorMsg'></span></div>
					<div class='contact_sec'>
						<img src="<?=_PREF?>wedgits/security_img/securityimages.php" border="0" class="forms_image" />
						<input type="text" name="code" value=""  class="forms_input_code required" onFocus="this.value=''" />
					</div>
					<div class='contact_but'><input type="button" name="sub2" value="<?=Send?>"  class="" onClick="validate_form('1','<?=req_label?>','<?=email_label?>')"></div>
					
				</form>
				
				<?php 
				} ?>

			</td>
		</tr>
		
	</table>

</div>
</div>