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
    ?>
        <div class="editnote forms">
            <h3>Edit a note</h3>
                <p>Edit and save</p>
            <?php
            if (isset($_GET['note_id'])) {
                $categoriesResult = $databaseConnect->getCategory($_SESSION['userid']);
                $noteResult = $databaseConnect->getNote($_GET['note_id']);
                $note = $noteResult->fetch_object();
                if ($note->user_id == $_SESSION['userid']) {
                    ?>
                    <style type="text/css">
                        .selectNote {
                            display: none;
                        }
                        /*Verberg de div met de niewste vijf notes, om verwarring te voorkomen.*/
                        .lastFiveNotes {
                            display: none;
                        }
                    </style>
                    <form enctype="multipart/form-data" method="post" action="notefunctions/updatenote.php"
                          name="fileupload">
                        <label><input type="text" name="note_name" placeholder="Give your note a name"
                                      value="<?php echo $note->note_name ?>" required></label><br/>
                        <textarea name="uploadedtext" placeholder="Enter your text here" rows="5"
                                  cols="35"><?php echo $note->text ?></textarea><br/>
                        <label><input type="file" name="uploadedfile" placeholder="Upload a file"></label><br/>
                        <input name="note_id" value="<?php echo $_GET['note_id'] ?>" hidden>
                        <select name="selectedCategory">
                            <?php
                            while ($categories = $categoriesResult->fetch_object()) {
                                if ($categories->cat_id == $note->cat_id) {
                                    ?>
                                    <option value="<?php echo $categories->cat_id ?>"
                                            selected><?php echo $categories->category ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option
                                        value="<?php echo $categories->cat_id ?>"><?php echo $categories->category ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <br/>
                        <label><input type="submit" value="Upload"></label>
                    </form>
                    <?php
                } else {
                    echo "<p>You do not have the rights to this file, choose one of your own files.</p>";
                    include "notefunctions/selectnote.php";
                }
            }
            ?>
        </div>
    <?php
} else {
    echo "Error: Connection with database could not be established. Please try again later";
}
?>