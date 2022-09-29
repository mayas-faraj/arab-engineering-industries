<?
function availableForm($formName){
	$thisUserId = getCurrentUserId();
	if($thisUserId=="") checkCurrentUser();
	if(!authentication($formName) && $formName != "login")
		return false;
	else
		return true;
	}

?>


<table width="200" border="0" align="center" cellpadding="0" cellspacing="10" id="menu">
<tr>
  <td>
  	<div class="title">Site Settings</div>
	<?if(availableForm('listMenus')){?>
	<div style="padding-left:10px;"><a href="../menus/listMenus.php"><?=Menus?></a></div>
	<?}if(availableForm('listPages')){?>
	<div style="padding-left:10px;"><a href="../pages/listPages.php"><?=Text?></a></div>
	<?}if(availableForm('listQuery_forms')){?>
	<div style="padding-left:10px;"><a href="../qforms/listQuery_forms.php"><?=Forms?></a></div>
	<?}if(availableForm('seo')){?>
	<div style="padding-left:10px;"><a href="../common/seo.php?filename=" class="dialog-form">SEO Default settings</a></div>
	<?}if(availableForm('listSite_settings')){?>
	<div style="padding-left:10px;"><a href="../site_settings/listSite_settings.php">Site settings</a></div>
	<?}if(availableForm('listGalleries')){?>
	<div style="padding-left:10px;"><a href="../galleries/listGalleries.php"><?=Galleries?></a></div>
	<?}if(availableForm('listResources')){?>
	<div style="padding-left:10px;"><a href="../resources/listResources.php">FYI</a></div>
	<?}if(availableForm('listHighlight')){?>
	<div style="padding-left:10px;"><a href="../setting/listHighlight.php"><?=Highlights?></a></div>
	<?}if(availableForm('listEvents')){?>
	<div style="padding-left:10px;"><a href="../events/listEvents.php"><?=Events?></a></div>
	<?}if($_SESSION['GRP']=='2'){?>
	<div style="padding-left:10px;"><a href="../elfinder/elfinder.html" target="_blank">File Manager</a></div>
	<?}?>
	<!--div style="padding-left:10px;"><a href="../cms/listModules.php"><?=Modules?></a></div-->
	</td>
</tr>
<tr>
  <td>
  	<div class="title">AFEI</div>
	<?if(availableForm('listNews')){?>
	<div style="padding-left:10px;"><a href="../news/listNews.php">Announcements</a></div>
	<?}if(availableForm('listMembers')){?>
	<div style="padding-left:10px;"><a href="../members/listMembers.php">AFEI Members</a></div>
	<?}if(availableForm('listCouncilMembers')){?>
	<div style="padding-left:10px;"><a href="../council/listCouncilMembers.php">BOD</a></div>
	<?}if(availableForm('listcomittees')){?>
	<div style="padding-left:10px;"><a href="../committees/listComittees.php">Committees</a></div>
	<?}if(availableForm('listActivities')){?>
	<div style="padding-left:10px;"><a href="../activities/listActivities.php">Activities</a></div>	
	<?}?>
	</td>
</tr>
</table>