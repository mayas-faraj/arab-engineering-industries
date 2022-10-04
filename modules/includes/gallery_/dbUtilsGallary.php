<?php
function checkGallogin(){
	if($_SESSION['USER']){return true;}else{return false;}
}
function loadFolders($rootPath='',$actPath='',$insidPath='',$level=0,$end=0){
	//echo "(".$rootPath."|".$actPath.")<br>";
	$root='../../../uploads/';
	$rootName=$rootPath;
	if($rootPath==''){$rootName='root';}
	$ret='';	
	if($level==0){
		$insidPath=$rootPath;
		$Fclass="folderI";
		if($actPath==$insidPath){$Fclass="folderI2";}
		$ret.='<input type="hidden"  id="correntPath" value="'.$actPath.'"/>
		<div class="folderCont" onClick="loadFolderList(\''.$rootPath.'\',\''.$insidPath.$file.'\',0)">
		<div class="'.$Fclass.'">root</div></div>';
		$level=1;
		
	}	
	$fullPath=$root.$insidPath;
	//echo $fullPath.'<br>';

	$Files=0;
	$Folders=0;
	if ($Folder = opendir($fullPath)) {
		while (false !== ($file = readdir($Folder))){
			if ($file != "." && $file != "..") {
				if(is_dir($fullPath.$file)){
					$Folders++;
				}else{
					$Files++;
				}
			}
		}
		closedir($Folder);
	}
	
	if ($Folder = opendir($fullPath)){
		$i=0;
		$xFolsers=array('mcith','_notes','.quarantine','.tmb');
		while (false !== ($file = readdir($Folder))){
			if ($file != "." && $file != "..") {
				if (in_array($file,$xFolsers)) {
					$Folders--;
					$i++;
				}else{
					if(is_dir($fullPath.$file)){ 
						$i++;
						$ret.='<div class="folderCont" onClick="loadFolderList(\''.$rootPath.'\',\''.$insidPath.$file.'/\',0)">';
						for($l=1;$l<$level;$l++){
							if($l<$level-$end){
								$ret.='<div class="folder_line"></div>';								
							}else{
								$ret.='<div class="folder_line_empty"></div>';								
							}
						}
						if($i==$Folders){
							$end=$end+1;
							$ret.='<div class="folder_end_line"></div>';							
						}else{
							$ret.='<div class="folder_sub_line"></div>';	
							$end=0;						
						}
						$Fclass="folderI";
						if($actPath==$insidPath.$file.'/'){$Fclass="folderI2";}						
						$ret.='<div class="'.$Fclass.'">'.$file.' </div></div>';
						
						$ret.=loadFolders($rootPath,'',$insidPath.$file.'/',$level+1,$end);					
					}
				}
			}
			
		}
		closedir($Folder);
	}
	return $ret;
}
$files=array();
function loadFiles($path=''){
	global $files;
	$path2=$path;
	if($path==''){
		$path2='../../../uploads/'.$path;
		$level=1;
	}
	if ($Folder = opendir($path2)){
		$xFolsers=array('mcith','_notes','.quarantine','.tmb');
		while (false !== ($file = readdir($Folder))){
			if ($file != "." && $file != "..") {
				if (!in_array($file,$xFolsers)){
					if(is_dir($path2.$file)){												
						loadFiles($path2.$file.'/');					
					}else{
						$files[]=$path2.$file;
						$ret.='<div class="'.$Fclass.'">'.$file.' </div>';
					}
				}
			}			
		}
		closedir($Folder);
	}
	return $files;
}
function delPhoto($id){
	mysql_query("delete from galleries_photos where id='$id'");
}
function checkFile($p){	
	$exs=array('jpg','jpeg','png','gif','flv','mp4','wmv');
	$videos = array('flv','mp4','wmv');
	$c=explode('/',$p);
	$file= end($c); 
	$folder=str_replace($file,'',$p);
	$folder=str_replace('../../../uploads/','',$folder);
	
	$ex=getFileEx($file);
	if(in_array($ex,$exs)){
		if(in_array($ex,$videos)){
			$thumbFile='video';
		}else{
			$thumbFile =  "mcith/mcith_".randomStringUtil(20).'.'.$ex;
		}
		
		$sql="select count(*) as c from galleries_photos where photo='$file' and folder='$folder'";
		$res=mysql_query($sql);
		$count=mysql_result($res,0,'c');
		if($count==0){		
	
			$sql="INSERT INTO galleries_photos  (folder,photo,thumb)values('$folder','$file','$thumbFile')";
			$res=mysql_query($sql);
			return false;
		}else{
			return true;
		}
	}else{ return true ;}
}
function randomStringUtil($length=5){
  $type='num';
  $randstr='';
  srand((double)microtime()*1000000);

  $chars = array ( '1','2','3','4','5','6','7','8','9','0',
  'Q','W','E','R','T','Y','U','I','O','P','L','K','J','H','G','F','D','S','A','Z','X','C','V','B','N','M',
  'q','w','e','r','t','y','u','i','o','p','l','k','j','h','g','f','d','s','a','z','x','c','v','b','n','m'
  );
  if ($type == "alpha") {
    array_push ( $chars, '1' );
  }

  for ($rand = 0; $rand < $length; $rand++)
  {
    $random = rand(0, count($chars) -1);
    $randstr .= $chars[$random];
  }
  return $randstr;
}
function getFileEx($file){
	$ex = explode(".",$file);
	return strtolower(end($ex)); 	
}
function lookupField($table, $id_field, $lookup_field, $id_value) {
	$sql_lookup = "SELECT `$lookup_field` from `$table` where `$id_field` = '$id_value'";
	$result_lookup = MYSQL_QUERY($sql_lookup);	
	$rows_lookup = MYSQL_NUM_ROWS($result_lookup);
	if ($rows_lookup == null || $rows_lookup = 0) {
		return 0;
	} else {
		$filds = explode(",",$lookup_field);
		$ind = 0; $value="";
		while($ind < count($filds)){
			$value.= stripslashes(MYSQL_RESULT($result_lookup,0,$filds[$ind])." ");
			$ind++;
		}
		return trim($value);
	}
}
?>