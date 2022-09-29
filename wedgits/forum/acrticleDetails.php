<? if(!cleanString($_SESSION["us_id"])){echo"<script>document.location='"._PREF."index.php'</script>";exit();} ?>	
<link rel="stylesheet" type="text/css" href='<?=_PREF?>wedgits/forum/articles_<?=$pageLang?>.css'/>

<script src="<?=_PREF?>wedgits/forum/articles.js" language="javascript" type="text/javascript"></script>	
<script src="<?=_PREF?>wedgits/forum/tableRowsMgmt.js" language="javascript" type="text/javascript"></script>	
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
		$result =  MYSQL_QUERY($sql);
		$com_art_id = mysql_insert_id();
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
						$attached_files_result = mysql_query($attached_files_sql);
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

<div class="page_content" dir='<?=_DIR?>'>

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

	<?$user_name = lookupField('users','user_id','full_name',cleanString($_SESSION["us_id"]));
	$publish = lookupField('art_categories','id','publish',cleanString($_REQUEST['cat_id']));?>
	<div class="title2"><?=forum?>: &nbsp; <?=$forum?> <span><?echo Welcome.' <font><a href="myPage.php?mem_id='.cleanString($_SESSION["us_id"]).'&cat_id='.cleanString($_REQUEST['cat_id']).'">'.$user_name.'</a></font>'?></span></div>
	<div class="title2" <?if($pageLang=='ar'){?>style='font-size:18px;'<?}else{?>style='font-size:15px;'<?}?> ><?=Subject?>: &nbsp; <?=$title?></div>
	
	<div class="annonce_details">
		<div class="annonce_details_body">
			<!--div class="annonce_details_txt"><?=$details?></div-->
			<div class="">
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
	
	$sql="select * from art_comments where art_id = $article_id  AND active=1 order by publish_date ASC";
	
	$result=mysql_query($sql);
	$rows=mysql_num_rows($result);
	?>
	<div class="progList_comments">
	<div class="progList_comments_title">
		<?=Comments?> :
		<?if($rows>3){echo "<div class='see_more_com'>".see_more_com." ($rows)</div>";}?>
		
	</div>
	<?
	if($rows){
		$i=0;
		if($rows>3){echo "<div class='hidden_comments'>";}
		while($i<$rows){
			$id =mysql_result($result, $i,"id");
			$comment_date =mysql_result($result, $i,"publish_date");
			
			$publish_date=date('Y-m-d',strtotime($comment_date));
			$publish_time=date('h:iA T ',strtotime($comment_date));
			
			
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
						<div class="publisher"><?=$publisher?></div>
						<div class="publisher"><?=$subject?></div>
						<?if($owner){?>
							<!--div class="nav">
								<a href="../../wedgits/forum/checkbox.php?t=art_comments&fn=active&idn=id&idv=<?=$id?>&fv=<?=!($active)?>" class="checkb" ><img src="<?=_PREF?>images/icons/_<?php echo $active?>_.png" border="0"  fv="<?=!($active)?>"/></a>
								<a href="viewArticles.php?id=<?=$article_id?>&op=del&com_id=<?=$id?>" class="delete"><img src="<?=_PREF?>images/icons/Delete.png"  border=0></a>
							</div-->
						<?}?>
						<div class="comment_date"><?=$publish_time.' '.$publish_date?></div>
					</div>
					<div class="comment_body">
						<?=$comment?>
						<?
							$attach_sql =  "SELECT * FROM art_comments_files WHERE (comment_id=$id) ";
							$attach_result = MYSQL_QUERY($attach_sql);
							$attach_numrows = MYSQL_NUMROWS($attach_result);
							if($attach_numrows>0){
								echo "<br/>".attached_files."<br/>";
								$si=0;
								while($si<$attach_numrows){
									$attached_file = basename(mysql_result($attach_result,$si,'file'));
									$file_name = basename(mysql_result($attach_result,$si,'file_name'));
									echo "<a target='_blank' href='../../wedgits/forum/downloadFile.php?file=$attached_file&org=$file_name'>$file_name</a><br/>";
									$si++;
								}
							}
						?>
					</div>
				</div>
			<?
			}
			if($i==($rows-4)){echo "</div>";}
			$i++;
		}
		if($i>3){echo "<div class='see_more_com'>".see_more_com." ($rows)</div>";}
		
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
				$('.see_more_com').hide();
				$('.hidden_comments').show();
			});
		});
	</script>                                                 
	
</div>













	<? /*************************Add Comments***********************/?>
	<div class="com_add">
		<?/*if($publish && $publish_comment){?><a href="#" onclick="$('.progList_Addcomment').show();return false;"><?=AddComment?></a><?}*/?>

	</div>
	 <div class="progList_Addcomment">
	<form  method="post" name="subForm" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
	 
	 
	<div class="comment_item">
		<div class="comment_header">
			<div class="publisher"><?=AddComment?></div>
			
		</div>
		<div class="comment_body">
			<input type="hidden" name="art" value="<?=$article_id ?>" />
			 <input type="hidden" name="art_u_id" value="<?=$art_u_id ?>" />
			 <input type="hidden" name="cat_id" value="<?=cleanString($_REQUEST['cat_id'])?>" />
			 <input type="hidden" name="id" value="<?=cleanString($_REQUEST['id'])?>" />
			 <input type="hidden" name="sub" value="1" />
			<table border="0" cellpadding="0" cellspacing="0">
	
	 
				 <tr><td valign='top'><?=Subject?>:</td><td><input type='text'  style='width:400px;' name='p_subject' class="required1"/></textarea></td></tr>
				 <tr><td valign='top'><?=Comment?>:</td><td><textarea rows="5" style='height:100px; width:400px;' name="p_comment" id="p_comment"  /></textarea></td></tr>
				 
				 <tr>
					 <td valign='top' width='150'><?=attached_files?><br/><div class=" view_terms" style='cursor:pointer;'><a><?=view_com_info?></a></div></td>
					 <td>
						
							<table dir='<?=_DIR?>' align="center" id="list" width="400px" class="list" border="0" cellpadding="0" cellspacing="0" style='float:<?=_SALI?>'>
								<thead>
									<tr>
										<td >&nbsp;</td>
										<td>&nbsp;</td>
										<td align="<?=_SALI?>"> <?=allowed_files?> (<?=$com_files_type?>) <br/> <?=Maximum_allowed_size_for_each_file?> (<?=$max_com_size?>)<?=KB?> <?=Maximum_allowed_size_for_each_file2?></td>
									</tr>
								</thead>
								<tr>
									<td>&nbsp;</td>
									<td><input type="checkbox" name="chk"/></td>
									<td><input type="file" name="attached_files[]" class='file'/></td>
								</tr>
							</table>
							
							<h6 style="float: <?php echo _ALI?>; color:black;">&nbsp; &nbsp;<img style="cursor:pointer; " src="<?=_PREF?>wedgits/forum/plus.png" title="Add Row" onClick="addRow('list',<?=$max_com_files?>)"/> &nbsp; <?=Add_new_file?> &nbsp;</h6>				
							<h6 style="float: <?php echo _ALI?>; color:black;">&nbsp; &nbsp;<img style="cursor:pointer" src="<?=_PREF?>wedgits/forum/x.png" title="Delete Selected Row(s)" onClick="deleteRow('list')" /> &nbsp;<?=DELETE_SELECTED?> &nbsp;</h6>				
					 </td>
				 </tr>
				 
				 <tr><td>&nbsp;</td><td><input  type="button" name="save" value="<?=Post?>" class="save_com" onclick='validate_form1(<?=$max_com_size?>,"<?=$com_files_type?>");' /></td></tr>
			  
			  
			</table>
		</div>
	</div>
	 
	 
	 </form>
	</div>	   


</div>

<!--div class='result'><?=$results?></div--> 


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
<div class='popup_result' style='text-align:<?=_SALI?>'>
	<span class='close_popup'><?=Close?></span>
	<?=allowed_files?> (<?=$com_files_type?>) <?=allowed_files2?>
	<br/> <?=Maximum_allowed_size_for_each_file?> (<?=$max_com_size?>)<?=KB?> 
	<br/> <?=max_files_num?> (<?=$max_com_files?>) <?=max_files_num2?>
	<br/> <?=max_files_num3?>
	
</div>     



<div class='popup_result1' >
	<span class='close_popup'><?=Close?></span>
	<?=$alert_results?>
</div> 

<?
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

<input type='button' value='<?=Back?>' class='back' onClick='document.location="viewAllArticles.php?cat_id=<?=$cat_id?>"'/>
</div>


