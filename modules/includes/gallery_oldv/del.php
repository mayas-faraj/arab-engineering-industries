<? 
session_start();
include_once("../../../config.php");
include_once("../../common/dbConnection.php");
if(isset($_REQUEST['id'])){
	$Mid=$_REQUEST['id'];
	$_SESSION['Mid']=$Mid;
	$sql = "SELECT * FROM galleries_galleries  $sort $limit ";
	$res= mysql_query($sql);
	$rows = mysql_numrows($res);
	if ($rows>0) {
		$i=0;
		$counter=0;
		$albs='';
		while ($i<$rows){
			$id= mysql_result($res,$i,"id");
			$gallery_name= mysql_result($res,$i,"gallery_name");
			$description= mysql_result($res,$i,"description");
			$main_photo= mysql_result($res,$i,"main_photo");
			$photos= mysql_result($res,$i,"photos");		
			$phos=explode(',',$photos);
			$e=0;
			for($f=0;$f<count($phos);$f++){
				if($phos[$f]==$Mid){
					$e=1;
					$counter++;	
				}
			}
			if($e==1){
				$albs.='<div>'.$counter.' - '.$gallery_name.'</div>';
			}
			$i++;
		}
		if($counter>0){
			echo 'الألبومات التي تحتوي هذه الصورة : ('.$counter.') '.$albs;
			
		}else{
			echo 'لم يتم إضافة هذه الصورة لأي ألبوم';
		}
	}
}
else if(isset($_SESSION['Mid'])&&$_SESSION['Mid']!=0){
	/*----------------Delete Photo from Galleries----------- */
	$Mid=$_SESSION['Mid'];
	$sql = "SELECT * FROM galleries_galleries ";
	$res= mysql_query($sql);
	$rows = mysql_numrows($res);
	if ($rows>0) {
		$i=0;
		
		$albs='';
		while ($i<$rows){
			$id= mysql_result($res,$i,"id");
			$gallery_name= mysql_result($res,$i,"gallery_name");
			$description= mysql_result($res,$i,"description");
			$main_photo= mysql_result($res,$i,"main_photo");
			$photos= mysql_result($res,$i,"photos");
			$phos=explode(',',$photos);
			$e=0;
			$new_photos='';
			$counter=0;
			$Mpoto=0;
			for($f=0;$f<count($phos);$f++){
				if($phos[$f]==$Mid){
					$e=1;
					$counter++;	
					if($phos[$f]==$main_photo){
						$Mpoto=$phos[$f];
						
					}
				}else{
					$new_photos.=$phos[$f].',';
				}
			}
			$new_photos=substr($new_photos,0,strlen($new_photos)-1);
			$Q='';
			if($counter>0){
				if($Mpoto!=0){
					$mp2=explode(',',$new_photos);
					if(count($mp2)>0){
						$Q= " , `main_photo` = '".$mp2[0]."' ";
					}
				}
				$sql2 = "UPDATE `galleries_galleries` SET `photos` = '$new_photos' $Q  WHERE `id` =$id LIMIT 1 ;";
				$res2= mysql_query($sql2);
			}
			
			$i++;
		}
		$sql3 = "SELECT * FROM galleries_photos where id=$Mid limit 1 ";
		$res3= mysql_query($sql3);
		$rows3 = mysql_numrows($res3);
		if($rows3>0){
			$photo=mysql_result($res3,0,'photo');
			$sql4 = "DELETE FROM `galleries_photos` WHERE `id` =$Mid LIMIT 1 ;";
			$res4= mysql_query($sql4);
			@unlink(_PREF.'uploads/'.$photo);
			@unlink(_PREF.'uploads/mcith/mcith_'.$photo);
		}
	}
	echo $_SESSION['Mid'];
	$_SESSION['Mid']=0;
}
?>