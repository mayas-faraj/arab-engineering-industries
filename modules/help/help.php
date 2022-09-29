<?php include_once("header-help.php");
$tip_id=$_REQUEST['tip_id'];
if($tip_id){
	$sql="SELECT * FROM help_tips WHERE id='$tip_id'";
	$result=mysql_query($sql);
	$numRows=mysql_num_rows($result);
	if($numRows>0){
		$title=mysql_result($result, 0,"title");
		$brief=mysql_result($result, 0,"brief");
		$details=mysql_result($result, 0,"details");
		$grp_id=mysql_result($result, 0,"group_id");
	}
	?>
	<script type="text/javascript">
	/* 

	Sitemap Styler v0.1
	written by Alen Grakalic, provided by Css Globe (cssglobe.com)
	visit http://cssglobe.com/lab/sitemap_styler/
	
*/
	function openCurrent(){
		$('#span_grp_<?php echo $grp_id; ?>').click();
	}
this.sitemapstyler = function(){
	var sitemap = document.getElementById("sitemap")
	if(sitemap){
		
		this.listItem = function(li){
			if(li.getElementsByTagName("ul").length > 0){
				var ul = li.getElementsByTagName("ul")[0];
				ul.style.display = "none";
				var span = document.createElement("span");
				
				span.id="span_"+li.id;
				
				span.className = "collapsed";
				span.onclick = function(){
					ul.style.display = (ul.style.display == "none") ? "block" : "none";
					this.className = (ul.style.display == "none") ? "collapsed" : "expanded";
				};
				li.appendChild(span);
			};
		};
		
		var items = sitemap.getElementsByTagName("li");
		for(var i=0;i<items.length;i++){
			listItem(items[i]);
		};
		openCurrent();
	};	
};
window.onload = sitemapstyler;
	</script>
	<div class="head"><h1 class="title"><?php echo $title; ?></h1></div>
	<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
		<tbody>
			<tr>
				<TD width="100%"><?php echo stripslashes($brief); ?></TD>
			</tr>
			<tr>
				<TD>&nbsp;</TD>
			</tr>
			<tr>
				<TD width="100%"><?php echo stripslashes($details); ?></TD>
			</tr>
	    </tbody>
	</TABLE>
<?php 
}
else
{
	$grp_id=$_REQUEST['grp_id'];
	$group_title=lookupField("help_tips_groups", "id", "group_title", $grp_id);
	$tips_sql="SELECT * FROM `help_tips` WHERE group_id='$grp_id'";
	$tips_result=mysql_query($tips_sql);
	$tips_numRows=mysql_num_rows($tips_result);
	if($tips_numRows>0){
		$j=0;
		?>
		<div class="head"><h1 class="title"><?php echo $group_title; ?></h1></div>
		<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
		<tbody>
		<?
		while ($j<$tips_numRows){
			$tip_id=mysql_result($tips_result, $j,"id");
			$title =mysql_result($tips_result, $j,"title");
			?>
			<tr><TD width="100%">* &nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?tip_id=<?php echo $tip_id; ?>"><?php echo $title; ?></a></TD></tr>
			<?
			$j++;
		}
		?>
		</tbody>
		</TABLE>
		<?
	}
}
?>
<?php include_once("footer-help.php"); ?>