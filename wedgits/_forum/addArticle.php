<?php if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} ?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css' />

<script src="<?php echo _PREF; ?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo _PREF; ?>wedgits/forum/tableRowsMgmt.js" language="javascript" type="text/javascript"></script>	


<?php 

$max_dis_files = lookupField('site_settings','id','value',14);
$max_dis_size = lookupField('site_settings','id','value',15);
$dis_files_type = lookupField('site_settings','id','value',16);

$user_id = $_SESSION["us_id"];
$article_id = $_REQUEST['id'];
$results='';
$sub = $_REQUEST['sub'];
$cat_id = $_REQUEST['cat_id'];
if($sub){
	$name = $_REQUEST['name'];
	$brief = $_REQUEST['brief'];
	$details = addslashes($_REQUEST['details']);
	$title = addslashes($_REQUEST['title']);
	$attached_files = $_FILES['attached_files'];
	$lang = _LANG;
	
	if(count($attached_files)==$max_dis_files || count($attached_files)<$max_dis_files){
		$sql = "insert into art_articles (cat_id, title , brief, details, author, publish_date,user_id,active,publish) values ('$cat_id', '$title' ,'$brief' ,'$details' ,'$name' ,now(),'$user_id','1','1')";
		$result =  mysqli_query($GLOBALS["db_link_conn"], $sql);
		if($result)
		{
			//$results = Discussion_has_been_added_successfully;
			$results = "<script>document.location='viewAllArticles.php?cat_id=$cat_id'</script>";
			
		}
		$com_art_id = mysqli_insert_id($GLOBALS["db_link_conn"]);
		
		for ($i = 0; $i < count($attached_files); $i++) {
			$no_space_photo = str_replace(' ', '_',$_FILES['attached_files']['name'][$i]);
			$tempFile = $_FILES['attached_files']['tmp_name'][$i];

			if(filesize($tempFile)>0){
				$file_size = filesize($tempFile)/1024;
			}else{
				$file_size = 0;
			}
			
			if($file_size>$max_dis_size && $file_size!=0){
				$results .= '<br/>'.file.' "'.$_FILES['attached_files']['name'][$i].'" '.could_not_be_add_size.'<br/>';
			}else{
				$path_info = pathinfo($_FILES['attached_files']['name'][$i]);
				$file_ext = $path_info['extension'];
				$dis_files_type_arr = explode(',',$dis_files_type);
				
				if(!in_array($file_ext,$dis_files_type_arr) && $file_ext!=''){
					$results .= '<br/>'.file.' "'.$_FILES['attached_files']['name'][$i].'" '.could_not_be_add_type.'<br/>';
				}else{
					$targetFile = '../../uploads/forums/'.$no_space_photo;
					if(move_uploaded_file($tempFile,$targetFile)){
						$attached_files_sql="INSERT INTO `art_articles_files` (`art_id`,`file`) VALUES ('$com_art_id' , '$no_space_photo' );";
						$attached_files_result = mysqli_query($GLOBALS["db_link_conn"], $attached_files_sql);
					}
				}
			}
		}
	}
	$article_id = $aid ;
}




?>

<div class= "page_content">

	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
	$publish = lookupField('art_categories','id','publish',$_REQUEST['cat_id']);?>
	<div class="title2"><?php echo AddArticle; ?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font>'?></span></div>

		
	
	
	
	 <div class="add_article">
		 <form  method="post" name="subForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			 <input type="hidden" name="art" value="<?php echo $article_id ; ?>" />
			 <input type="hidden" name="cat_id" value="<?php echo $cat_id ; ?>" />
			 <input type="hidden" name="sub" value="1" />
			 
			 <table border="0" cellpadding="0" cellspacing="0">
			 <tr><td width="100px"><?php echo Title ; ?>:</td><td width=1>*&nbsp;</td><td><input type="text" name="title" id="title"  value='<?php echo stripslashes($title); ?>' class="required1" /></td></tr>
<!--
			 <tr><td><?php echo Details; ?>: </td><td width=1>*&nbsp;</td><td>
			 <textarea name="details" class="simpleEditor required1"><?php echo stripslashes($details); ?></textarea>
			 </td></tr>
			 
			 
-->			 
			 <tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="button" name="save" value="<?php echo Post; ?>" class="" onclick='validate_form1(<?php echo $max_dis_size; ?>,"<?php echo $dis_files_type; ?>");' />
			  </td></tr>
			 </table>
			 
			 
		</form>
	</div>	
	<div class='add_result'><?php echo $results; ?></div>
</div>
	