<?php include_once("headerpopup.php"); ?>
<style>
.input1{
	border:1px #CCC solid;
	width:350px;
}.input2{
	border:1px #CCC solid;
	width:350px;
	height:80px;
}
</style>
<?
$lang = addslashes($_REQUEST['lang']);
if($lang=='en'){$hide_arabic=true;}elseif($lang=='ar'){$hide_english=true;}

$filename = addslashes($_REQUEST['filename']);
$sub = $_REQUEST['sub'];
if($sub){
	$id = addslashes($_REQUEST['id']);
	$title_en = addslashes($_REQUEST['title_en']);
	$keywords_en = addslashes($_REQUEST['keywords_en']);
	$description_en = addslashes($_REQUEST['description_en']);
	$title_ar = addslashes($_REQUEST['title_ar']);
	$keywords_ar = addslashes($_REQUEST['keywords_ar']);
	$description_ar = addslashes($_REQUEST['description_ar']);

	$SQL = "INSERT INTO seo (filename , title_en , keywords_en , description_en, title_ar , keywords_ar , description_ar ) VALUES ('$filename' , '$title_en' , '$keywords_en' , '$description_en', '$title_ar' , '$keywords_ar' , '$description_ar' )";
	$result = mysql_query($SQL);
	if($result)
 		echo Record_Enter;
	else{
		$SQL = "UPDATE seo SET title_en = '$title_en' , keywords_en = '$keywords_en' , description_en = '$description_en', title_ar = '$title_ar' , keywords_ar = '$keywords_ar' , description_ar = '$description_ar' WHERE filename = '$filename' ";
		$result = mysql_query($SQL);
		echo Record_Update;
	}
}//Sub
if((!$sub) || (!$result)){
	$sql ="SELECT * FROM seo WHERE filename = '$filename' ";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);
	if ($numberOfRows>0) {
		$i=0;
		$id= MYSQL_RESULT($result,$i,"id");
		$filename= MYSQL_RESULT($result,$i,"filename");
		$title_en= MYSQL_RESULT($result,$i,"title_en");
		$keywords_en= MYSQL_RESULT($result,$i,"keywords_en");
		$description_en= MYSQL_RESULT($result,$i,"description_en");
		$title_ar= MYSQL_RESULT($result,$i,"title_ar");
		$keywords_ar= MYSQL_RESULT($result,$i,"keywords_ar");
		$description_ar= MYSQL_RESULT($result,$i,"description_ar");
	}?>
    <div id="output">
    <form name="seoForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <input type="Hidden" name="sub" size="20" value="save" />
    <input type="Hidden" name="id" size="20" value="<?php echo $id?>" class=""/>
    <input type="Hidden" name="filename" size="20" value="<?php echo stripslashes($filename)?>" />
   <table align="center">
		<tr>
			<?if(!$hide_english){?>
			<td>
				<table align="center">
					<tr><td align="<?php echo _ALI?>"><b>Title (EN):</b></td><td width="5"></td>
					<td><input type="Text" name="title_en" style='width:270px;' value="<?php echo stripslashes($title_en)?>" class=""/></td></tr>
					
					<tr><td align="<?php echo _ALI?>"><b>Keywords (EN):</b></td><td width="5"></td>
					<td><textarea name="keywords_en" cols="46" rows="4" class="" ><?php echo stripslashes($keywords_en)?></textarea></td></tr>
					
					<tr><td align="<?php echo _ALI?>"><b>Description (EN):</b></td><td width="5"></td>
					<td><textarea name="description_en" cols="46" rows="4"  class=""><?php echo stripslashes($description_en)?></textarea></td></tr>
				</table>
			</td>
			<?}if(!$hide_arabic){?>
			<td>
				<table align="center">
					<tr><td align="<?php echo _ALI?>"><b>Title (AR):</b></td><td width="5"></td>
					<td><input type="Text" name="title_ar" style='width:270px;' value="<?php echo stripslashes($title_ar)?>" class=""/></td></tr>
					
					<tr><td align="<?php echo _ALI?>"><b>Keywords (AR):</b></td><td width="5"></td>
					<td><textarea name="keywords_ar" cols="46" rows="4" class="" ><?php echo stripslashes($keywords_ar)?></textarea></td></tr>
					
					<tr><td align="<?php echo _ALI?>"><b>Description (AR):</b></td><td width="5"></td>
					<td><textarea name="description_ar" cols="46" rows="4"  class=""><?php echo stripslashes($description_ar)?></textarea></td></tr>
				</table>
			</td>
			<?}?>
		</tr>
		
	</table>
    </form>
    </div>
<?php 
} ?>
<?php include_once("footerpopup.php"); ?>