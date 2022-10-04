<?php
function ShowGallery3($gid,$min=0){
	global $HP;
        echo $min;
	//if($HP==1){$Pref="";}else{$Pref="../../";}
	$Pref="../../";
	$res="";
	$sql2 = "SELECT * FROM galleries_galleries  where  id=$gid ";
	$result2 = mysqli_query($GLOBALS["db_link_conn"], $sql2);
	$numberOfRows2 = mysqli_num_rows($result2);
	if($numberOfRows2>0){
		$photos=mysqli_result($GLOBALS["db_link_conn"], $result2,0,"photos");
		 $sqlG = "SELECT * FROM galleries_photos  where  id in ($photos) ";
		$resultG = mysqli_query($GLOBALS["db_link_conn"], $sqlG);
		$numberOfRowsG = mysqli_num_rows($resultG);
		if($numberOfRowsG>$min){
			$pxx=1;
			$g=0;
			while($numberOfRowsG>$g){
				$PHid=mysqli_result($GLOBALS["db_link_conn"], $resultG,$g,"id");
				$Photo=mysqli_result($GLOBALS["db_link_conn"], $resultG,$g,"photo");
				$photo2=_PREF."uploads/cash/gal3_".$Photo;
				CropSquare($Pref."uploads/".$Photo,100,$Pref."uploads/cash/gal3_".$Photo);
				$res.='<a  class="thumb zoombox zgallery1" href="'._PREF.'uploads/'.$Photo.'" id="thumb_'.$PHid.'" rel="" >';
				$res.='<img src="'.$photo2.'" border="0" class=""></a>';
				$g++;
			}
			
		}
	}

	return $res."&nbsp;";
}
?>