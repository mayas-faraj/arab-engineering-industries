<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Discussions: Update", "Discussions", "", 0);

?>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];

if($sub){
	$id = addslashes($_REQUEST['id']);
	$title = addslashes($_REQUEST['title']);
	$brief = addslashes($_REQUEST['brief']);
	$user_id = addslashes($_REQUEST['user_id']);
	$details = addslashes($_REQUEST['details']);
	$publish_date = addslashes($_REQUEST['publish_date']);
	$active = addslashes($_REQUEST['active']);
	$cat_id = addslashes($_REQUEST['cat_id']);
	
	$SQL = "UPDATE art_articles SET  cat_id='$cat_id', title = '$title' , brief = '$brief' ,details = '$details' ,publish_date = '$publish_date' , user_id='$user_id', active = '$active' WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessage("'.Record_Update.'")</script>';
	else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ 
	$id = $_REQUEST['id'];
	$sql ="SELECT * FROM art_articles WHERE id = '$id' ";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);
	if ($numberOfRows>0) {
		$i=0;
        $id= MYSQL_RESULT($result,$i,"id");
        $title= MYSQL_RESULT($result,$i,"title");
        $brief= MYSQL_RESULT($result,$i,"brief");
        $user_id= MYSQL_RESULT($result,$i,"user_id");
        $details= MYSQL_RESULT($result,$i,"details");
        $publish_date= MYSQL_RESULT($result,$i,"publish_date");
        $active= MYSQL_RESULT($result,$i,"active");
        $cat_id= MYSQL_RESULT($result,$i,"cat_id");
	}?>
    <form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />

    <table>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Title; ?>:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="title" size="20" value="<?php echo stripslashes($title); ?>" class="required" /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Author; ?>:</span></td><td width="5" class="required">*</td>
			<td><?php echo createComboBox("users" , "user_id", "full_name" , $user_id , "user_id", "required");; ?></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Publish date:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="publish_date" size="20" value="<?php echo stripslashes($publish_date); ?>" class="required dateF" /></td>
		</tr>

		<!----------------------------------------------------------------------------------
		<tr>
			<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Brief; ?>:</span></td>
			<td width="5" class=""></td>
			<td><textarea name="brief" cols="50" rows="4" class="simpleEditor" ><?php echo stripslashes($brief); ?></textarea></td>
		</tr>
		<!----------------------------------------------------------------------------------
		<tr>
			<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Details; ?>:</span></td><td width="5" class="required"></td>
			<td><textarea name="details" class="mceEditor" ><?php echo stripslashes($details); ?></textarea></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td>
			<td width="5" class=""></td>
			<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
		</tr>
		
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title">Category:</span></td>
			<td width="5" class=""></td>
			<TD><?php echo createComboBox("art_categories" , "id", "name" , $cat_id , "cat_id", "required");; ?></TD>
		</tr>
		<!---------------------------------------------------------------------------------->
	</table>
	<input name="sub" type="submit" id="sub" value="Save">
    <input name="sub2" type="button" id="sub2" value="<?php echo Back; ?>" onClick=" document.location='listArticles.php?cat_id=<?php echo $cat_id; ?>'">
    </form><?  
}
include_once("../common/footer-admin.php"); ?>
