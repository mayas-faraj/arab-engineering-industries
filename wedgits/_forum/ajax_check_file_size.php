<?php include_once("../../view/common/top.php"); 

$tempFiles = ($_REQUEST['tempFiles']);
$tempFiles = trim($tempFiles,',');
$tempFiles_arr = explode(",", $tempFiles);

$fileNames = ($_REQUEST['fileNames']);
$fileNames = trim($fileNames,',');
$fileNames_arr = explode(",", $fileNames);



			
for ($i = 0; $i < count($tempFiles_arr); $i++) {
	if(filesize($tempFiles_arr[$i])>0){
		$file_size = filesize($tempFiles_arr[$i])/1024;
	}else{
		$file_size = 0;
	}
	/*if($file_size>$max_com_size && $file_size!=0){
		$results .= '<br/>'.file.' "'.$fileNames_arr[$i].'" '.could_not_be_add_size.'<br/>';
	}*/
	$result .= '||'.$file_size;
}
echo $result;

?>