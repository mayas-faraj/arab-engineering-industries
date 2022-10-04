<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/view_form/view_form_<?php echo $pageLang; ?>.css'/>	
<script src="<?php echo _PREF; ?>wedgits/view_form/view_form.js" language="javascript" type="text/javascript"></script>
<div class="page_content" dir='<?php echo _DIR; ?>'>
<?php
	$page_name = getCurrentFormName();
	if($page_name=='index'){
		$path='';
	}else{
		$path='../../';
	}
	$sub = cleanString($_REQUEST['sub']);
	$form_id = cleanString($_REQUEST['id']);
?>
<input type='hidden' class='path' value='<?php echo $path; ?>'/>

<div class='title'><?php echo lookupField('query_forms','form_id','form_name',$form_id);; ?></div>
<?php 
	if($sub){
		if( $_SESSION['security_code'] !=  cleanString($_REQUEST['code'])){
		echo "<div class='form_msg'  >"._Xkeycode."</div>";
		}else{
			$num 	= cleanString($_REQUEST['no']);
			$to     = cleanString($_REQUEST['to']) ;
			$form	= cleanString($_REQUEST['form_name']);
			/* To send HTML mail, you can set the Content-type header. */
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "To:".$to."\r\n";
			$headers .= "From: ".$to." \r\n";
			$subject .= "$form";
			$message  ='
			<table width="600" border="0" cellspacing="0" cellpadding="3" dir="'._DIR.'" 
			style="font-family:Tahoma, Geneva, sans-serif">
			<tr><td colspan="2" stl="stl">'.msgWebsite.'</td></tr>';
			
			for($i=0 ; $i < $num; $i++){
				$label 	= cleanString($_REQUEST['l'.$i]);
				$value	= cleanString($_REQUEST['f'.$i]);
				$message .='<tr><td width="100"><b>'.$label.':</b></td><td>'.$value.'</td></tr>';
			}
			$message  .='</table>';
			//echo $message;
			/* and now mail it */
			$s = @mail($to, $subject, $message, $headers);
			$s = 1;
			if($s){
				echo "<div id='clear'></div><br/><div class='form_msg'>".ysend."</div>";
			}else{
				echo "<div id='clear'></div><div class='form_msg'  >".xsend."</div>";
				$xsend=1;
			}
		}
	}
?>

<?php

$sql = "SELECT * FROM query_forms fo LEFT JOIN form_fields fi ON (fi.form_id = fo.form_id ) 
WHERE fo.form_id  = '$form_id' ORDER BY item_order ASC";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
if ($numberOfRows>0) {
	$i=0;
	$from_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"form_id");
	$form_name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"form_name");
	$send_mail_to= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"send_mail_to");	?>

	
    <div id="output1" style='width:100%'>
	<form name="subForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
	<input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
	<input type="hidden" name="id" value="<?php echo $from_id; ?>">
	<input type="hidden" name="to" value="<?php echo _INFO; ?>">
	<input type="hidden" name="no" value="<?php echo $numberOfRows; ?>">
	<table width="100%" border="0" cellpadding="1" cellspacing="1" dir='<?php echo _DIR; ?>' style='float:Right;'><?php
	while ($i<$numberOfRows){
		$label= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"field_label");
		$type= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"type");
		$plus= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"plus");
		$required= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"required");
		if(!$label) {$i++; continue;}
		$req= ($required)? 'required' : ''; 
		$req.= ($type=='Email')? ' email' : ''; 
		$rq= ($required)? '*' : '';
		if($type == 'Label'){ 
			$str.='<tr><td colspan="3"><b>'.$label.'</b></td><tr>';
			$i++;
			continue;
		}
		$str.='<tr><td   style="max-width:150px;" valign="top" class="forms_titles">'.$label.':
		<input type="hidden" name="l'.$i.'" value="'.$label.'" /></td>';
		
		$str.='<td  class="forms_request">'.$rq.'</td>';
		switch ($type):
		case "Field":
		$str.='<td  ><input type="text" name="f'.$i.'" size="20" class="forms_input '.$req.'"  /></td></tr>';
		break;
		
		case "Area":
		$str.='<td ><textarea name="f'.$i.'" cols="40" rows="4" class="forms_input2 '.$req.'"></textarea></td></tr>';
		break;
		
		case "List":
		$str.='<td><select name="f'.$i.'" class="forms_input '.$req.'">';
		$values = explode(',',$plus);
		foreach($values as $val)$str.='<option value="'.$val.'">'.$val.'</option>';
		$str.='</select></td></tr>';
		break;
		
		case "Checkbox":
		$values = explode(',',$plus);
		foreach($values as $val)$str.='<td><input type="checkbox" name="f'.$i.'" value="*" class="'.$req.'"> '.$val;
		$str.='</td></tr>';
		break;
		
		default:
		$str.='<td><input type="Text" name="f'.$i.'" size="20" class="forms_input '.$req.'"/></td></tr>';
		break;
		
		endswitch;
		$i++;
	}// end while
	echo $str;?>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td><hr class='key_sep'/><div class='key_desc'><?php echo _keycode; ?></div></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td><img src="<?php echo _PREF; ?>wedgits/security_img/securityimages.php" border="1" class="forms_image" />
	<br><input type="text" name="code" value=""  class="forms_input_code required" onFocus="this.value=''" /></td></tr>
	<tr><td ></td ><td ><input type='hidden' name="sub" value='send'/></tr></table>
		<input style='' type="button" name="sub" id='btn' class="btn form_submit" onclick='validate_form();' value="<?php echo _Send; ?>">
	</form>
	</div>

<?php 
} //number Of Row?>
</div>