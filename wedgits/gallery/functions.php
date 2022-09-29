<?
function ShowGallery3($gid,$min=0){
	global $HP;
        echo $min;
	//if($HP==1){$Pref="";}else{$Pref="../../";}
	$Pref="../../";
	$res="";
	$sql2 = "SELECT * FROM galleries_galleries  where  id=$gid ";
	$result2 = MYSQL_QUERY($sql2);
	$numberOfRows2 = MYSQL_NUMROWS($result2);
	if($numberOfRows2>0){
		$photos=MYSQL_RESULT($result2,0,"photos");
		 $sqlG = "SELECT * FROM galleries_photos  where  id in ($photos) ";
		$resultG = MYSQL_QUERY($sqlG);
		$numberOfRowsG = MYSQL_NUMROWS($resultG);
		if($numberOfRowsG>$min){
			$pxx=1;
			$g=0;
			while($numberOfRowsG>$g){
				$PHid=MYSQL_RESULT($resultG,$g,"id");
				$Photo=MYSQL_RESULT($resultG,$g,"photo");
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