<?
session_start();
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("dbUtilsGallary.php");
if(checkGallogin()){  
?><div style=" margin:10px;" align="left"><?
/************** check deleted images***************/
$sql="select * from galleries_photos ";
$res=mysql_query($sql);
$deletedRecs=0;
$missinFiles='';
while($row=mysql_fetch_array($res)){
	$file='../../../uploads/'.$row['folder'].$row['photo'];	
	if(!file_exists($file)){
		delPhoto($row['id']);
		$missinFiles.='<div style="color:#600">'.$file.'</div>';
		$deletedRecs++;
	}
}
echo 'Missing Files : '.$deletedRecs;
echo "<p>".$missinFiles."</p>";

/**************Sync files***************/
$files=loadFiles('../../../uploads/'.$_POST['folder']);
$syncFiles=0;
$syncFilesList='';
for($i=0;$i<count($files);$i++){
	//echo "<br>".$files[$i];
	if(!checkFile($files[$i])){
		$syncFiles++;
		$syncFilesList.='<div style="color:#060">-'.$files[$i].'</div>';	
	}
}
echo 'Syne Files : '.$syncFiles;
echo "<p>".$syncFilesList."</p>";
}
?>
</div>