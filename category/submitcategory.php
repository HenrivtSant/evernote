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

require_once "../classes/database.php";
require_once "../account_and_verification/formcheckers.php";
require_once "../config_and_connect/config.php";


// Dit checkt eerst de connectie. Als de connectie niet kan worden gemaakt kan er ook geen nieuwe categorie worden gemaakt.
if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    //Check of alles voldoet aan de form eisen. Dit wordt gecheckt via formcheckers.php
    if (isset($_POST['category_name'])) {
        // Checkt of de categoryname voldoet aan de form eisen. Dit wordt gescheckt via formcheckers.php.

        if (checkNoteName($_POST['category_name'])) {
            $categoryName = strip_tags($_POST['category_name']);

            if ($databaseConnect->addCategory($_SESSION['userid'], $categoryName)) {
                header('Location: ' . '../account_and_verification/myaccount.php?categoryadd=succes');
            }

        }
    }

} else {
    // Add error handeling and redirect here
    echo "Error: Connection with database could not be established. Please try again later";
}