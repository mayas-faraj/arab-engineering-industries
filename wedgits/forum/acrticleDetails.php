<?php if(!cleanString($_SESSION["us_id"])){echo"<script>document.location='"._PREF."index.php'</script>";exit();} ?>	
<link rel="stylesheet" type="text/css" href='<?php echo _PREF; ?>wedgits/forum/articles_<?php echo $pageLang; ?>.css'/>

<script src="<?php echo _PREF; ?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>	
<script src="<?php echo _PREF; ?>wedgits/forum/tableRowsMgmt.js" language="javascript" type="text/javascript"></script>	
<?php 
$max_com_files = lookupField('site_settings','id','value',17);
$max_com_size = lookupField('site_settings','id','value',18);
$com_files_type = lookupField('site_settings','id','value',19);

$article_id = cleanString($_REQUEST['id']);
$art_u_id = cleanString($_REQUEST['art_u_id']);
$user_id = cleanString($_SESSION["us_id"]);
$sub = cleanString($_REQUEST['sub']);
$attached_files = cleanString($_FILES['attached_files']);
$alert_results = 0;
$com_id =  cleanString($_REQUEST['com_id']);
/*if($_REQUEST['op'] == "del"){
	deleteRecord("art_comments","id = '$com_id'",true);
	$results = Comment_deleted_successfuly;
}*/
date_default_timezone_set("GMT");

if($sub){
	$aid = cleanString($_REQUEST['art']);
	$name = cleanString($_REQUEST['p_name']);

	$com_subject = cleanString($_REQUEST['p_subject']);
	$comment = cleanString($_REQUEST['p_comment']);

	//if($validation_passed){
		$full_date = date('h:iA T - M d');
		$sql = "insert into art_comments (art_id , subject, comment, publish_date, user_id, active) values ('$aid', '$com_subject', '$comment' ,now(), '$user_id', '1')";
		$result =  mysqli_query($GLOBALS["db_link_conn"], $sql);
		$com_art_id = mysqli_insert_id($GLOBALS["db_link_conn"]);
		if($result){
			for ($i = 0; $i < count($attached_files); $i++) {
				$file_name = $_FILES['attached_files']['name'][$i];
				$no_space_photo = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).'.'.substr(strrchr($_FILES['attached_files']['name'][$i], '.'), 1);;/*$_FILES['attached_files']['name'][$i];*/
				$tempFile = $_FILES['attached_files']['tmp_name'][$i];
				$file_size = $_FILES['attached_files']['size'][$i];
				
				if($file_size>0){
					$file_size = $file_size/1024;
				}else{
					$file_size = 0;
				}
				
				//echo $file_size.'</br>';
				if($file_size>$max_com_size && $file_size!=0){
					if(!$alert_results){
						$alert_results = ''.Sorry.'<br/>'.file;
					}
					$alert_results .= ''.$_FILES['attached_files']['name'][$i].' <br/>';
				}else{
					$targetFile = '../../uploads/forums/'.$no_space_photo;
					if(move_uploaded_file($tempFile,$targetFile)){
						$attached_files_sql="INSERT INTO `art_comments_files` (`comment_id`,`file`,`file_name`) VALUES ('$com_art_id' , '$no_space_photo','$file_name' );";
						$attached_files_result = mysqli_query($GLOBALS["db_link_conn"], $attached_files_sql);
					}
				}
				
				
			}
			
			if($alert_results){
				$alert_results .= could_not_be_add_size.' '.$max_com_size.' '.KB;
			}
		
			$grp_ids = returnImplode_ids('topic_groups'," topic_id = '".cleanString($_REQUEST['cat_id'])."' ",'grp_id');
			$allowed_users = returnImplode_ids('forum_users_groups'," grp_id in ($grp_ids) ",'user_id');
			$users_emails = returnImplode_ids('users'," user_id in ($allowed_users) ",'email');
			$user_name = lookupField('users','user_id','full_name',$user_id);
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: "._INFO." \r\n";
			$subject ="New discussion comment";
			$message ='<div dir="ltr">
			<span style="color:#bababa; font-weight:bold;" >'.$full_date.'</span><br/>
			'.$user_name.' has posted a new comment<br/> 
			Subject: '.$com_subject.'<br/>
			Comment: '.$comment.'<br/>
			<a href="http://'._SITE.'/view/forum/viewArticles.php?id='.$aid.'">View discussion on the AFEI website</a><br/></div>';
			$user_message .= $message_form;
			
			$s = @mail($users_emails, $subject, $message, $headers);
		
		
		}
	//}

	$article_id = $aid ;
}


?>

<div class="page_content" dir='<?php echo _DIR; ?>'>

	<?php
//$photo_path ="../../uploads/";


$sql =  "SELECT * FROM art_articles WHERE (id=$article_id) and (publish_date <= date(now())) and  active='1' ORDER BY publish_date DESC, id DESC ";
$result = mysqli_query($GLOBALS["db_link_conn"], $sql);
$numrows = mysqli_num_rows($result);
if ($numrows>0) {
	$i=0;
	while ($i<$numrows){
		$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
		$title=stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"title"));
		$publish_date=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"publish_date");
		$details = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i,"details"));
		$art_u_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"user_id");
		$cat_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"cat_id");
		$publish_comment = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"publish");
		$cat_id = mysqli_result($GLOBALS["db_link_conn"], $result, $i,"cat_id");
		$forum = lookupField('art_categories','id','name',$cat_id);
		$author = lookupField('users','user_id','full_name',$art_u_id);
		
		?>

	<?$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
	$publish = lookupField('art_categories','id','publish',cleanString($_REQUEST['cat_id']));?>
	<div class="title2"><?php echo forum; ?>: &nbsp; <?php echo $forum; ?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.cleanString($_SESSION["us_id"]).'&cat_id='.cleanString($_REQUEST['cat_id']).'">'.$user_name.'</a></font>'?></span></div>
	<div class="title2" <?if($pageLang=='ar'){?>style='font-size:18px;'<?}else{?>style='font-size:15px;'<?}?> ><?php echo Subject; ?>: &nbsp; <?php echo $title; ?></div>
	
	<div class="annonce_details">
		<div class="annonce_details_body">
			<!--div class="annonce_details_txt"><?php echo $details; ?></div-->
			<div class="">
				<?php
					$attach_sql =  "SELECT * FROM art_articles_files WHERE (art_id=$article_id) ";
					$attach_result = mysqli_query($GLOBALS["db_link_conn"], $attach_sql);
					$attach_numrows = mysqli_num_rows($attach_result);
					if($attach_numrows>0){
						echo attached_files."<br/>";
						$i=0;
						while($i<$attach_numrows){
							$attached_file = basename(mysqli_result($GLOBALS["db_link_conn"], $attach_result,$i,'file'));
							echo "<a href='../../uploads/forums/$attached_file'>$attached_file</a><br/>";
							$i++;
						}
					}
				?>
				
				
			<div/>
		</div>
	</div>
	
                         
	
<?php 
	/*************************View Comments***********************/
	
	$sql="select * from art_comments where art_id = $article_id  AND active=1 order by publish_date ASC";
	
	$result=mysqli_query($GLOBALS["db_link_conn"], $sql);
	$rows=mysqli_num_rows($result);
	?>
	<div class="progList_comments">
	<div class="progList_comments_title">
		<?php echo Comments; ?> :
		<?if($rows>3){echo "<div class='see_more_com'>".see_more_com." ($rows)</div>";}?>
		
	</div>
	<?php
	if($rows){
		$i=0;
		if($rows>3){echo "<div class='hidden_comments'>";}
		while($i<$rows){
			$id =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
			$comment_date =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"publish_date");
			
			$publish_date=date('Y-m-d',strtotime($comment_date));
			$publish_time=date('h:iA T ',strtotime($comment_date));
			
			
			$subject =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"subject");
			$comment =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"comment");
			$active =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"active");
			$u_id =mysqli_result($GLOBALS["db_link_conn"], $result, $i,"user_id");
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
						<div class="comment_date"><?php echo $publish_time.' '.$publish_date; ?></div>
					</div>
					<div class="comment_body">
						<?php echo $comment; ?>
						<?php
							$attach_sql =  "SELECT * FROM art_comments_files WHERE (comment_id=$id) ";
							$attach_result = mysqli_query($GLOBALS["db_link_conn"], $attach_sql);
							$attach_numrows = mysqli_num_rows($attach_result);
							if($attach_numrows>0){
								echo "<br/>".attached_files."<br/>";
								$si=0;
								while($si<$attach_numrows){
									$attached_file = basename(mysqli_result($GLOBALS["db_link_conn"], $attach_result,$si,'file'));
									$file_name = basename(mysqli_result($GLOBALS["db_link_conn"], $attach_result,$si,'file_name'));
									echo "<a target='_blank' href='../../wedgits/forum/downloadFile.php?file=$attached_file&org=$file_name'>$file_name</a><br/>";
									$si++;
								}
							}
						?>
					</div>
				</div>
			<?php
			}
			if($i==($rows-4)){echo "</div>";}
			$i++;
		}
		if($i>3){echo "<div class='see_more_com'>".see_more_com." ($rows)</div>";}
		
	}
	?>

	</div>
		<?php
		$i++;
	}
}

?>  


	<script>
		$('document').ready(function(){
			$('.see_more_com').click(function(){
				$('.see_more_com').hide();
				$('.hidden_comments').show();
			});
		});
	</script>                                                 
	
</div>













	<?php /*************************Add Comments***********************/?>
	<div class="com_add">
		<?/*if($publish && $publish_comment){?><a href="#" onclick="$('.progList_Addcomment').show();return false;"><?php echo AddComment; ?></a><?}*/?>

	</div>
	 <div class="progList_Addcomment">
	<form  method="post" name="subForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	 
	 
	<div class="comment_item">
		<div class="comment_header">
			<div class="publisher"><?php echo AddComment; ?></div>
			
		</div>
		<div class="comment_body">
			<input type="hidden" name="art" value="<?php echo $article_id ; ?>" />
			 <input type="hidden" name="art_u_id" value="<?php echo $art_u_id ; ?>" />
			 <input type="hidden" name="cat_id" value="<?php echo cleanString($_REQUEST['cat_id']); ?>" />
			 <input type="hidden" name="id" value="<?php echo cleanString($_REQUEST['id']); ?>" />
			 <input type="hidden" name="sub" value="1" />
			<table border="0" cellpadding="0" cellspacing="0">
	
	 
				 <tr><td valign='top'><?php echo Subject; ?>:</td><td><input type='text'  style='width:400px;' name='p_subject' class="required1"/></textarea></td></tr>
				 <tr><td valign='top'><?php echo Comment; ?>:</td><td><textarea rows="5" style='height:100px; width:400px;' name="p_comment" id="p_comment"  /></textarea></td></tr>
				 
				 <tr>
					 <td valign='top' width='150'><?php echo attached_files; ?><br/><div class=" view_terms" style='cursor:pointer;'><a><?php echo view_com_info; ?></a></div></td>
					 <td>
						
							<table dir='<?php echo _DIR; ?>' align="center" id="list" width="400px" class="list" border="0" cellpadding="0" cellspacing="0" style='float:<?php echo _SALI; ?>'>
								<thead>
									<tr>
										<td >&nbsp;</td>
										<td>&nbsp;</td>
										<td align="<?php echo _SALI; ?>"> <?php echo allowed_files; ?> (<?php echo $com_files_type; ?>) <br/> <?php echo Maximum_allowed_size_for_each_file; ?> (<?php echo $max_com_size; ?>)<?php echo KB; ?> <?php echo Maximum_allowed_size_for_each_file2; ?></td>
									</tr>
								</thead>
								<tr>
									<td>&nbsp;</td>
									<td><input type="checkbox" name="chk"/></td>
									<td><input type="file" name="attached_files[]" class='file'/></td>
								</tr>
							</table>
							
							<h6 style="float: <?php echo _ALI?>; color:black;">&nbsp; &nbsp;<img style="cursor:pointer; " src="<?php echo _PREF; ?>wedgits/forum/plus.png" title="Add Row" onClick="addRow('list',<?php echo $max_com_files; ?>)"/> &nbsp; <?php echo Add_new_file; ?> &nbsp;</h6>				
							<h6 style="float: <?php echo _ALI?>; color:black;">&nbsp; &nbsp;<img style="cursor:pointer" src="<?php echo _PREF; ?>wedgits/forum/x.png" title="Delete Selected Row(s)" onClick="deleteRow('list')" /> &nbsp;<?php echo DELETE_SELECTED; ?> &nbsp;</h6>				
					 </td>
				 </tr>
				 
				 <tr><td>&nbsp;</td><td><input  type="button" name="save" value="<?php echo Post; ?>" class="save_com" onclick='validate_form1(<?php echo $max_com_size; ?>,"<?php echo $com_files_type; ?>");' /></td></tr>
			  
			  
			</table>
		</div>
	</div>
	 
	 
	 </form>
	</div>	   


</div>

<!--div class='result'><?php echo $results; ?></div--> 


<script>	
	$('document').ready(function(){
		$('.view_terms').click(function(){
			mask_width = $(window).width();
			mask_height = $(window).height();
			$('.popup_result').fadeIn('fast');
			$('.site_mask').css('width',mask_width+'px');
			$('.site_mask').css('height',mask_height+'px');
			//setTimeout(" $('.popup_result').fadeOut('fast'); $('.site_mask').css('width','0'); $('.site_mask').css('height','0');",3000);
		});
		$('.close_popup').click(function(){
			$('.popup_result').fadeOut('fast'); 
			$('.popup_result1').fadeOut('fast'); 
			$('.site_mask').css('width','0'); 
			$('.site_mask').css('height','0');
		});
		
	});
	
</script>    
<div class='popup_result' style='text-align:<?php echo _SALI; ?>'>
	<span class='close_popup'><?php echo Close; ?></span>
	<?php echo allowed_files; ?> (<?php echo $com_files_type; ?>) <?php echo allowed_files2; ?>
	<br/> <?php echo Maximum_allowed_size_for_each_file; ?> (<?php echo $max_com_size; ?>)<?php echo KB; ?> 
	<br/> <?php echo max_files_num; ?> (<?php echo $max_com_files; ?>) <?php echo max_files_num2; ?>
	<br/> <?php echo max_files_num3; ?>
	
</div>     



<div class='popup_result1' >
	<span class='close_popup'><?php echo Close; ?></span>
	<?php echo $alert_results; ?>
</div> 

<?php
if($alert_results){?>

	<script>
		$('document').ready(function(){
			mask_width = $(window).width();
			mask_height = $(window).height();
			
			$('.popup_result1').fadeIn('fast');
			$('.site_mask').css('width',mask_width+'px');
			$('.site_mask').css('height',mask_height+'px');
		}); 
	</script>
<?$alert_results = 0;}?>

<input type='button' value='<?php echo Back; ?>' class='back' onClick='document.location="viewAllArticles.php?cat_id=<?php echo $cat_id; ?>"'/>
</div>


