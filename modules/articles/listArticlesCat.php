<?php include _once("../common/header-admin.php");?>
<?echo print_GridAdminHead("Active Forums","Active Forums", 1, 1, 1, 1);
echo '<div class="controls">';
//echo create_lang_switcher($lang);
echo '</div>';
/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY is_static DESC,$sb $so";
//****************************************************/
$action = $_REQUEST['action'];
$id = $_REQUEST['id'];
$name = addslashes($_REQUEST['name']);
$grp_admin = addslashes($_REQUEST['grp_admin']);
$create_date = addslashes($_REQUEST['create_date']);
/*-------------------------------------------------*/
if($action=="Insert"){

	$SQL = "INSERT INTO art_categories (name, lang , grp_admin, create_date ) VALUES ('$name' , '$lang','$grp_admin', '$create_date')";
	$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	$topic_id = mysqli_insert_id($GLOBALS["db_link_conn"]);
	if($grp_admin){
		$SQL = "insert into forum_group (name_en,name_ar) values ('$name','$name');";
		$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
		
		$grp_id = mysqli_insert_id($GLOBALS["db_link_conn"]);
		$SQL = "insert into forum_users_groups (user_id,grp_id) values ('$grp_admin','$grp_id');";
		$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
		
		
		
		$SQL = "insert into topic_groups (topic_id,grp_id) values ('$topic_id','$grp_id');";
		$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
	}
	
	if($result)echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
/*-------------------------------------------------*/
if($action=="Update"){$SQL = "UPDATE art_categories SET create_date='$create_date', name = '$name' , lang = '$lang', grp_admin='$grp_admin' WHERE id = '$id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
/*-------------------------------------------------*/
if($action=="Delete"){$array = $_POST['rid'];
$ids = implode(",", $array);
for($i=0;$i<count($array);$i++){
	$sql_query = " select * from art_articles WHERE cat_id = '".$array[$i]."'";
	$has_discussions = mysqli_num_rows(mysql_query($sql_query));
	if($has_discussions){
		$cat_name = lookupField('art_categories','id','name',$array[$i]);
		echo "<script>alert('Sorry cannot delete forum $cat_name because it contains $has_discussions discussion');</script>";
	}else{
		deleteRecord("art_categories"," id = '".$array[$i]."' ",true);
	}
	
}

}// Delete record
/*-------------------------------------------------*/
$sql = "SELECT * FROM art_categories   ORDER BY name ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
$i=0;
?>
<div class="data">
	<form method='post' name='main' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
		<input type='hidden' name='action' value=''>
		<input type="Hidden" name="lang" size="20" value="<?php echo $lang; ?>" />
		<script>function actionf(act){main.action.value = act;main.submit();}</script>
		<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
			<thead>
				<TR>
					<tr>
						<th width="277"><?php echo print_AdminRecordHead("name", "Forum Name", $sb, $so, $static_order); ?></th>
						<th width="277"><?php echo print_AdminRecordHead("grp_admin", "Moderator", $sb, $so, $static_order); ?></th>
						<th width="277"><?php echo print_AdminRecordHead("create_date", "Created on", $sb, $so, $static_order); ?></th>
						<th width="277"><?php echo print_AdminRecordHead("active", "Show", $sb, $so); ?></th>
						<th width="277"><?php echo print_AdminRecordHead("publish", "Active", $sb, $so); ?></th>
						<!--th width="277"><?php echo print_AdminRecordHead("lang", "Language", $sb, $so, $static_order); ?></th-->
						<th colspan="4">Controls  </th>
					</tr>
				</TR>
			</thead>
			<tbody>
			<?if($action=="Enter"){
				
			?>
				<TR>
					<TD><input type="Text" name="name" size="20" value="<?php echo stripslashes($name); ?>" class='required' /></TD>
					<TD><?php echo createComboBox("users" , "user_id", "full_name" , $grp_admin , "grp_admin", "required");; ?></TD>
					<TD><input type="Text" name="create_date" size="20" value="<?php echo date('Y-m-d'); ?>" class='dateF' /></TD>
					<!--TD><?php echo createLangCombo('Arabic|English','ar|en','lang','required',$lang); ?></TD-->
					<TD><img src="<?php echo _PREF; ?>images/icons/save.png" onClick="actionf('Insert')" onMouseOver="over(this)" alt="<?php echo _Save; ?>" /></TD>
					<TD colspan="5">&nbsp;</TD>
				</TR>
			<?}
/* Enter record */
while ($i<$numberOfRows){
$id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"id");
$name= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"name");
$lang= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"lang");
$grp_admin= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"grp_admin");
$create_date= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"create_date");
$active= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"active");
$publish= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"publish");
if($action=="Edit"  && $_REQUEST['id'] == $id){
?>
<TR>
	<TD><input type="Text" name="name" size="20" value="<?php echo stripslashes($name); ?>" /><input type="Hidden" name="id" size="20" value="<?php echo $id; ?>" /></TD>
	<TD><?php echo createComboBox("users" , "user_id", "full_name" , $grp_admin , "grp_admin", "required");; ?></TD>
	<TD><input type="Text" name="create_date" size="20" class='dateF' value="<?php echo stripslashes($create_date); ?>" /></TD>
	<!--TD><?php echo createLangCombo('Arabic|English','ar|en','lang','required',$lang); ?></TD-->
	<TD><img src="<?php echo _PREF; ?>images/icons/save.png" onClick="actionf('Update')" onMouseOver="over(this)" alt="<?php echo _Save; ?>" /></TD>
	<TD colspan="5">&nbsp;</TD>
</TR>
<?}else{
/* Edit recordelse */
{?><TR>
<?$news_count = mysqli_result($GLOBALS["db_link_conn"], mysql_query("SELECT count(*) FROM art_articles where cat_id = '$id'"),0,'count(*)');?>
<?$users_count = mysqli_result($GLOBALS["db_link_conn"], mysql_query("SELECT count(*) FROM topic_groups where topic_id = '$id'"),0,'count(*)');?>
<TD><?php echo stripslashes($name); ?></TD>

<TD><?php echo stripslashes(lookupField('users','user_id','full_name',$grp_admin)); ?></TD>
<TD><?php echo stripslashes($create_date); ?></TD>
<td><a href="../includes/checkbox.php?t=art_categories&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a></td>
<td><a href="../includes/checkbox.php?t=art_categories&fn=publish&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($publish); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $publish?>_.png" border="0"  fv="<?php echo !($publish); ?>"/></a></td>
<!--TD><?php echo stripslashes($lang); ?></TD-->
<TD align="center" width="50"><a href='listTopicGroups.php?topic_id=<?php echo $id; ?>'> Allowed groups (<?php echo $users_count; ?>)</a></td>
<TD align="center" width="50"><a href='listArticles.php?cat_id=<?php echo $id; ?>'> List Discussions (<?php echo $news_count; ?>)</a></td>
<TD align="center" WIDTH="20"><?php echo print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id);?></TD>
<TD align="center" WIDTH="20"><input name="rid[]" type="checkbox" value="<?php echo $id; ?>"/></TD>
</TR><?}
}/* end */

$i++;}
//End While?>
</tbody></TABLE></form></div><?php include_once("../common/footer-admin.php");?>