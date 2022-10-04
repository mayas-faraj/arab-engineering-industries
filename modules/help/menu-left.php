<?php 
$currentTip=$_REQUEST['tip_id'];
if($currentTip){
	$currentGroup=lookupField("help_tips", "id", "group_id", $currentTip);
}

?>
<table width="300px" border="0" align="center" cellpadding="0" cellspacing="10" id="menu">
	<tr>
		<td>
			<ul id="sitemap">
				<?php 
					$sql="SELECT * FROM help_tips_groups";
					$result=mysqli_query($GLOBALS["db_link_conn"], $sql);
					$numRows=mysqli_num_rows($result);
					if($numRows>0){
						$i=0;
						while ($i<$numRows){
							$id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"id");
							$group_title=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"group_title");
							$tip_id=mysqli_result($GLOBALS["db_link_conn"], $result, $i,"tip_id");
							$groupStyle=($id==$currentGroup)?"style='font-weight:bold'":"";
							?>
							<li id="<?php echo "grp_$id"; ?>" >
								<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?if (!$tip_id){echo "grp_id=$id";}else{echo "tip_id=$tip_id";}?>">
									<?php echo $group_title; ?>
								</a>
							<?php 
							$tips_sql="SELECT * FROM `help_tips` WHERE group_id='$id'";
							$tips_result=mysqli_query($GLOBALS["db_link_conn"], $tips_sql);
							$tips_numRows=mysqli_num_rows($tips_result);
							if($tips_numRows>0){
								$j=0;
								?>
								<ul>
								<?php
								while ($j<$tips_numRows){
									$tip_id=mysqli_result($GLOBALS["db_link_conn"], $tips_result, $j,"id");
									$title =mysqli_result($GLOBALS["db_link_conn"], $tips_result, $j,"title");
									$tipStyle=($tip_id==$currentTip)?"style='font-weight:bold'":"";
									?>
									<li id="<?php echo "tip_$tip_id"; ?>" <?php echo $tipStyle; ?> ><a href="<?php echo $_SERVER['PHP_SELF']; ?>?tip_id=<?php echo $tip_id; ?>"><?php echo $title; ?></a></li>
									<?php
									$j++;
								}
								?>
								</ul>
								<?php
							}
							?>
							</li>
							<?php
							$i++;
						}
					}				
				?>
			</ul>
		</td>
	</tr>
</table>