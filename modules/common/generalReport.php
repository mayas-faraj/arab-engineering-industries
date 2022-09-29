<?php include_once("../common/header-admin.php"); ?>
<script language="javascript" src="../includes/charts/jscharts.js"></script>
<div class="head"><h1 class="title"><?php echo General_report?></h1></div>
<?php
$msg_id = $_REQUEST['msg_id'];
$pn =  $_GET['pn'];
$so =  $_GET['so'];
$sb =  $_GET['sb'];
$LPP = 100;
$st = $pn*$LPP ;
$limit = "LIMIT $st,$LPP " ;
if($so) $so    = ($so=="DESC")? "ASC" : "DESC" ; else $so="DESC";
if($sb) $sort  = "ORDER BY $sb $so" ;

$sql = "SELECT id AS co ,title FROM pages";
$res = mysql_query($sql);
$pie = array();
$numberOfRows = mysql_numrows($res);
if ($numberOfRows>0) {
$i=0;
	while ($i<$numberOfRows){
		$co= mysql_result($res,$i,"co");
		$country= mysql_result($res,$i,"title");
		$pie[$i]="['$country',$co]";
		$i++;
	}
	
	$pie_data = '['.implode(',',$pie).']';
}
for($i=0; $i<=12; $i++){
	$r = rand(1, 100)/10.0;
	$pie_data .="[$i, ".($r%10.0)."],";
}
$pie_data = trim($pie_data,",");
?>
<br/>
<div class="filtering">
<form method='get' action=''>
Show Report From:<input type="text" name="from" size="20" value="<?=$_REQUEST['from']?>" class="dateF" >&nbsp;&nbsp;To:<input type="text" name="to" size="20" value="<?=$_REQUEST['to']?>" class="dateF" >&nbsp;<input style='width:35px' type="submit" name="sub" value="Go">
</form></div>
<br/><br/><br/><br/>
<div id="graph" >Loading...</div>


<script type="text/javascript">
	var myData = new Array(<?=$pie_data?>);
	var myChart = new JSChart('graph', 'line');
	myChart.setDataArray(myData);
	myChart.setTitle('<?=$_REQUEST['filename']?>');
	myChart.setTitleColor('#8E8E8E');
	myChart.setTitleFontSize(11);
	myChart.setAxisNameX('');
	myChart.setAxisNameY('');
	myChart.setAxisColor('#8420CA');
	myChart.setAxisValuesColor('#949494');
	myChart.setAxisPaddingLeft(100);
	myChart.setAxisPaddingRight(120);
	myChart.setAxisPaddingTop(50);
	myChart.setAxisPaddingBottom(40);
	myChart.setAxisValuesDecimals(3);
	myChart.setAxisValuesNumberX(10);
	myChart.setShowXValues(false);
	myChart.setGridColor('#C5A2DE');
	myChart.setLineColor('#BBBBBB');
	myChart.setLineWidth(2);
	myChart.setFlagColor('#9D12FD');
	myChart.setFlagRadius(4);
	myChart.setTooltip([1, 'H 7.80']);
	myChart.setTooltip([2, 'H 4.80']);
	myChart.setTooltip([3, 'H 6.50']);
	myChart.setTooltip([4, 'H 7.80']);
	myChart.setTooltip([5, 'H 4.80']);
	myChart.setTooltip([6, 'H 6.50']);
	myChart.setTooltip([7, 'H 6.10']);
	myChart.setTooltip([8, 'H 4.40']);
	myChart.setTooltip([9, 'H 5.80']);
	myChart.setTooltip([10, 'H 4.00']);
	myChart.setTooltip([11, 'H 8.50']);
	myChart.setTooltip([12, 'H 8.90']);
	myChart.setLabelX([1, '1']);
	myChart.setLabelX([2, '2']);
	myChart.setLabelX([3, '3']);
	myChart.setLabelX([4, '4']);
	myChart.setLabelX([5, '5']);
	myChart.setLabelX([6, '6']);
	myChart.setLabelX([7, '7']);
	myChart.setLabelX([8, '8']);
	myChart.setLabelX([9, '9']);
	myChart.setLabelX([10, '10']);
	myChart.setLabelX([11, '11']);
	myChart.setLabelX([12, '12']);
	myChart.setSize(616, 321);
	myChart.draw();
</script>
<?php include_once("../common/footer-admin.php"); ?>