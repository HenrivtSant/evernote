<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30-8-2017
 * Time: 14:56
 */

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

require_once "../../classes/database.php";
require_once "../../account_and_verification/formcheckers.php";
require_once "../../config_and_connect/config.php";


// Dit checkt eerst de connectie. Als de connectie niet kan worden gemaakt kan er ook geen nieuwe note worden gemaakt.
if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    //Check of alles voldoet aan de form eisen. Dit wordt gecheckt via formcheckers.php
    if (isset($_POST['note_id']) && isset($_POST['note_name']) && (isset($_POST['uploadedtext']) || (count($_FILES) != 0))) {
        //Checkt of de POST data niet is gemanipuleerd en de user dus een bestand gaat bewerken wat niet van hem is
        if ($ownerCheck = $databaseConnect->getNote($_POST['note_id'])) {
            $owner = $ownerCheck->fetch_object();
            var_dump($owner);
            echo $owner->user_id;
            echo $_SESSION['userid'];
            if ($owner->user_id == $_SESSION['userid']) {

                // Checkt of de notename voldoet aan de form eisen. Dit wordt gescheckt via formcheckers.php.
                if (checkNoteName($_POST['note_name'])) {

                    $noteName = strip_tags($_POST['note_name']);
                    $noteText = strip_tags($_POST['uploadedtext']);
                    $noteFile = "";
                    if (count($_FILES) != 0) {
                        // get file and move like in the previous example
                        $noteFile = 'uploaded/image.jpg';  //$_POST['uploadedfile'];
                    }
                    $noteCategory = $_POST['selectedCategory'];

                    if ($databaseConnect->updateNote($_POST['note_id'], $noteName, $noteText, $noteFile, $noteCategory)) {
                        header('Location: ' . '../note.php?noteupdate=succes');
                    }

                }
            } else {
                echo "<p>You do not have the rights to this file, choose one of your own files.</p>";
                include "notefunctions/selectnote.php";
            }
        }
    }

} else {
    // Add error handeling and redirect here
    echo "Error: Connection with database could not be established. Please try again later";
}