<?php include_once("../common/header-admin.php");

echo print_GridAdminHead("Menus","Menus", 1, 1, 1, 1);

echo '<div class="controls">';
echo create_lang_switcher($lang);
echo '</div>';

/**Ordering_functions(part 1 of 2)********************************************/
//define ordering cretiria:
function getNewMenuOrder(){
$p_id = $_REQUEST['p_id'];
$lang = $_SESSION['lang'];
return getNewItemOrder("menus", "item_order", "p_id = $p_id AND lang = '$lang'");
}
//apply updating:
changeOrder("menus", "menu_id", "item_order", getNewMenuOrder());
$action = $_REQUEST['action'];
if($action=="Insert")	$item_order = getNewMenuOrder();
$static_order = 1;
//---------------------------------------------------------------------------------

/***********Default Sorting Option*************/
if( !isset($sb) )	$sb="id";
$sort  = "ORDER BY is_static DESC,$sb $so";
//****************************************************

$menu_id = $_REQUEST['menu_id'];
$p_id =$_REQUEST['p_id'];
$item_link = addslashes($_REQUEST['item_link']);
$item_label = addslashes($_REQUEST['item_label']);
$action = $_REQUEST['action'];
if($action=="Insert"){
$cols = "item_order , item_link , lang , p_id";
$values = "'$item_order' , '$item_link' , '$lang' , '$p_id'";
$cols .= ", item_label"; $values .= ",  '$item_label'";
$SQL = "INSERT INTO menus ( $cols ) VALUES ($values)";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)	echo '<script>correctMessageWithoutBack("'.Record_Enter.'")</script>';
}
//-------------------------------------------------
if($action=="Update"){
$values = "item_link = '$item_link'";
$values .= ", item_label = '$item_label'";
$SQL = "UPDATE menus SET $values WHERE menu_id = '$menu_id' ";
$result = mysqli_query($GLOBALS["db_link_conn"], $SQL);
if($result)	echo '<script>correctMessageWithoutBack("'.Record_Update.'")</script>';
}
/**delete_grp_functions(part 1 of 2)********************************************/
if($action=="Delete"){
$array = $_POST['rid'];
if($array){
$ids = implode(",", $array);
deleteRecord("menus","menu_id in ($ids) OR p_id in ($ids)",true);
}
}
//-------------------------------------------------
if(!$p_id)	$p_id=0;

$sql = "SELECT * FROM menus WHERE (p_id = '$p_id') AND lang = '$lang'  ORDER BY item_order ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numberOfRows = mysqli_num_rows($result);
$i=0;?>
<div class="data">
<form method='post' name='main' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type="hidden" name="p_id" size="20" value="<?php echo $p_id; ?>" />
<input type="Hidden" name="lang" size="20" value="<?php echo $lang; ?>" />
<script>
function actionf(act){
main.action.value = act;
main.submit();
}
</script>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
<thead>
<TR>
<?php
?>
<th width="100px;"><?php echo print_AdminRecordHead("item_label", "Item Label", $sb, $so, $static_order); ?></th>
<?php
?>
<th><?php echo print_AdminRecordHead("item_link", "Item Link", $sb, $so, $static_order); ?></th>
<th colspan="5">&nbsp;</th>
</TR>
</thead>
<tbody>
<?php if($action=="Enter"){ ?>
<TR>
<?php
?>
<TD><input type="Text" name="item_label" size="20" value="<?php echo stripslashes($item_label); ?>"/></TD>
<?php
?>
<TD><?php echo getLinks($item_link , $lang);; ?></TD>
<TD><?php echo print_save_icon("Insert"); ?></TD>
<TD colspan="4">&nbsp;</TD>
</TR>
<?}// Enter record
while ($i<$numberOfRows){
$menu_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"menu_id");
$item_label= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"item_label");
$order= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"item_order");
$item_link= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"item_link");
$lang= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"lang");
$p_id= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"p_id");
$ord= mysqli_result($GLOBALS["db_link_conn"], $result,$i,"item_order");
if($action=="Edit"  && $_REQUEST['menu_id'] == $menu_id){?>
<TR>
<?php
?>
<TD><input type="Text" name="item_label" size="20" value="<?php echo stripslashes($item_label); ?>" />
<input type="Hidden" name="menu_id" size="20" value="<?php echo $menu_id; ?>" />
</TD>
<?php
?>
<TD><?php echo getLinks($item_link , $lang);; ?></TD>
<TD><?php echo print_save_icon("Update"); ?></TD>
<TD colspan="4">&nbsp;</TD>
</TR>
<?}// Edit record
else{?>
<TR>
<?php
?>
<TD><?php echo stripslashes($item_label); ?></TD>
<?php
?>
<TD>&nbsp;<?php echo print_internal_Link($item_link);; ?></TD>
<?php
/**Ordering_functions(part 2 of 2)********************************************/
showUpDownIcons($result, $i, "menu_id", "item_order", "&p_id=".$p_id);
/**Ordering_functions********************************************/
?>
<TD width="42" align="center"><?php echo print_subItems_icon("listMenus.php?p_id=$menu_id")?></TD>
<TD width="42" align="center"><?php echo print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&menu_id=".$menu_id."&p_id=".$p_id)?></TD>
<?/**delete_grp_functions(part 1 of 2)********************************************/?>
<TD width="29" align="center"><?php echo print_delete_ckbox($menu_id); ?></TD>
<?//-------------------------------------------------------?>
</TR>
<?}//end else
$i++;
}//End While?>
</tbody>
</TABLE>
<br><br>
<div align="CENTER"><?php
if($p_id){ ?>
<input type="button" value="<?php echo _GoBack; ?>" onClick="document.location='listMenus.php?p_id=<?php echo lookupField('menus','menu_id','p_id',$p_id); ?>';" /><?php } ?></div>
</form>
</div>
<?php include_once("../common/footer-admin.php"); ?>
