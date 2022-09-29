<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/left_menu/left_menu_<?=$pageLang?>.css'/>
<div class='left_menu'>
	<?include('../../wedgits/left_menu_items/left_menu_items.php')?>
<?if($page_name == "viewAllMembers"){?>
	<?include('../../wedgits/mebers_filter/mebers_filter.php')?>
<?}?>

<?if($page_name == "viewAllActivities"){?>
	<?include('../../wedgits/activities_filter/activities_filter.php')?>
<?}?>

<?if($page_name == "viewAllResources"){?>
	<?include('../../wedgits/resources_filter/resources_filter.php')?>
<?}?>

<?if($page_name == "viewAllBod"){?>
	<?include('../../wedgits/bod_filter/bod_filter.php')?>
<?}?>
<?include('../../wedgits/quick_links/quick_links.php')?>
</div>