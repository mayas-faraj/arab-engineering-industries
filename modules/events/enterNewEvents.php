<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Events: Insert New Item", "Events", "", 0);

?><div id="output1"></div><?

$sub = $_REQUEST['sub'];

if($sub){
	$id = addslashes($_REQUEST['id']);
	$subject = addslashes($_REQUEST['subject']);
	$brief = addslashes($_REQUEST['brief']);
	$details = addslashes($_REQUEST['details']);
	
	$subject_ar = addslashes($_REQUEST['subject_ar']);
	$brief_ar = addslashes($_REQUEST['brief_ar']);
	$details_ar = addslashes($_REQUEST['details_ar']);
	
	$publish_date = addslashes($_REQUEST['publish_date']);
	$event_type = addslashes($_REQUEST['event_type']);
	$end_date = addslashes($_REQUEST['publish_date']);//addslashes($_REQUEST['end_date']);
	$active = 1;//addslashes($_REQUEST['active']);
	$lang = addslashes($_REQUEST['lang']);
	$link = addslashes($_REQUEST['link']);
	$SQL = "INSERT INTO events_events (subject , brief , details , subject_ar , brief_ar , details_ar ,publish_date , end_date  , active,  link) 
						VALUES ('$subject' , '$brief' , '$details', '$subject_ar' , '$brief_ar' , '$details_ar', '$publish_date' , '$end_date' , '$active',  '$link' )";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessage("'.Record_Update.'")</script>';
	else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ ?>
    <form name="subForm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <input type="Hidden" name="id" size="20" value="<?=$id?>" />
    <table>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?=_ALI?>"><span class="field_title"><?=Subject?> (EN):</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="subject" size="20" value="<?=stripslashes($subject)?>" class="required" /></td>
		</tr>
		
		<tr>
			<td align="<?=_ALI?>"><span class="field_title"><?=Subject?> (AR):</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="subject_ar" size="20" value="<?=stripslashes($subject_ar)?>" class="required" /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td valign="top" align="<?=_ALI?>"><span class="field_title">Start date:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="publish_date" size="20" value="<?=stripslashes($publish_date)?>" class="required dateF" /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?=_ALI?>"><span class="field_title">Link:</span></td>
			<td width="5" class=""></td>
			<td><input type="Text" name="link" size="20" value="<?=stripslashes($link)?>" class=" " /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<!--tr>
			<td valign="top" align="<?=_ALI?>"><span class="field_title">End date:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="end_date" size="20" value="<?=stripslashes($end_date)?>" class="required dateF" /></td>
		</tr-->
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Brief?> (EN):</span></td>
			<td width="5" class=""></td>
			<td><textarea name="brief" rows='4' cols='140' class="" ><?=stripslashes($brief)?></textarea></td>
		</tr>
		
		<tr>
			<td align="<?=_ALI?>" valign="top"><span class="field_title"><?=Brief?> (AR):</span></td>
			<td width="5" class=""></td>
			<td><textarea name="brief_ar" rows='4' cols='140' class="" ><?=stripslashes($brief_ar)?></textarea></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<!--tr>
			<td valign="top" align="<?=_ALI?>"><span class="field_title"><?=Details?> :</span></td><td width="5" class="required"></td>
			<td><textarea name="details" class="mceEditor" ><?=stripslashes($details)?></textarea></td>
		</tr-->
		<!---------------------------------------------------------------------------------->
		<!--tr>
			<td align="<?=_ALI?>"><span class="field_title"><?=Active?>:</span></td>
			<td width="5" class=""></td>
			<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
		</tr-->
		<!---------------------------------------------------------------------------------->
		<!--tr>
			<td align="<?=_ALI?>"><span class="field_title">Event type:</span></td>
			<td width="5" class=""></td>
			<TD><?=createComboBox("events_type" , "id", "type" , $event_type , "event_type", "required");?></TD>
		</tr-->
		<!---------------------------------------------------------------------------------->
		<!--tr>
			<td align="<?=_ALI?>"><span class="field_title">Language:</span></td>
			<td width="5" class=""></td>
			<TD><?=createComboBox("languages" , "lang", "lang_name" , $lang , "lang", "required");?></TD>
		</tr-->
		<!---------------------------------------------------------------------------------->
	</table>
    <input name="sub" type="submit" id="sub" value="Save">
    <input name="sub4" type="button" id="sub3" value="<?=Back?>" onClick=" document.location='listEvents.php?cat_id=<?=$cat_id?>'">
    </form></div><?  
}
include_once("../common/footer-admin.php"); ?>