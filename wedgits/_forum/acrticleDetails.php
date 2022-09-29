<? if(!$_SESSION["us_id"]){echo"<script>document.location='"._PREF."index.php'</script>";} ?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>

<script src="<?php echo _PREF; ?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>	
<script src="<?php echo _PREF; ?>wedgits/forum/tableRowsMgmt.js" language="javascript" type="text/javascript"></script>	

<script src="<?php echo _PREF; ?>wedgits/forum/jquery.form.js" language="javascript" type="text/javascript"></script>	
<script src="<?php echo _PREF; ?>wedgits/forum/file_demo.js" language="javascript" type="text/javascript"></script>	
<?php 
$max_com_files = lookupField('site_settings','id','value',17);
$max_com_size = lookupField('site_settings','id','value',18);
$com_files_type = lookupField('site_settings','id','value',19);
echo "<input type='hidden' name='com_files_type' value='$com_files_type' class='com_files_type'/>";

$article_id = $_REQUEST['id'];
$art_u_id = $_REQUEST['art_u_id'];
$user_id = $_SESSION["us_id"];
$sub = $_REQUEST['sub'];
$attached_files = $_FILES['attached_files'];

$com_id =  $_REQUEST['com_id'];
if($_REQUEST['op'] == "del"){
	deleteRecord("art_comments","id = '$com_id'",true);
	$results = Comment_deleted_successfuly;
}

if($sub){
	$aid = $_REQUEST['art'];
	$name = $_REQUEST['p_name'];

	$subject = $_REQUEST['p_subject'];
	$comment = $_REQUEST['p_comment'];
	
	
		
		
	$pass_validation = true;
	for ($i = 0; $i < count($attached_files); $i++) {
		
		$no_space_photo = str_replace(' ', '_',$_FILES['attached_files']['name'][$i]);
		$tempFile = $_FILES['attached_files']['tmp_name'][$i];
		$fileName = $_FILES['attached_files']['name'][$i];
		$tempFiles .= ','.$tempFile;
		$fileNames .= ','.$fileName;
		
	
		if(filesize($tempFile)>0){
			$file_size = filesize($tempFile)/1024;
		}else{
			$file_size = 0;
		}
		
		if($file_size>$max_com_size && $file_size!=0){
			$results .= file.' "'.$_FILES['attached_files']['name'][$i].'" '.could_not_be_add_size;
			$pass_validation = false;
		}
		
		
	}
	
	if(!$pass_validation){
		echo '<script>$("document").ready(function(){$("#uploadOutput").html("");});</script>';
		echo "<script>alert('".$results."');</script>";
	}else{
		$sql = "insert into art_comments (art_id , subject, comment, publish_date, user_id, active) values ('$aid', '$subject', '$comment' ,now(), '$user_id', '1')";
		$result =  MYSQL_QUERY($sql);
		if($result){
			$com_art_id = mysql_insert_id();
			for ($i = 0; $i < count($attached_files); $i++) {
			
				$no_space_photo = str_replace(' ', '_',$_FILES['attached_files']['name'][$i]);
				$tempFile = $_FILES['attached_files']['tmp_name'][$i];
				$fileName = $_FILES['attached_files']['name'][$i];
				$tempFiles .= ','.$tempFile;
				$fileNames .= ','.$fileName;
				
			
				if(filesize($tempFile)>0){
					$file_size = filesize($tempFile)/1024;
				}else{
					$file_size = 0;
				}
				
				if($file_size>$max_com_size && $file_size!=0){
					$results .= file.' "'.$_FILES['attached_files']['name'][$i].'" '.could_not_be_add_size;
					$pass_validation = false;
				}else{
					$targetFile = '../../uploads/forums/'.$no_space_photo;
					if(move_uploaded_file($tempFile,$targetFile)){
						$attached_files_sql="INSERT INTO `art_comments_files` (`comment_id`,`file`) VALUES ('$com_art_id' , '$no_space_photo' );";
						$attached_files_result = mysql_query($attached_files_sql);
					}
				}
				
				
			}
			$grp_ids = returnImplode_ids('topic_groups'," topic_id = '".$_REQUEST['cat_id']."' ",'grp_id');
			$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
			$users_emails = returnImplode_ids('users'," user_id in ($allowed_users) ",'email');
					
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: "._INFO." \r\n";
			$subject ="New Discussion comment";
			$message ='A new comment published on your discussion page.<br/> To check it out please login and go to this <a href="http://'._SITE.'/view/forum/viewArticles.php?id='.$aid.'">page</a><br/>';
			$user_message .= $message_form;
			
			$s = @mail($users_emails, $subject, $message, $headers);
		
			echo '<script>
					alert("Rquest submitted successfuly");
					
					refresh("viewArticles.php?cat_id=5&id=28"); 
					
					$("document").ready(function(){$("#uploadOutput").html(""); });
				</script>';
			
		}
	
	}
	
	
	
	
	
	
	
		
	
	$article_id = $aid ;
}



?>

<div class="page_content" dir='<?php echo _DIR; ?>'>

	<?
//$photo_path ="../../uploads/";


$sql =  "SELECT * FROM art_articles WHERE (id=$article_id) and (publish_date <= date(now())) and  active='1' ORDER BY publish_date DESC, id DESC ";
$result = MYSQL_QUERY($sql);
$numrows = MYSQL_NUMROWS($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		$id=mysql_result($result, $i,"id");
		$title=stripslashes(mysql_result($result, $i,"title"));
		$publish_date=mysql_result($result, $i,"publish_date");
		$details = stripslashes(mysql_result($result, $i,"details"));
		$art_u_id = mysql_result($result, $i,"user_id");
		$cat_id = mysql_result($result, $i,"cat_id");
		$publish_comment = mysql_result($result, $i,"publish");
		$cat_id = mysql_result($result, $i,"cat_id");
		$forum = lookupField('art_categories','id','name',$cat_id);
		$author = lookupField('users','user_id','full_name',$art_u_id);
		
		?>

	<?$user_name = lookupField('users','user_id','full_name',$_SESSION["us_id"]);
	$publish = lookupField('art_categories','id','publish',$_REQUEST['cat_id']);?>
	<div class="title2"><?php echo forum; ?>: &nbsp; <?php echo $forum; ?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.$_SESSION["us_id"].'&cat_id='.$_REQUEST['cat_id'].'">'.$user_name.'</a></font>'?></span></div>
	<div class="title2" <?if($pageLang=='ar'){?>style='font-size:18px;'<?}else{?>style='font-size:15px;'<?}?> ><?php echo Subject; ?>: &nbsp; <?php echo $title; ?></div>
	
	<div class="annonce_details">
		<div class="annonce_dinfo">
		<!--<?php echo Author; ?> : <a href='viewAllForumMembers.php?id=<?php echo $cat_id; ?>#user<?php echo $art_u_id; ?>'><?php echo $author; ?></a>
		<br>
		<?php echo PublishDate; ?> : <?php echo $publish_date; ?>-->
		
		</div>
		<div class="annonce_details_body">
			<!--div class="annonce_details_txt"><?php echo $details; ?></div-->
			<div class="annonce_details_txt">
				<?
					$attach_sql =  "SELECT * FROM art_articles_files WHERE (art_id=$article_id) ";
					$attach_result = MYSQL_QUERY($attach_sql);
					$attach_numrows = MYSQL_NUMROWS($attach_result);
					if($attach_numrows>0){
						echo attached_files."<br/>";
						$i=0;
						while($i<$attach_numrows){
							$attached_file = basename(mysql_result($attach_result,$i,'file'));
							echo "<a href='../../uploads/forums/$attached_file'>$attached_file</a><br/>";
							$i++;
						}
					}
				?>
				
				
			<div/>
		</div>
	</div>
	
                         
	
<? 
	/*************************View Comments***********************/
	
?>
	
	<div class="progList_comments">
	<div class="progList_comments_title"><?php echo Comments; ?> :
	
	</div>
	 <?
	$sql="select * from art_comments where art_id = $article_id  AND active=1 order by publish_date ASC";
	
	$result=mysql_query($sql);
	$rows=mysql_num_rows($result);
	if($rows){
		$i=0;
		if($rows>5){echo "<div class='hidden_comments'>";}
		while($i<$rows){
			$id =mysql_result($result, $i,"id");
			$comment_date =mysql_result($result, $i,"publish_date");
			$subject =mysql_result($result, $i,"subject");
			$comment =mysql_result($result, $i,"comment");
			$active =mysql_result($result, $i,"active");
			$u_id =mysql_result($result, $i,"user_id");
			$publisher = lookupField('users','user_id','full_name',$u_id);
			
			
			
			if($art_u_id==$user_id){$owner= true;}else{$owner=false;}
			if(!$owner && $active==0){$hide= true;}else{$hide=false;}
			if(!$hide || $owner){
			?>
				<div class="comment_item">
					<div class="comment_header">
						<div class="publisher"><?php echo $publisher; ?></div>
						<div class="publisher"><?php echo $subject; ?></div>
						<?if($owner){?>
							<!--div class="nav">
								<a href="../../wedgits/forum/checkbox.php?t=art_comments&fn=active&idn=id&idv=<?php echo $id; ?>&fv=<?php echo !($active); ?>" class="checkb" ><img src="<?php echo _PREF; ?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?php echo !($active); ?>"/></a>
								<a href="viewArticles.php?id=<?php echo $article_id; ?>&op=del&com_id=<?php echo $id; ?>" class="delete"><img src="<?php echo _PREF; ?>images/icons/Delete.png"  border=0></a>
							</div-->
						<?}?>
						<div class="comment_date"><?php echo $comment_date; ?></div>
					</div>
					<div class="comment_body">
						<?php echo $comment; ?>
						<?
							$attach_sql =  "SELECT * FROM art_comments_files WHERE (comment_id=$id) ";
							$attach_result = MYSQL_QUERY($attach_sql);
							$attach_numrows = MYSQL_NUMROWS($attach_result);
							if($attach_numrows>0){
								echo "<br/>".attached_files."<br/>";
								$si=0;
								while($si<$attach_numrows){
									$attached_file = basename(mysql_result($attach_result,$si,'file'));
									echo "<a href='../../uploads/forums/$attached_file'>$attached_file</a><br/>";
									$si++;
								}
							}
						?>
					</div>
				</div>
			<?
			}
			if($i==($rows-6)){echo "</div>";}
			$i++;
		}
		if($i>5){echo "<div class='see_more_com'>".see_more_com."</div>";}
		
	}
	?>

	</div>
		<?
		$i++;
	}
}

?>  


	<script>
		$('document').ready(function(){
			$('.see_more_com').click(function(){
				$(this).hide();
				$('.hidden_comments').show();
			});
		});
	</script>                                                 
	
</div>













	<? /*************************Add Comments***********************/?>
	<div class="com_add">
		<?if($publish && $publish_comment){?><a href="#" onclick="$('.progList_Addcomment').show();return false;"><?php echo AddComment; ?></a><?}?>
	</div>
	 <div class="progList_Addcomment">
	<form  method="post" name="subForm" id='uploadForm' action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	 <input type="hidden" name="art" value="<?php echo $article_id ; ?>" />
	 <input type="hidden" name="art_u_id" value="<?php echo $art_u_id ; ?>" />
	 <input type="hidden" name="cat_id" value="<?php echo $_REQUEST['cat_id'] ; ?>" />
	 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ; ?>" />
	 <input type="hidden" name="sub" value="1" />
	 <table border="0" cellpadding="0" cellspacing="0">
	
	 
		 <tr><td valign='top'><?php echo Subject; ?>:</td><td><input type='text'  style='width:400px;' name='p_subject' class="required1"/></textarea></td></tr>
		 <tr><td valign='top'><?php echo Comment; ?>:</td><td><textarea rows="5" style='height:100px; width:400px;' name="p_comment" id="p_comment"  /></textarea></td></tr>
		 
		 <tr>
			 <td valign='top' width='150'><?php echo attached_files; ?></td><td>
				<h6 style="float: <?php echo _ALI?>"><?php echo DELETE_SELECTED; ?> &nbsp;<img style="cursor:pointer" src="<?php echo _PREF; ?>wedgits/forum/x.png" title="Delete Selected Row(s)" onClick="deleteRow('list')" /></h6>				
					<table dir='<?php echo _DIR; ?>' align="center" id="list" width="400px" class="list" border="0" cellpadding="0" cellspacing="0" style='float:<?php echo _SALI; ?>'>
						<thead>
							<tr>
								<td >&nbsp;</td>
								<td>&nbsp;</td>
								<td align="<?php echo _SALI; ?>"> <?php echo allowed_files; ?> (<?php echo $com_files_type; ?>) <br/> <?php echo Maximum_allowed_size_for_each_file; ?> (<?php echo $max_com_size; ?>)<?php echo KB; ?> </td>
							</tr>
						</thead>
						<tr>
							<td><img style="cursor:pointer" src="<?php echo _PREF; ?>wedgits/forum/plus.png" title="Add Row" onClick="addRow('list',<?php echo $max_com_files; ?>)"/></td>
							<td><input type="checkbox" name="chk"/></td>
							<td><input type="file" name="attached_files[]" class='file'/></td>
						</tr>
					</table>
			 </td>
		 </tr>
		 <input type='hidden' id="uploadResponseType" name="mimetype" value='html'/>
		 <tr><td>&nbsp;</td>
		 <td>
			<input value="Submit 1" name="uploadSubmitter1" type="submit" class='submit_it' >
			<!--input  type="submit" name="save" value="<?php echo Save; ?>" class="save_com" onclick='validate_form1(<?php echo $max_com_size; ?>,"<?php echo $com_files_type; ?>");' /-->
		</td></tr>
	  
	  
	 </table>
	 
	 
	 </form>
	</div>	   
<div id='uploadOutput'></div>

</div>
<div class='result'><?php echo $results; ?></div>                          
<input type='button' value='<?php echo Back; ?>' class='back' onClick='history.back()'/>
</div>


