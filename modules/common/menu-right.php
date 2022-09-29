<table width="200" border="0" align="center" cellpadding="0" cellspacing="10" id="menu">
<tr>
  <td>
  	<div class="title">General Settings</div>
	<?if(availableForm('fields')){?>
	<div style="padding-left:10px;"><a href="../setting/fields.php">Activity Fields</a></div>
	<?}if(availableForm('levels')){?>
	<div style="padding-left:10px;"><a href="../setting/levels.php">Activity Levels</a></div>
	<?}if(availableForm('types')){?>
	<div style="padding-left:10px;"><a href="../setting/types.php">Activity Types</a></div>
	<?}if(availableForm('specialization')){?>
	<div style="padding-left:10px;"><a href="../setting/specialization.php">Sub sector</a></div>
	<?}if(availableForm('terms')){?>
	<div style="padding-left:10px;"><a href="../setting/terms.php">Terms</a></div>
	<?}if(availableForm('listCountry')){?>
	<div style="padding-left:10px;"><a href="../country/listCountry.php"><?=Countries?></a></div>
	<?}?>
	</td>
</tr>
<tr>
  <td>
  	<div class="title">Forum</div>
	<?if(availableForm('listArticlesCat')){?>
	<div style="padding-left:10px;"><a href="../articles/listArticlesCat.php">Active Forums</a></div>
	<?}if(availableForm('listUsers')){?>
	<div style="padding-left:10px;"><a href="../forum_users/listUsers.php">User</a></div>
	<?}if(availableForm('listUsers_groups_forum')){?>
	<div style="padding-left:10px;"><a href="../forum_users/listUsers_groups_forum.php">Users Groups</a></div>
	<?}?>
	
	</td>
</tr>
<tr>
  <td>
  	<div class="title">Users</div>
	<?if(availableForm('listUsers')){?>
	<div style="padding-left:10px;"><a href="../users/listUsers.php">User</a></div>
	<?}if(availableForm('listUsers_groups')){?>
	<div style="padding-left:10px;"><a href="../users/listUsers_groups.php">Users Groups</a></div>
	<?}if(availableForm('editPass')){?>
	<div style="padding-left:10px;"><a href="../users/editPass.php">Update info</a></div>
	<?}?>
	<div style="padding-left:10px;"><a href="../login/logout.php">Logout</a></div>
	</td>
</tr>
</table>