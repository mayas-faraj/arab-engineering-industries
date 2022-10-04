<link rel="stylesheet" type="text/css" href='<?php echo  _PREF ; ?>wedgits/activities/activities_<?php echo  $pageLang ; ?>.css'/>	
<link rel="stylesheet" type="text/css" href='<?php echo  _PREF ; ?>wedgits/gallery/zoombox/zoombox.css'/>	
<script src="<?php echo  _PREF ; ?>wedgits/gallery/zoombox/zoombox.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo  _PREF ; ?>wedgits/gallery/gallery.js" language="javascript" type="text/javascript"></script>
<div class='page_content'>
    <?php
    $id = cleanString($_REQUEST['id']);
    $currentdate = date("Y-m-d");
    if ($_SESSION['pageLang'] == 'ar') {
        $lang_prex = '_ar';
    }
    $sql = "SELECT * FROM mem_activities WHERE  active='1' and id='$id'  ";
    $result = mysqli_query($GLOBALS["db_link_conn"], $sql);
    $numberOfRows = mysqli_num_rows($result);

    if ($numberOfRows > 0) {
        $i = 0;
        while ($i < $numberOfRows) {


            $id = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "id");
            $subject = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i, "subject" . $lang_prex));
            $start_date = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "activity_date");
            if ($start_date == '0000-00-00') {
                $start_date = '';
            } else {
                $start_date = date('d / m / Y', strtotime($start_date));
            }
            $end_date = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "end_date");
            if ($end_date == '0000-00-00') {
                $end_date = '';
            } else {
                $end_date = date('d / m / Y', strtotime($end_date));
            }
            $brief = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i, "brief" . $lang_prex));
            $brief = limit($brief, $brief_count);
            $details = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i, "details" . $lang_prex));
            $private = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i, "private" . $lang_prex));
            $place = stripslashes(mysqli_result($GLOBALS["db_link_conn"], $result, $i, "place" . $lang_prex));

            $atype = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "atype");
            $afield = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "afield");
            $alevel = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "alevel");

            $type = lookupField('types', 'id', "name_" . $pageLang, $atype);
            $field = lookupField('fields', 'id', "name_" . $pageLang, $afield);
            $level = lookupField('levels', 'id', "name_" . $pageLang, $alevel);

            $gallery = mysqli_result($GLOBALS["db_link_conn"], $result, $i, "gal_id");
            $src = '';

            if ($gallery) {
                $main_photo_id = lookupField('galleries_galleries', 'id', 'main_photo', $gallery);
                $main_photo = basename(lookupField('galleries_photos', 'id', 'photo', $main_photo_id));
                $main_photo_folder = lookupField('galleries_photos', 'id', 'folder', $main_photo_id);

                $photo_path = str_replace('//', '/', "../../uploads/$main_photo_folder");
                $upload_path = str_replace('//', '/', "../../uploads/");
                $thumb = basename(resizeToFile($photo_path . $main_photo, 400, 300, $upload_path . "cash/viewActivities_" . $main_photo));
            }

            if ($main_photo_id != 0) {
                if (file_exists("../../uploads/cash/$thumb")) {
                    $src = $upload_path . 'cash/' . $thumb;
                } else {
                    $src = $photo_path . $main_photo;
                }
            }
            if ($src) {
                $act_img = "<img src='$src'/>";
            } else {
                $act_img = "";
            }




            echo "<div class='title2'><span>$subject</span></div> <br/><div class='ln_date'>$start_date ";
            if ($end_date)
                echo " - " . $end_date;
            if ($place)
                echo " (" . $place . ")";
            echo "</div>";

            echo "	<div  class='activities_con' dir='" . _DIR . "'>
					$act_img ";

            /* echo "<table style='margin-top:10px;'><tr>";
              if($type){
              echo	"<td> $type </td>";
              }
              if($field){
              echo	"<td> - $field</td>";
              }
              if($level){
              echo	"<td> - $level</td>";
              }



              echo "</tr></table>"; */


            echo "		<div class='page_dt'>$details</div>";
            if ($_SESSION["us_id"]) {
                echo "<div class='page_dt'>$private</div>";
            }




            $alignGal = "left";
            if ($pageLang == "ar") {
                $alignGal = "right";
            }


            echo "<table width='100%'><tr><td align='$alignGal'><div class='gal_show'>" . showGallery3($gallery,1) . "</div></td></tr></table>
				</div>";


            $i++;
        }
    }
    ?>
    <a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=tarabichi"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;float:<?php echo  _SALI ; ?>;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=tarabichi"></script>  
    <input type='button' value='<?php echo  Back ; ?>' class='more_btn' onClick='history.back()'/>
</div>

