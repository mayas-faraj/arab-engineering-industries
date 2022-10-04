<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/left_menu/left_menu_<?php echo $pageLang; ?>.css'/>
<div class='left_menu'>
	<?php include ('../../wedgits/left_menu_items/left_menu_items.php')?>
<?if($page_name == "viewAllMembers"){?>
	<?php include ('../../wedgits/mebers_filter/mebers_filter.php')?>
<?}?>

<?if($page_name == "viewAllActivities"){?>
	<?php include ('../../wedgits/activities_filter/activities_filter.php')?>
<?}?>

<?if($page_name == "viewAllResources"){?>
	<?php include ('../../wedgits/resources_filter/resources_filter.php')?>
<?}?>

<?if($page_name == "viewAllBod"){?>
	<?php include ('../../wedgits/bod_filter/bod_filter.php')?>
<?}?>
<?php include ('../../wedgits/quick_links/quick_links.php')?>
</div>