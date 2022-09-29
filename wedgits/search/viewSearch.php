<link rel="stylesheet" type="text/css" href="<?= _PREF ?>wedgits/search/search_<?= $pageLang ?>.css" />
<div class="page_content" dir='<?= _DIR ?>'>
    <div class="title2"><?= search_result ?></div>
    <div class="search_result">
        <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" >
            <?
            if (cleanString($_REQUEST['word']) != "") {
                $s = (cleanString($_REQUEST['word']));
                //-----------Pages--------------------------------------------------------------------
                $sql_pages = "select * from pages where (title LIKE ('%$s%') or details  LIKE ('%$s%')) and lang='$pageLang'";
                $res_pages = mysql_query($sql_pages);
                $rows_pages = mysql_num_rows($res_pages);

                $color = 0;
                if ($rows_pages > 0) {
                    ?>
                    <TR  height="40"><td colspan="2" class="subtitle"><?= Pages . " (" . ($rows_pages) . ")" ?></td></TR><?
                    if ($rows_pages > 0) {
                        $i = 0;
                        while ($i < $rows_pages) {
                            if ($color) {
                                $color = 0;
                            } else {
                                $color = 1;
                            }
                            $id = mysql_result($res_pages, $i, 'id');
                            $title1 = mysql_result($res_pages, $i, 'title');
                            ?>
                            <TR>
                                <TD >
                                    <a  href='<?= _PREF ?>view/page/page.php?id=<?= $id ?>'><?= stripslashes($title1) ?></a>
                                </TD>
                                <TD width="10" >
                                        <!--a href='<?= _PREF ?>view/page/page.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                                </TD>
                            </TR>

                            <?
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
                $res_news = mysql_query($sql_news);
                $rows_news = mysql_num_rows($res_news);
                if ($rows_news > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?= Announcements ?> (<?= $rows_news ?>)</td></TR><?
                    $i = 0;
                    while ($i < $rows_news) {
                        if ($color) {
                            $color = 0;
                        } else {
                            $color = 1;
                        }
                        $id = mysql_result($res_news, $i, 'id');
                        $publish_date = mysql_result($res_news, $i, 'publish_date');
                        if ($pageLang == "ar") {
                            $title = mysql_result($res_news, $i, "subject_ar");
                        } else {
                            $title = mysql_result($res_news, $i, "subject");
                        }
                        //$title = mysql_result($res_news, $i, 'subject');
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?= _PREF ?>view/Anouncements/viewAnnounceDetails.php?id=<?= $id ?>'><?= stripslashes($title . '  (' . $publish_date . ')') ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?= _PREF ?>view/Anouncements/viewAnnounceDetails.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                            </TD>
                        </TR>
                        <?
                        $i++;
                    }
                }

                //-----------Activities--------------------------------------------------------------------
                if ($pageLang == "ar") {
                    $sql_activities = "select *from mem_activities  where  subject_ar LIKE ('%$s%') or details_ar  LIKE ('%$s%')";
                } else {
                    $sql_activities = "select *from mem_activities  where  subject LIKE ('%$s%') or details  LIKE ('%$s%')";
                }
                
                $res_activities = mysql_query($sql_activities);
                $rows_activities = mysql_num_rows($res_activities);
                if ($rows_activities > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?= Activities ?> (<?= $rows_activities ?>)</td></TR><?
                    $i = 0;
                    while ($i < $rows_activities) {
                        if ($color) {
                            $color = 0;
                        } else {
                            $color = 1;
                        }
                        $id = mysql_result($res_activities, $i, 'id');
                        if ($pageLang == "ar") {
                            $title = mysql_result($res_activities, $i, "subject_ar");
                        } else {
                            $title = mysql_result($res_activities, $i, "subject");
                        }
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?= _PREF ?>view/activities/viewActivities.php?id=<?= $id ?>'><?= stripslashes($title) ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?= _PREF ?>view/activities/viewActivities.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                            </TD>
                        </TR>
                        <?
                        $i++;
                    }
                }

                //-----------Committees--------------------------------------------------------------------
                $sql_committees = "select *from mem_committees  where name_$pageLang LIKE ('%$s%') or description_$pageLang  LIKE ('%$s%')";
                $res_committees = mysql_query($sql_committees);
                $rows_committees = mysql_num_rows($res_committees);
                if ($rows_committees > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?= Committees ?> (<?= $rows_committees ?>)</td></TR><?
            $i = 0;
            while ($i < $rows_committees) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysql_result($res_committees, $i, 'id');
                $title = mysql_result($res_committees, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?= _PREF ?>view/committees/viewCommittees.php?id=<?= $id ?>'><?= stripslashes($title) ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?= _PREF ?>view/committees/viewCommittees.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                            </TD>
                        </TR>
                        <?
                        $i++;
                    }
                }


                //-----------------------------------------------
                //-----------Members--------------------------------------------------------------------
                $sql_members = "select *from mem_members  where name_$pageLang LIKE ('%$s%') or products_$pageLang  LIKE ('%$s%')  or brief_$pageLang  LIKE ('%$s%')";
                $res_members = mysql_query($sql_members);
                $rows_members = mysql_num_rows($res_members);
                if ($rows_members > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?= MEMBERS ?> (<?= $rows_members ?>)</td></TR><?
            $i = 0;
            while ($i < $rows_members) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysql_result($res_members, $i, 'id');
                $title = mysql_result($res_members, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?= _PREF ?>view/members/viewMember.php?id=<?= $id ?>'><?= stripslashes($title) ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?= _PREF ?>view/members/viewMember.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                            </TD>
                        </TR>
                        <?
                        $i++;
                    }
                }


                //-----------------------------------------------
                //-----------BOD--------------------------------------------------------------------
                $sql_bod = "select *from mem_council  where active='1' AND name_$pageLang LIKE ('%$s%') or position_$pageLang  LIKE ('%$s%')  or biography_$pageLang  LIKE ('%$s%')";
                $res_bod = mysql_query($sql_bod);
                $rows_bod = mysql_num_rows($res_bod);
                if ($rows_bod > 0) {
                    ?>
                    <TR height="40"><td colspan="2" class="subtitle"><?= bod ?> (<?= $rows_bod ?>)</td></TR><?
            $i = 0;
            while ($i < $rows_bod) {
                if ($color) {
                    $color = 0;
                } else {
                    $color = 1;
                }
                $id = mysql_result($res_bod, $i, 'id');

                $title = mysql_result($res_bod, $i, "name_$pageLang");
                        ?>


                        <TR >
                            <TD>
                                <a  href='<?= _PREF ?>view/bod/viewBod.php?id=<?= $id ?>'><?= stripslashes($title) ?></a>
                            </TD>
                            <TD width="10" >
                                    <!--a href='<?= _PREF ?>view/bod/viewBod.php?id=<?= $id ?>' class='more'><?= _View ?></a-->
                            </TD>
                        </TR>
                        <?
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

