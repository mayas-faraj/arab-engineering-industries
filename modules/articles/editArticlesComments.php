<?  include_once("../common/header-admin.php");

/***********Print Header*************/
print_ListAdminHead("Articles Comments: Update", "Articles Comments", "", 0);

?>
<div id="output1"></div>
<?
$sub = $_REQUEST['sub'];
$art_id = $_REQUEST['art_id'];

if($sub){
	$id = addslashes($_REQUEST['id']);
	$comment = addslashes($_REQUEST['comment']);
	$pub_name = addslashes($_REQUEST['pub_name']);
	$pub_email = addslashes($_REQUEST['pub_email']);
	$pub_email = addslashes($_REQUEST['pub_email']);
	$publish_date = addslashes($_REQUEST['publish_date']);
	$active = addslashes($_REQUEST['active']);
	$lang = addslashes($_REQUEST['lang']);
	
	$SQL = "UPDATE art_comments SET  comment='$comment', pub_name = '$pub_name' , pub_email = '$pub_email' ,pub_email = '$pub_email' ,publish_date = '$publish_date' , active = '$active' WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessage("'.Record_Update.'")</script>';
	else echo '<script>errorMessage("'.CantInsert.'")</script>' ;
}
if((!$sub) || (!$result)){ 
	$id = $_REQUEST['id'];
	$sql ="SELECT * FROM art_comments WHERE id = '$id' ";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);
	if ($numberOfRows>0) {
		$i=0;
        $id= MYSQL_RESULT($result,$i,"id");
        $art_id= MYSQL_RESULT($result,$i,"art_id");
        $article= lookupField('art_articles','id','title',$art_id);
        $comment= MYSQL_RESULT($result,$i,"comment");
        $pub_name= MYSQL_RESULT($result,$i,"pub_name");
        $pub_email= MYSQL_RESULT($result,$i,"pub_email");
        $publish_date= MYSQL_RESULT($result,$i,"publish_date");
        $active= MYSQL_RESULT($result,$i,"active");
		$ord = mysql_result($result,$i,"ord");
	}?>
    <form name="subForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" />
    <input type="Hidden" name="art_id" size="20" value="<?php echo $art_id; ?>" />

    <table>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title">Publisher name:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="pub_name" size="20" value="<?php echo stripslashes($pub_name); ?>" class="required" /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title">Publisher email:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="pub_email" size="20" value="<?php echo stripslashes($pub_email); ?>" class="required" /></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td valign="top" align="<?php echo _ALI; ?>"><span class="field_title">Publish date:</span></td><td width="5" class="required">*</td>
			<td><input type="Text" name="publish_date" size="20" value="<?php echo stripslashes($publish_date); ?>" class="required dateF" /></td>
		</tr>

		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>" valign="top"><span class="field_title"><?php echo Comment; ?>:</span></td>
			<td width="5" class=""></td>
			<td><textarea name="comment" cols="50" rows="4" class="simpleEditor" ><?php echo stripslashes($comment); ?></textarea></td>
		</tr>
		<!---------------------------------------------------------------------------------->
		<tr>
			<td align="<?php echo _ALI; ?>"><span class="field_title"><?php echo Active; ?>:</span></td>
			<td width="5" class=""></td>
			<TD><input type="Checkbox" name="active" size="20" value="1" <?php echo ($active)? "checked" : ""?>  /></TD>
		</tr>

		<!---------------------------------------------------------------------------------->
	</table>
	<input name="sub" type="submit" id="sub" value="Save">
    <input name="sub2" type="button" id="sub2" value="<?php echo Back; ?>" onClick=" document.location='listArticlesComments.php?art_id=<?php echo $art_id; ?>'">
    </form><?  
}
include_once("../common/footer-admin.php"); ?>
