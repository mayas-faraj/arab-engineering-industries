<?php 
header("cache-control: no-cache"); 
require_once("../../../config.php");
require_once("../../common/dbConnection.php"); 
require_once("../dbUtils.php"); 
?>
<html>
	<head>
		<script type="text/javascript" src="../jquery/jquery.min.js"></script>
		<script src="scripts/jquery.Jcrop.min.js"></script>
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					setSelect: [ 0, 0, 90, 90],
					onChange: showPreview,
					onSelect: updateCoords,
					aspectRatio: 1
				});

			});
			function showPreview(coords)
			{
				if (parseInt(coords.w) > 0)
				{
					var rx = 90 / coords.w;
					var ry = 90 / coords.h;

					jQuery('#preview').css({
//						width: Math.round(rx * 250) + 'px',
//						height: Math.round(ry * 250) + 'px',
						marginLeft: '-' + Math.round(rx * coords.x) + 'px',
						marginTop: '-' + Math.round(ry * coords.y) + 'px'
					});					
				}
			}
			
			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
				showPreview(c);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

<body>
<?
$id = $_GET['id'];
$sql = "SELECT * FROM galleries_photos WHERE (id = '$id')";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if($numberOfRows > 0){
	$i=0;
	$id= MYSQL_RESULT($result,$i,"id");
	$photo= MYSQL_RESULT($result,$i,"photo");
	$thumb= MYSQL_RESULT($result,$i,"thumb");
	$description= MYSQL_RESULT($result,$i,"description");
	$photo = resizeToFile("../../../uploads/".$photo, 250, 250, "../../../uploads/cash/250_".$photo);
}
?>
<form name="subForm" action="scripts/crop.php" method="post" onSubmit="return checkCoords();">    
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>Create Thumb&nbsp;</td>
  </tr>
  <tr>
    <td><img src="<?php echo $photo; ?>" id="cropbox" align="left" style="float:left" /></td>
    <td><div style="width:90px;height:90px;overflow:hidden; float:right">
			<img src="<?php echo $photo; ?>" id="preview"  align="right" />
		</div></td>
  </tr>
  <tr>
    <td colspan="2">Edit desription: <input type="text" name="desc" width="50" /></td>
  </tr>
</table>
<input type="hidden" name="photo" value="<?php echo $photo; ?>" />
<input type="hidden" name="thumb" value="<?php echo $thumb; ?>" />
<input type="text" id="x" name="x" />
<input type="text" id="y" name="y" />
<input type="text" id="w" name="w" />
<input type="text" id="h" name="h" />
<input type="submit" value="Crop Image" />
</form>
</body>

</html>
