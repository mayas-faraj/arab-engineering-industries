<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/committees/committees_<?=$pageLang?>.css'/>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/gallery/zoombox/zoombox.css'/>	
<script src="<?=_PREF?>wedgits/gallery/zoombox/zoombox.js" language="javascript" type="text/javascript"></script>
<script src="<?=_PREF?>wedgits/gallery/gallery.js" language="javascript" type="text/javascript"></script>
<div class='page_content'>
<?
$id = cleanString($_REQUEST['id']);
$currentdate=date("Y-m-d");
$sql = "SELECT * FROM mem_committees WHERE  active='1' and id='$id'  ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
echo$private=mysql_result($result, 0,"	private_en");
if ($numberOfRows>0) {
	$i=0;
	while ($i<$numberOfRows){
		
		
		$id=mysql_result($result, $i,"id");
		$subject=mysql_result($result, $i,"name_".$pageLang);
		$details=stripslashes(mysql_result($result, $i,"description_".$pageLang));
		$private=stripslashes(mysql_result($result, $i,"private_".$pageLang));
		
		$start_date=mysql_result($result, $i,"creation_date");
		if($start_date=='0000-00-00'){
			$start_date='';
		}else{
			$start_date=date('d / m / Y',strtotime($start_date));
		}
		
		
		echo "<div class='title2'><span>$subject</span></div><div class='ln_date'>$start_date</div> ";
		
		
		echo "		<div class='page_dt'>$details</div>";
		if($_SESSION["us_id"]){
			echo	"<div class='page_dt'>$private</div>";
		} 		
		
		
		$i++;
	}
}
	
?>
<input type='button' value='<?=Back?>' class='more_btn' onClick='history.back()'/>
</div>

