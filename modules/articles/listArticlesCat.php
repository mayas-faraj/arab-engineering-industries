<?include_once("../common/header-admin.php");?>
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
	$result = mysql_query($SQL);
	$topic_id = mysql_insert_id();
	if($grp_admin){
		$SQL = "insert into forum_group (name_en,name_ar) values ('$name','$name');";
		$result = mysql_query($SQL);
		
		$grp_id = mysql_insert_id();
		$SQL = "insert into forum_users_groups (user_id,grp_id) values ('$grp_admin','$grp_id');";
		$result = mysql_query($SQL);
		
		
		
		$SQL = "insert into topic_groups (topic_id,grp_id) values ('$topic_id','$grp_id');";
		$result = mysql_query($SQL);
	}
	
	if($result)echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}// Insert record
/*-------------------------------------------------*/
if($action=="Update"){$SQL = "UPDATE art_categories SET create_date='$create_date', name = '$name' , lang = '$lang', grp_admin='$grp_admin' WHERE id = '$id' ";
$result = mysql_query($SQL);
if($result)echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}// Update record
/*-------------------------------------------------*/
if($action=="Delete"){$array = $_POST['rid'];
$ids = implode(",", $array);
for($i=0;$i<count($array);$i++){
	$sql_query = " select * from art_articles WHERE cat_id = '".$array[$i]."'";
	$has_discussions = mysql_numrows(mysql_query($sql_query));
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
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i=0;
?>
<div class="data">
	<form method='post' name='main' action='<?=$_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
		<input type='hidden' name='action' value=''>
		<input type="Hidden" name="lang" size="20" value="<?=$lang?>" />
		<script>function actionf(act){main.action.value = act;main.submit();}</script>
		<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
			<thead>
				<TR>
					<tr>
						<th width="277"><?=print_AdminRecordHead("name", "Forum Name", $sb, $so, $static_order)?></th>
						<th width="277"><?=print_AdminRecordHead("grp_admin", "Moderator", $sb, $so, $static_order)?></th>
						<th width="277"><?=print_AdminRecordHead("create_date", "Created on", $sb, $so, $static_order)?></th>
						<th width="277"><?=print_AdminRecordHead("active", "Show", $sb, $so)?></th>
						<th width="277"><?=print_AdminRecordHead("publish", "Active", $sb, $so)?></th>
						<!--th width="277"><?=print_AdminRecordHead("lang", "Language", $sb, $so, $static_order)?></th-->
						<th colspan="4">Controls  </th>
					</tr>
				</TR>
			</thead>
			<tbody>
			<?if($action=="Enter"){
				
			?>
				<TR>
					<TD><input type="Text" name="name" size="20" value="<?=stripslashes($name)?>" class='required' /></TD>
					<TD><?=createComboBox("users" , "user_id", "full_name" , $grp_admin , "grp_admin", "required");?></TD>
					<TD><input type="Text" name="create_date" size="20" value="<?=date('Y-m-d')?>" class='dateF' /></TD>
					<!--TD><?=createLangCombo('Arabic|English','ar|en','lang','required',$lang)?></TD-->
					<TD><img src="<?=_PREF?>images/icons/save.png" onClick="actionf('Insert')" onMouseOver="over(this)" alt="<?=_Save?>" /></TD>
					<TD colspan="5">&nbsp;</TD>
				</TR>
			<?}
/* Enter record */
while ($i<$numberOfRows){
$id= MYSQL_RESULT($result,$i,"id");
$name= MYSQL_RESULT($result,$i,"name");
$lang= MYSQL_RESULT($result,$i,"lang");
$grp_admin= MYSQL_RESULT($result,$i,"grp_admin");
$create_date= MYSQL_RESULT($result,$i,"create_date");
$active= MYSQL_RESULT($result,$i,"active");
$publish= MYSQL_RESULT($result,$i,"publish");
if($action=="Edit"  && $_REQUEST['id'] == $id){
?>
<TR>
	<TD><input type="Text" name="name" size="20" value="<?=stripslashes($name)?>" /><input type="Hidden" name="id" size="20" value="<?=$id?>" /></TD>
	<TD><?=createComboBox("users" , "user_id", "full_name" , $grp_admin , "grp_admin", "required");?></TD>
	<TD><input type="Text" name="create_date" size="20" class='dateF' value="<?=stripslashes($create_date)?>" /></TD>
	<!--TD><?=createLangCombo('Arabic|English','ar|en','lang','required',$lang)?></TD-->
	<TD><img src="<?=_PREF?>images/icons/save.png" onClick="actionf('Update')" onMouseOver="over(this)" alt="<?=_Save?>" /></TD>
	<TD colspan="5">&nbsp;</TD>
</TR>
<?}else{
/* Edit recordelse */
{?><TR>
<?$news_count = mysql_result(mysql_query("SELECT count(*) FROM art_articles where cat_id = '$id'"),0,'count(*)');?>
<?$users_count = mysql_result(mysql_query("SELECT count(*) FROM topic_groups where topic_id = '$id'"),0,'count(*)');?>
<TD><?=stripslashes($name)?></TD>

<TD><?=stripslashes(lookupField('users','user_id','full_name',$grp_admin))?></TD>
<TD><?=stripslashes($create_date)?></TD>
<td><a href="../includes/checkbox.php?t=art_categories&fn=active&idn=id&idv=<?=$id?>&fv=<?=!($active)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?=!($active)?>"/></a></td>
<td><a href="../includes/checkbox.php?t=art_categories&fn=publish&idn=id&idv=<?=$id?>&fv=<?=!($publish)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $publish?>_.png" border="0"  fv="<?=!($publish)?>"/></a></td>
<!--TD><?=stripslashes($lang)?></TD-->
<TD align="center" width="50"><a href='listTopicGroups.php?topic_id=<?=$id?>'> Allowed groups (<?=$users_count?>)</a></td>
<TD align="center" width="50"><a href='listArticles.php?cat_id=<?=$id?>'> List Discussions (<?=$news_count?>)</a></td>
<TD align="center" WIDTH="20"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id);?></TD>
<TD align="center" WIDTH="20"><input name="rid[]" type="checkbox" value="<?=$id?>"/></TD>
</TR><?}
}/* end */

$i++;}
//End While?>
</tbody></TABLE></form></div><? include_once("../common/footer-admin.php");?>