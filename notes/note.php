<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:33
 */

require_once "../config_and_connect/config.php";
require "../classes/category.php";
require "../classes/database.php";
require "../classes/note.php";

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../styling/styles.css">
    <title>Evernote - My Notes</title>
</head>
<body>
    <header>
        <div class="userLogIn">
            <!--Als de sessie met user live is wordt de user welkom geheten.-->
            <div id="welcomeMessage"><?php
                if (isset($_SESSION["name"])) {
                    echo "Welcome, ". $_SESSION["name"] . "!";
                    $sessionLive = true;
                }
                ?></div><?php

            // Log uit knop
            // Zit nog een buck in
            // Waarschijnlijk moet dit via een functie o.i.d.
            ?><div class="linkButton" id="logOutButton"><?php
                if (isset($sessionLive) && $sessionLive == true)  {
                    echo "<a href='../account_and_verification/logout.php'>Log out</a>";
                }
                ?></div>
        </div>

        <div class="titleContent">
            <h1>Evernote</h1>
            <h2>Your personal Notes</h2>
        </div>
    </header>
<?php

    // Check if the user is logged in, in the session
    ?><div class="notLoggedInForm"><?php
    if (!(isset($_SESSION["name"]))){
        header('Location: ' . '../index.php');
    }
    ?></div><?php



    ?><div class="navAfterLogin"><?php
    if (isset($sessionLive) && $sessionLive == true) {
        ?>
        <nav>
            <label class="menuLayerOne"><a href="../index.php">Home</a></label>
            <label class="menuLayerOne"><a href="note.php">My Notes</a></label>
            <label class="menuLayerOne"><a href="../account_and_verification/myaccount.php">My Account</a></label>
        </nav>
        <nav>
            <label class="menuLayerTwo"><a href="note.php?action=viewallnotes">View All Notes</a></label>
            <label class="menuLayerTwo"><a href="note.php?action=addnote">Add a note</a></label>
            <label class="menuLayerTwo"><a href="note.php?action=editnote">Edit a note</a></label>
        </nav>
        <?php
    }
    ?></div>
    <div class="content">
        <?php

    // Dit laat 10 nieuwste notes van de user zien
    if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
        $latestNotes = $databaseConnect->getLatestNotes($_SESSION['userid']);
        ?>
        <div class="lastFiveNotes">
        <h3>Your latest notes</h3>
        <table>
            <thead>
            <tr>
                <th>Filename</th>
                <th>Category</th>
                <th>Creation Date</th>
            </tr>
            </thead>
            <tbody>
        <?php
        while ($latestNotesResult = $latestNotes->fetch_object()) {
        ?>
            <tr>
                <td><a href="note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->note_name ?></a></td>
                <td><a href="note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->category ?></a></td>
                <td><a href="note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->date ?></a></td>
            </tr>
        <?php
        }
        ?>
            </tbody>
        </table>
        </div><?php
    }

    // Dit laat alle notes van de user zien
    if ((isset($_GET['action']) && $_GET['action'] == "viewallnotes") && (!(isset($_GET['download'])))) {
        include "notefunctions/viewall.php";
    }

    if (isset($_GET['download'])) {
        if (isset($_GET['action']) && $_GET['action'] == "viewallnotes") {

            require_once "../styling/vendor/autoload.php";

            // clear all previously generated html
            ob_clean();

            // start streaming pdf content to browser
            header("Content-type:application/pdf");

            // It will be called downloaded.pdf
            header("Content-Disposition:attachment;filename='downloaded.pdf'");

            // get content to display into a variable
            ob_start();
            include "notefunctions/viewall.php";
            $pdf_content = ob_get_clean();

            // strip all hrefs from content
            $pdf_content = preg_replace('/<a.*?>(.*)?<\/a>/i', '\1', $pdf_content);

            // and some more cleanup to keep henri happy :P
            $pdf_content = preg_replace('/Download overview/i', '', $pdf_content);

            $pdf = new CanGelis\PDF\PDF('/usr/bin/wkhtmltopdf');

            // and send to browser
            echo $pdf->loadHTML($pdf_content)->get();

            // do not generate any more output (in case a footer is coming)
            die;
        }
    }

    // Dit laat de user een nieuwe note maken
    if (isset($_GET['action']) && $_GET['action'] == "addnote") {
        include "notefunctions/addnote.php";
    }

    // Dit checkt voor een succesvolg geuploadde note
    if (isset($_GET['noteadd']) && $_GET['noteadd'] == "succes") {
        echo "Note added succesfully";
    } elseif (isset($_GET['noteupdate']) && $_GET['noteupdate'] == "succes") {
        echo "Note updated succesfully";
    }

    // Dit laat de user een note bewerken
    if (isset($_GET['action']) && $_GET['action'] == "editnote") {
        include "notefunctions/selectnote.php";
    }

    if (isset($_GET['note_id'])) {
        include "notefunctions/editnote.php";
    }

    if (isset($_GET['viewnote']) && (!(isset($_GET['download'])))) {
        include "notefunctions/viewone.php";
    }

    if (isset($_GET['download'])) {
        if (isset($_GET['viewnote'])) {

            require_once "../styling/vendor/autoload.php";

            // clear all previously generated html
            ob_clean();

            // start streaming pdf content to browser
            header("Content-type:application/pdf");

            // It will be called downloaded.pdf
            header("Content-Disposition:attachment;filename='downloaded.pdf'");

            // get content to display into a variable
            ob_start();
            include "notefunctions/viewone.php";
            $pdf_content = ob_get_clean();

            // strip all hrefs from content
            $pdf_content = preg_replace('/<a.*?>.*?<\/a>/i', '', $pdf_content);

            $pdf = new CanGelis\PDF\PDF('/usr/bin/wkhtmltopdf');

            // and send to browser
            echo $pdf->loadHTML($pdf_content)->get();

            // do not generate any more output (in case a footer is coming)
            die;
        }
    }

    if (isset($_GET['viewallnotesincategory'])) {
        include "notefunctions/viewallnotesincategory.php";
    }


?>
    </div>
<footer></footer>
</body>
</html>
