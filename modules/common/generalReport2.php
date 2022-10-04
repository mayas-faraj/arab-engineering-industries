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
$res = mysqli_query($GLOBALS["db_link_conn"], $sql);
$pie = array();
$numberOfRows = mysqli_num_rows($res);
if ($numberOfRows>0) {
$i=0;
	while ($i<$numberOfRows){
		$co= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"co");
		$country= mysqli_result($GLOBALS["db_link_conn"], $res,$i,"title");
		$pie[$i]="['$country',$co]";
		$i++;
	}
	
	$pie_data = '['.implode(',',$pie).']';
}
$wid = 30;
for($i=0; $i<=$wid; $i++){
	$r = rand(1, 100)/10.0;
	$pie_data .="[$i, ".($r%10.0)."],";
}
$pie_data = trim($pie_data,",");
?>
<br/>
<div class="filtering">
<form method='get' action=''>
Show Report From:
	Year:<select name="years">
    <option value="2011">2011</option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    </select>
    &nbsp;&nbsp;
    Month:<select name="months">
    <option value="January">January</option>
    <option value="February">February</option>
    <option value="March">March</option>
    <option value="April">April</option>
    <option value="May">May</option>
    <option value="June">June</option>
    <option value="July">July</option>
    <option value="August">August</option>
    <option value="September">September</option>
    <option value="October">October</option>
    <option value="November">November</option>
    <option value="December">December</option>
    </select>
	&nbsp;<input style='width:35px' type="submit" name="sub" value="Go">
</form></div>
<br/><br/><br/><br/>
<div id="graph" >Loading...</div>


<script type="text/javascript">
	var myData = new Array(<?php echo $pie_data; ?>);
	var myChart = new JSChart('graph', 'line');
	myChart.setDataArray(myData);
	myChart.setTitle('<?php echo $_REQUEST['filename']; ?>');
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
	<?php
	
	for($i=0; $i<=$wid; $i++)
		echo "myChart.setTooltip([$i, '$i']);";
	?>
	myChart.setSize(<?php echo max($wid*30,600); ?>, 321);
	myChart.draw();
</script>
<?php include_once("../common/footer-admin.php"); ?>