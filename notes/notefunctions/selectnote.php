<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:35
 */

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

require_once "../classes/database.php";
require_once "../config_and_connect/config.php";

if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    $filesToEdit = $databaseConnect->getNotes($_SESSION['userid'], "Off");
    ?>
    <!--Verberg de div met de niewste vijf notes, om verwarring te voorkomen.-->
    <style type="text/css">
        .lastFiveNotes {
            display: none;
        }
    </style>
        <div class="selectNote forms">
            <h3>Edit a note</h3>
                <p>Pick a note to edit</p>
        <form enctype = "multipart/form-data" method = "GET" action = "" name = "fileupload" >
            <select name = "note_id">
                <?php
                while ($fileToEdit = $filesToEdit->fetch_object()) {
                    ?>
                    <option value="<?php echo $fileToEdit->note_id ?>"><?php echo $fileToEdit->note_name ?></option>
                    <?php
                }
                ?>
            </select>
            <br/>
            <label><input type="submit" value="Submit"></label>
        </form>
        </div>
    <?php
} else {
    echo "Error: Connection with database could not be established. Please try again later";
}
?>