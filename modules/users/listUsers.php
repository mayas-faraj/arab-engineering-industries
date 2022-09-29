<?
include_once("../common/header-admin.php");

echo print_GridAdminHead("Users", "Users", 1, 1, 1, 1);

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
$user_desc = addslashes($_REQUEST['user_desc']);
$grp_id = addslashes($_REQUEST['grp_id']);
$action = $_REQUEST['action'];
$uploads_folder = $_REQUEST['uploads_folder'];
if ($action == "Insert") {

    $cols = "username, password, uploads_folder";
    $values = "'$username', '" . md5($password) . "', '$uploads_folder'";

    $cols .= ", full_name";
    $values .= ", '$full_name'";
    $cols .= ", email";
    $values .= ", '$email'";
    $cols .= ", grp_id";
    $values .= ", '$grp_id'";

    $SQL = "INSERT INTO users ( $cols ) VALUES ($values)";
    $result = mysql_query($SQL);
    if ($result)
        echo '<script>correctMessageWithoutBack("' . Record_Enter . '")</script>';
}
//-------------------------------------------------
if ($action == "Update") {
    $values = "username = '$username',uploads_folder='$uploads_folder' ";
    if ($password != "XXXXXXXX") {
        $values.= ", password='" . md5($password) . "'";
    }
    $values .= ", full_name = '$full_name'";
    $values .= ", email = '$email'";
    $values .= ", grp_id = '$grp_id'";

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
$sql = "SELECT * FROM users WHERE user_id>1 AND grp_id != 3 $sort ";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$i = 0;
?>
<div class="data">
    <form method='post' name='main' action='<?= $_SERVER['PHP_SELF'] ?>' enctype='multipart/form-data'>
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
                    <th width="150px;"><?= print_AdminRecordHead("username", "Username", $sb, $so) ?></th>
                    <th width="150px;"><?= print_AdminRecordHead("password", "Password", $sb, $so, 1) ?></th>
                    <th width="150px;"><?= print_AdminRecordHead("full_name", "Full Name", $sb, $so, 1) ?></th>
                    <th width="150px;"><?= print_AdminRecordHead("email", "E-mail", $sb, $so, 1) ?></th>
                    <th width="150px;"><?= print_AdminRecordHead("grp_id", "Group", $sb, $so, 1) ?></th>
                    <th width="150px;"><?= print_AdminRecordHead("uploads_folder", "Directory", $sb, $so, 1) ?></th>
                    <th colspan="2">&nbsp;</th>
                </TR>
            </thead>
            <tbody>
                <? if ($action == "Enter") { ?>
                    <TR>
                        <TD><input type="Text" name="username" size="20" value="<?= stripslashes($username) ?>"/></TD>
                        <TD><input type="Password" name="password" size="20" value="<?= stripslashes($password) ?>"/></TD>
                        <TD><input type="Text" name="full_name" size="20" value="<?= stripslashes($full_name) ?>"/></TD>
                        <TD><input type="Text" name="email" size="20" value="<?= stripslashes($email) ?>"/></TD>
                        <TD><?= createComboBoxFiltered("users_groups", "grp_id", "grp_name", $grp_id, "grp_id", "grp_id>1", "required") ?></TD>
                        <TD><input type="Text" name="uploads_folder" size="20" value="<?= stripslashes($uploads_folder) ?>"/></TD>
                        <TD><?= print_save_icon("Insert") ?></TD>
                        <TD colspan="1">&nbsp;</TD>
                    </TR>
                    <?
                }// Enter record
                while ($i < $numberOfRows) {
                    $user_id = MYSQL_RESULT($result, $i, "user_id");
                    $username = MYSQL_RESULT($result, $i, "username");
                    $password = MYSQL_RESULT($result, $i, "password");
                    $full_name = MYSQL_RESULT($result, $i, "full_name");
                    $email = MYSQL_RESULT($result, $i, "email");
                    $grp_id = MYSQL_RESULT($result, $i, "grp_id");
                    $user_desc = MYSQL_RESULT($result, $i, "user_desc");
                    $uploads_folder = MYSQL_RESULT($result, $i, "uploads_folder");
                    if ($action == "Edit" && $_REQUEST['user_id'] == $user_id) {
                        ?>
                        <TR>
                            <TD><input type="Text" name="username" size="20" value="<?= stripslashes($username) ?>" />
                                <input type="Hidden" name="user_id" size="20" value="<?= $user_id ?>" />
                            </TD>
                            <TD><input type="password" name="password" size="20" value="XXXXXXXX" /></TD>
                            <TD><input type="Text" name="full_name" size="20" value="<?= stripslashes($full_name) ?>" /></TD>
                            <TD><input type="Text" name="email" size="20" value="<?= stripslashes($email) ?>" /></TD>
                            <TD><?= createComboBoxFiltered("users_groups", "grp_id", "grp_name", $grp_id, "grp_id", "grp_id>1", "required") ?></TD>
                            <TD><input type="Text" name="uploads_folder" size="20" value="<?= stripslashes($uploads_folder) ?>"/></TD>
                            <TD><?= print_save_icon("Update") ?></TD>
                            <TD colspan="1">&nbsp;</TD>
                        </TR>
                    <?
                    }// Edit record
                    else {
                        ?>
                        <?
                        if ($user_id == 2) {
                            if ($_SESSION['USER'] == 2) {
                                ?>
                                <TR>
                                    <TD><?= stripslashes($username) ?></TD>
                                    <TD>******</TD>
                                    <TD><?= stripslashes($full_name) ?></TD>
                                    <TD><?= stripslashes($email) ?></TD>
                                    <TD><?= lookupField('users_groups', 'grp_id', 'grp_name', $grp_id); ?></TD>
                                    <TD><?= stripslashes($uploads_folder) ?></TD>

                                    <TD width="42" align="center"><?= print_edit_icon($_SERVER['PHP_SELF'] . "?action=Edit&user_id=" . $user_id) ?></TD>
                                    <? /*                                     * delete_grp_functions(part 1 of 2)******************************************* */ ?>
                                    <TD width="29" align="center"><? if ($user_id > 2) echo print_delete_ckbox($user_id); ?></TD>
                                <? //------------------------------------------------------- ?>
                                </TR>
            <? } ?>
        <? }else { ?>
                            <TR>
                                <TD><?= stripslashes($username) ?></TD>
                                <TD>******</TD>
                                <TD><?= stripslashes($full_name) ?></TD>
                                <TD><?= stripslashes($email) ?></TD>
                                <TD><?= lookupField('users_groups', 'grp_id', 'grp_name', $grp_id); ?></TD>
                                <TD><?= stripslashes($uploads_folder) ?></TD>

                                <TD width="42" align="center"><?= print_edit_icon($_SERVER['PHP_SELF'] . "?action=Edit&user_id=" . $user_id) ?></TD>
                                <? /*                                 * delete_grp_functions(part 1 of 2)******************************************* */ ?>
                                <TD width="29" align="center"><? if ($user_id > 2) echo print_delete_ckbox($user_id); ?></TD>
                            <? //-------------------------------------------------------  ?>
                            </TR>

                        <? } ?>

                        <?
                    }//end else
                    $i++;
                }//End While
                ?>
            </tbody>
        </TABLE>
        <br><br>
    </form>
</div>
<? include_once("../common/footer-admin.php"); ?>