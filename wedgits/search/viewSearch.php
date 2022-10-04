<link rel="stylesheet" type="text/css" href="<?php echo  _PREF ; ?>wedgits/search/search_<?php echo  $pageLang ; ?>.css" />
<div class="page_content" dir='<?php echo  _DIR ; ?>'>
    <div class="title2"><?php echo  search_result ; ?></div>
    <div class="search_result">
        <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" >
            <?php
            if (cleanString($_REQUEST['word']) != "") {
                $s = (cleanString($_REQUEST['word']));
                //-----------Pages--------------------------------------------------------------------
                $sql_pages = "select * from pages where (title LIKE ('%$s%') or details  LIKE ('%$s%')) and lang='$pageLang'";
                $res_pages = mysqli_query($GLOBALS["db_link_conn"], $sql_pages);
                $rows_pages = mysqli_num_rows($res_pages);

                $color = 0;
                if ($rows_pages > 0) {
                    ?>
                    <TR  height="40"><td colspan="2" class="subtitle"><?php echo  Pages . " (" . ($rows_pages) . ")" ; ?></td></TR><?php
                    if ($rows_pages > 0) {
                        $i = 0;
                        while ($i < $rows_pages) {
                            if ($color) {
                                $color = 0;
                            } else {
                                $color = 1;
                            }
                            $id = mysqli_result($GLOBALS["db_link_conn"], $res_pages, $i, 'id');
                            $title1 = mysqli_result($GLOBALS["db_link_conn"], $res_pages, $i, 'title');
                            ?>
                            <TR>
                                <TD >
                                    <a  href='<?php echo  _PREF ; ?>view/page/page.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title1) ; ?></a>
                                </TD>
                                <TD width="10" >
                                        <!--a href='<?php echo  _PREF ; ?>view/page/page.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                                </TD>
                            </TR>

                            <?php
                            $i++;
                        }
                    }
                }
                //-----------------------------------------------
                //-----------Announcements--------------------------------------------------------------------
                 if ($pageLang == "ar") {
                    $sql_news = "select *from news_news  where  subject_ar LIKE ('%$s%') or details_ar  LIKE ('%$s%')";
                } else {
                    $sql_news = "select *from news_news  where  subject LIKE ('%$s%') or details  LIKE ('%$s%')";
                }
                
                //$sql_news = "select *from news_news where ( subject LIKE ('%$s%') or details  LIKE ('%$s%') ) AND (lang='$pageLang')";
                $res_news = mysqli_query($GLOBALS["db_link_conn"], $sql_news);
                $rows_news = mysqli_num_rows($res_news);
                if ($rows_news > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?php echo  Announcements ; ?> (<?php echo  $rows_news ; ?>)</td></TR><?php
                    $i = 0;
                    while ($i < $rows_news) {
                        if ($color) {
                            $color = 0;
                        } else {
                            $color = 1;
                        }
                        $id = mysqli_result($GLOBALS["db_link_conn"], $res_news, $i, 'id');
                        $publish_date = mysqli_result($GLOBALS["db_link_conn"], $res_news, $i, 'publish_date');
                        if ($pageLang == "ar") {
                            $title = mysqli_result($GLOBALS["db_link_conn"], $res_news, $i, "subject_ar");
                        } else {
                            $title = mysqli_result($GLOBALS["db_link_conn"], $res_news, $i, "subject");
                        }
                        //$title = mysqli_result($GLOBALS["db_link_conn"], $res_news, $i, 'subject');
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?php echo  _PREF ; ?>view/Anouncements/viewAnnounceDetails.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title . '  (' . $publish_date . ')') ; ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?php echo  _PREF ; ?>view/Anouncements/viewAnnounceDetails.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                            </TD>
                        </TR>
                        <?php
                        $i++;
                    }
                }

                //-----------Activities--------------------------------------------------------------------
                if ($pageLang == "ar") {
                    $sql_activities = "select *from mem_activities  where  subject_ar LIKE ('%$s%') or details_ar  LIKE ('%$s%')";
                } else {
                    $sql_activities = "select *from mem_activities  where  subject LIKE ('%$s%') or details  LIKE ('%$s%')";
                }
                
                $res_activities = mysqli_query($GLOBALS["db_link_conn"], $sql_activities);
                $rows_activities = mysqli_num_rows($res_activities);
                if ($rows_activities > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?php echo  Activities ; ?> (<?php echo  $rows_activities ; ?>)</td></TR><?php
                    $i = 0;
                    while ($i < $rows_activities) {
                        if ($color) {
                            $color = 0;
                        } else {
                            $color = 1;
                        }
                        $id = mysqli_result($GLOBALS["db_link_conn"], $res_activities, $i, 'id');
                        if ($pageLang == "ar") {
                            $title = mysqli_result($GLOBALS["db_link_conn"], $res_activities, $i, "subject_ar");
                        } else {
                            $title = mysqli_result($GLOBALS["db_link_conn"], $res_activities, $i, "subject");
                        }
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?php echo  _PREF ; ?>view/activities/viewActivities.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title) ; ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?php echo  _PREF ; ?>view/activities/viewActivities.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                            </TD>
                        </TR>
                        <?php
                        $i++;
                    }
                }

                //-----------Committees--------------------------------------------------------------------
                $sql_committees = "select *from mem_committees  where name_$pageLang LIKE ('%$s%') or description_$pageLang  LIKE ('%$s%')";
                $res_committees = mysqli_query($GLOBALS["db_link_conn"], $sql_committees);
                $rows_committees = mysqli_num_rows($res_committees);
                if ($rows_committees > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?php echo  Committees ; ?> (<?php echo  $rows_committees ; ?>)</td></TR><?php
            $i = 0;
            while ($i < $rows_committees) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysqli_result($GLOBALS["db_link_conn"], $res_committees, $i, 'id');
                $title = mysqli_result($GLOBALS["db_link_conn"], $res_committees, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?php echo  _PREF ; ?>view/committees/viewCommittees.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title) ; ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?php echo  _PREF ; ?>view/committees/viewCommittees.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                            </TD>
                        </TR>
                        <?php
                        $i++;
                    }
                }


                //-----------------------------------------------
                //-----------Members--------------------------------------------------------------------
                $sql_members = "select *from mem_members  where name_$pageLang LIKE ('%$s%') or products_$pageLang  LIKE ('%$s%')  or brief_$pageLang  LIKE ('%$s%')";
                $res_members = mysqli_query($GLOBALS["db_link_conn"], $sql_members);
                $rows_members = mysqli_num_rows($res_members);
                if ($rows_members > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?php echo  MEMBERS ; ?> (<?php echo  $rows_members ; ?>)</td></TR><?php
            $i = 0;
            while ($i < $rows_members) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysqli_result($GLOBALS["db_link_conn"], $res_members, $i, 'id');
                $title = mysqli_result($GLOBALS["db_link_conn"], $res_members, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?php echo  _PREF ; ?>view/members/viewMember.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title) ; ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?php echo  _PREF ; ?>view/members/viewMember.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                            </TD>
                        </TR>
                        <?php
                        $i++;
                    }
                }


                //-----------------------------------------------
                //-----------BOD--------------------------------------------------------------------
                $sql_bod = "select *from mem_council  where active='1' AND name_$pageLang LIKE ('%$s%') or position_$pageLang  LIKE ('%$s%')  or biography_$pageLang  LIKE ('%$s%')";
                $res_bod = mysqli_query($GLOBALS["db_link_conn"], $sql_bod);
                $rows_bod = mysqli_num_rows($res_bod);
                if ($rows_bod > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?php echo  bod ; ?> (<?php echo  $rows_bod ; ?>)</td></TR><?php
            $i = 0;
            while ($i < $rows_bod) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysqli_result($GLOBALS["db_link_conn"], $res_bod, $i, 'id');

                $title = mysqli_result($GLOBALS["db_link_conn"], $res_bod, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?php echo  _PREF ; ?>view/bod/viewBod.php?id=<?php echo  $id ; ?>'><?php echo  stripslashes($title) ; ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?php echo  _PREF ; ?>view/bod/viewBod.php?id=<?php echo  $id ; ?>' class='more'><?php echo  _View ; ?></a-->
                            </TD>
                        </TR>
                        <?php
                        $i++;
                    }
                }


                //-----------------------------------------------


                $all_res = $rows_pages + $rows_news + $rows_members + $rows_activities + $rows_committees + $rows_bod;
                if ($all_res > 0) {
                    echo "<div class='subTitle'>" . all_result . " (" . $all_res . ")</div>";
                } else {
                    echo "<p>" . no_result . "</p>";
                }
            } else {
                echo "<p>" . no_search_word . "</p>";
            }
            ?></TABLE>

    </div>
</div>

