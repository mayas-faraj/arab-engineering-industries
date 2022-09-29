<?session_start();
$gal = $_SESSION['gal'];
$m_id = $_SESSION['m_id'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uploadify Example Script</title>
<link href="../includes/gallery/css/default.css" rel="stylesheet" type="text/css" />
<link href="../includes/gallery/css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/gallery/scripts/swfobject.js"></script>
<script type="text/javascript" src="../includes/gallery/scripts/jquery.uploadify.v2.1.0.min.js"></script>
<?//$_REQUEST['gal'] = 1;?>
<script type="text/javascript">

$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : '../includes/gallery/scripts/uploadify.swf',
		'script'         : '../includes/gallery/scripts/upload_magazin.php?m_id=<?php echo $m_id; ?>',
		'cancelImg'      : '../includes/gallery/cancel.png',
		'folder'         : '../../forms/Magazin/uploads',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'onAllComplete'	 : function(){
			
			location.reload();
		}
	});
});
</script>
</head>
<body>
<div style="float:left">Select multiple file to upload by clicking on the Browse button</div>
<input type="file" name="uploadify" id="uploadify" />
<div id="fileQueue"></div>
<p><a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Cancel All Uploads</a></p>
</body>
</html>
