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
Show Report From:<input type="text" name="from" size="20" value="<?php echo $_REQUEST['from']; ?>" class="dateF" >&nbsp;&nbsp;To:<input type="text" name="to" size="20" value="<?php echo $_REQUEST['to']; ?>" class="dateF" >&nbsp;<input style='width:35px' type="submit" name="sub" value="Go">
</form></div>
<br/><br/><br/><br/>
<div id="graph" >Loading...</div>


<script type="text/javascript">
	var myData = new Array(['Syria', 437], ['Lebanon', 322], ['UAE', 233], ['Egypt', 110], ['KSA', 34], ['France', 20], ['Others', 19]);
	var colors = ['#2D6B96', '#327AAD', '#3E90C9', '#55A7E3', '#60B6F0', '#81C4F0', '#9CCEF0'];
	var myChart = new JSChart('graph', 'bar');
	myChart.setDataArray(myData);
	myChart.colorizeBars(colors);
	myChart.setTitle('Statistics By Country');
	myChart.setTitleColor('#8E8E8E');
	myChart.setAxisNameX('');
	myChart.setAxisNameY('');
	myChart.setAxisColor('#C4C4C4');
	myChart.setAxisNameFontSize(16);
	myChart.setAxisNameColor('#999');
	myChart.setAxisValuesColor('#777');
	myChart.setAxisColor('#B5B5B5');
	myChart.setAxisWidth(1);
	myChart.setBarValuesColor('#2F6D99');
	myChart.setBarOpacity(0.5);
	myChart.setAxisPaddingTop(60);
	myChart.setAxisPaddingBottom(40);
	myChart.setAxisPaddingLeft(45);
	myChart.setTitleFontSize(11);
	myChart.setBarBorderWidth(0);
	myChart.setBarSpacingRatio(50);
	myChart.setBarOpacity(0.9);
	myChart.setFlagRadius(6);
	myChart.setTooltipPosition('nw');
	myChart.setTooltipOffset(3);
	myChart.setSize(616, 321);
	myChart.setBackgroundImage('chart_bg.jpg');
	myChart.draw();
</script>
<?php include_once("../common/footer-admin.php"); ?>