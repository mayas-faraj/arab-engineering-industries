<?
include_once("../common/header-admin.php");

echo print_GridAdminHead("Update User info", "Update User info", 0, 0, 0, 0);

echo '<div class="controls">';

echo '</div>';

/* * *********Default Sorting Option************ */
if (!isset($sb))
    $sb = "user_id";
$sort = "ORDER BY $sb $so";
//****************************************************

$user_id = $_REQUEST['user_id'];
$username = addslashes($_REQUEST['username']);
$password = addslashes($_REQUEST['password']);
$full_name = addslashes($_REQUEST['full_name']);
$email = addslashes($_REQUEST['email']);
$grp_id = addslashes($_REQUEST['grp_id']);
$action = $_REQUEST['action'];
//-------------------------------------------------
if ($action == "Update") {

    $values .= " full_name = '$full_name'";
    $values .= ", email = '$email'";
    if ($password != "XXXXXXXX") {
        $values .= ", password='" . md5($password) . "'";
    }
    $SQL = "UPDATE users SET $values WHERE user_id = '$user_id' ";
    $result = mysql_query($SQL);
    if ($result)
        echo '<script>correctMessageWithoutBack("' . Record_Update . '")</script>';
}
/* * delete_grp_functions(part 1 of 2)******************************************* */
if ($action == "Delete") {
    $array = $_POST['rid'];
    if ($array) {
        $ids = implode(",", $array);
        deleteRecord("users", "user_id in ($ids)", true);
    }
}
//-------------------------------------------------
$sql = "SELECT * FROM users WHERE user_id='" . $_SESSION['USER'] . "'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i = 0;
?>
<div class="data">
    <form method='post' name='main' action='<?php echo  $_SERVER['PHP_SELF'] ; ?>' enctype='multipart/form-data'>
        <input type='hidden' name='action' value=''>
        <script>
            function actionf(act) {
                main.action.value = act;
                main.submit();
            }
        </script>
        <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%" ID="list">
            <thead>
                <TR>
                    <th width="150px;"><?php echo  print_AdminRecordHead("username", "Username", $sb, $so) ; ?></th>
                    <th width="150px;"><?php echo  print_AdminRecordHead("password", "Password", $sb, $so, 1) ; ?></th>
                    <th width="150px;"><?php echo  print_AdminRecordHead("full_name", "Full Name", $sb, $so, 1) ; ?></th>
                    <th width="150px;"><?php echo  print_AdminRecordHead("email", "E-mail", $sb, $so, 1) ; ?></th>
                    <th colspan="2">&nbsp;</th>
                </TR>
            </thead>
            <tbody>
                <?
                while ($i < $numberOfRows) {
                    $user_id = MYSQL_RESULT($result, $i, "user_id");
                    $username = MYSQL_RESULT($result, $i, "username");
                    $password = MYSQL_RESULT($result, $i, "password");
                    $full_name = MYSQL_RESULT($result, $i, "full_name");
                    $email = MYSQL_RESULT($result, $i, "email");
                    $grp_id = MYSQL_RESULT($result, $i, "grp_id");
                    ?>
                    <TR>
                        <TD><?php echo  stripslashes($username) ; ?>
                            <input type="Hidden" name="user_id" size="20" value="<?php echo  $user_id ; ?>" />
                        </TD>
                        <TD><input type="password" name="password" size="20" value="XXXXXXXX" /></TD>
                        <TD><input type="Text" name="full_name" size="20" value="<?php echo  stripslashes($full_name) ; ?>" /></TD>
                        <TD><input type="Text" name="email" size="20" value="<?php echo  stripslashes($email) ; ?>" /></TD>
                        <TD><?php echo  print_save_icon("Update") ; ?></TD>
                        <TD colspan="1">&nbsp;</TD>
                    </TR>
                    <?
                    $i++;
                }
                ?>
            </tbody>
        </TABLE>
        <br><br>
    </form>
</div>
<? include_once("../common/footer-admin.php"); ?>