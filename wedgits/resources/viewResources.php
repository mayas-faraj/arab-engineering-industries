<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/resources/resources_<?php echo $pageLang; ?>.css'/>	

<div class='page_content'>
<?php
$id = cleanString($_REQUEST['id']);
$currentdate=date("Y-m-d");
$sql = "SELECT * FROM resources WHERE   id='$id'  ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

if ($numberOfRows>0) {
	$i=0;
	while ($i<$numberOfRows){
		
		
		$id=mysql_result($result, $i,"id");
		$subject=mysql_result($result, $i,"title");
		$brief=mysql_result($result, $i,"details");
		$photo=mysql_result($result, $i,"photo");
		$private=mysql_result($result, $i,"private");
		if($photo){
			$photo2= basename($photo);
			$thumb = basename(resizeToFile($photo, 400 , 300 , "../../uploads/cash/viewResources_".$photo2));	
			$src = "<img style='float:"._SALI."; clear:both; ' src='../../uploads/cash/viewResources_$photo2'/> ";
		}else{
			$src = '';
		}
		
		
		
		
		
		echo "<div class='title2'>$subject</div>";
		

		echo "	<div  class='resources_con' dir='"._DIR."'>
					$src
					<div class='page_dt'>$brief</div>";
					if($_SESSION["us_id"]){
						echo	"<div class='page_dt'>$private</div>";
					} 	
					
		echo " </div>";
		
		
		$i++;
	}
}
	
?>
<input type='button' value='<?php echo Back; ?>' class='more_btn' onClick='history.back()'/>
</div>

