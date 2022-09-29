<? include_once("../common/header-admin.php");
?>

<?


echo print_GridAdminHead("Site Settings","Site Settings", 0, 0, 0, 1);

///Lang----------------------------------------------------------------------------------------------
echo '<div class="controls">';
/*echo create_lang_switcher($lang);*/
echo '</div>';
//----------------------------------------------------------------------------------------------------


//------------------------------------------------

$so =  $_REQUEST['so'];
$sb =  $_REQUEST['sb'];

if($so) $so = ($so=="DESC")? "ASC" : "DESC" ; 
else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;
$action = $_REQUEST['action'];
$key = $_REQUEST['key'];
$id = $_REQUEST['id'];
$lang = $_SESSION['lang'];


//-------------------------------------------------
if($action=="Update"){
	$id = addslashes($_REQUEST['id']);
	$value = addslashes($_REQUEST['value']);


	$SQL = "UPDATE site_settings SET  value = '$value'  WHERE id = '$id' ";
	$result = mysql_query($SQL);
	if($result)
 	echo '<script>correctMessageWithoutBack("'.Record_Update.'");</script>';
}
// Update record
//-------------------------------------------------

/***********Default Sorting Option*************/
$sort  = ($sort=="")?"ORDER BY id ":$sort ;
if( !isset($sb) )	$sb="id";

/***********Filtering Option*************/
//$whereStmt = createFilter(array('value','weight'), array('%value','%weight'), "AND");


/***********Query*************/

if($whereStmt!=""){	$whereStmt = " WHERE  $whereStmt ";}else{$whereStmt = "  ";}
$sql = "SELECT * FROM site_settings  $whereStmt  $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i=0;?>
<form method='post' name='main' action='<?=$_SERVER['PHP_SELF']?>' enctype='multipart/form-data'>
<input type='hidden' name='action' value=''>
<input type='hidden' name='ids' value=''>
<input type="hidden" name="pro_id" value="<?php echo $pro_id;?>" class="required"/>
<script>
function actionf(act){
	main.action.value = act;
	main.submit();
}
function addDel(par){
	str = main.ids.value;
	main.ids.value = par+","+str;
}
</script>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list"><thead>
<TR>
	<tr>
		<th width="277"><?=print_AdminRecordHead("label", "Name", $sb, $so)?></th>
		<th width="277"><?=print_AdminRecordHead("value", "Value", $sb, $so)?></th>
		<th colspan="1">Controls  </th>
	</tr>
</TR>
</thead><tbody><? 

while ($i<$numberOfRows){
	$id= MYSQL_RESULT($result,$i,"id");
	$value= MYSQL_RESULT($result,$i,"value");
	$label= MYSQL_RESULT($result,$i,"label");

	if($action=="Edit"  && $_REQUEST['id'] == $id){?>
    	<TR>
			<input type="hidden" name="id" value="<?php echo $id;?>" class="required"/>
			<TD><?php echo stripslashes($label)?></TD>
			<?//if($id==4||$id==5){?>
				<!--td><?=createComboBox("wedgits" , "id", "title" , $value , "value", "required");?></td-->
			<?//}else{?>
				<TD><input type="Text" name="value" size="20" value="<?php echo stripslashes($value)?>" class="required"/>  </TD>
			<?//}?>
			
			
			<TD><img src="<?=_PREF?>images/icons/save.png" onClick="actionf('Update')" onMouseOver="over(this)" alt="<?=_Save?>" /></TD>
			
		</TR>
   	  <? 
}// Edit record
else{?>
<TR>
	<TD><?php echo stripslashes($label)?></TD>
	<?//if($id==4||$id==5){?>
		<!--TD><?=lookupField('wedgits' , 'id', "title" ,$value);?></TD-->
	<?//}else{?>
		<TD><?php echo stripslashes($value)?></TD>
	<?//}?>
	

	<TD align="center" WIDTH="20"><?=print_edit_icon($_SERVER['PHP_SELF']."?action=Edit&id=".$id);?></TD>
	
</TR>
<? 	
}//end else
$i++;
}//End While?>
</tbody>
</TABLE>
</form>
<? include_once("../common/footer-admin.php"); ?>