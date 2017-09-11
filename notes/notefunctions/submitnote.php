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
        if (isset($_POST['note_name']) && (isset($_POST['uploadedtext']) || (count($_FILES) != 0))) {
            // Checkt of de notename voldoet aan de form eisen. Dit wordt gescheckt via formcheckers.php.

            if (checkNoteName($_POST['note_name'])) {

                $noteName = strip_tags($_POST['note_name']);
                $noteText = strip_tags($_POST['uploadedtext']);
                $noteFile = "";
                print_r($_FILES);
                if (count($_FILES) != 0) {

                    $target_dir = "../../uploads/";
                    $target_file = $target_dir . basename($_FILES["uploadedfile"]["name"]);
                    $uploadOk = true;


                    // Check if image file is a actual image or fake image{
                    if(!(empty($_FILES["uploadedfile"]))) {
                        $uploadOk = true;
                    } else {
                        echo "File upload failed.<br />";
                    }

                    if ((file_exists($target_file))) {
                        echo "Sorry file already exists.<br />";
                        $uploadOk = false;
                    }

                    if ($_FILES["uploadedfile"]["size"] > 50000000) {
                        echo "Your file is too large.<br />";
                        $uploadOk = false;
                    }
                    echo $_FILES['uploadedfile']['tmp_name'] . "<br/>";
                    echo basename($_FILES['uploadedfile']['name']);
                    if ($uploadOk == false) {
                        echo "Your file was not uploaded.<br />";
                    } else {
                        if (move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $target_file)) {
                            echo "The file " . basename($_FILES["uploadedfile"]["name"]) . " has been uploaded.<br />";
                            echo "<img src='$target_file' />";
                            $noteFile = 'uploads/' . $_FILES['uploadedfile']['name'];
                        } else {
                            echo "There was an error uploading your file.<br />";
                        }
                    }

                }
                $noteCategory = $_POST['selectedCategory'];

                if ($databaseConnect->uploadNote($_SESSION['userid'], $noteName, $noteText, $noteFile, $noteCategory)) {
                    header('Location: ' . '../note.php?noteadd=succes');
                }

            }
        }

    } else {
        // Add error handeling and redirect here
        echo "Error: Connection with database could not be established. Please try again later";
    }