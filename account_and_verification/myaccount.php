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
            <h2>My Account</h2>
        </div>
    </header>
<?php

// Check if the user is logged in, in the session
?><div class="notLoggedInForm"><?php
if (!(isset($_SESSION["name"]))){
    header('Location: ' . '../index.php');
}
?></div>

    <div class="navAfterLogin"><?php
if (isset($sessionLive) && $sessionLive == true) {
    ?>
    <nav>
        <label class="menuLayerOne"><a href="../index.php">Home</a></label>
        <label class="menuLayerOne"><a href="../notes/note.php">My Notes</a></label>
        <label class="menuLayerOne"><a href="myaccount.php">My Account</a></label>
    </nav>
    <nav>
        <label class="menuLayerTwo"><a href="myaccount.php?action=addcategory">New Category</a> </label>
    </nav>
    <?php
}
?></div>
    <div class="content">
        <?php

        if (isset($_GET['categoryadd']) && $_GET['categoryadd'] == "succes") {
            echo "<p>Category added succesfully</p>";
        }

        include "../category/viewcategories.php";

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
                        <td><a href="../notes/note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->note_name ?></a></td>
                        <td><a href="../notes/note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->category ?></a></td>
                        <td><a href="../notes/note.php?viewnote=<?php echo $latestNotesResult->note_id ?>"><?php echo $latestNotesResult->date ?></a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            </div><?php
        }

        if (isset($_GET['viewallnotesincategory'])) {
            header('Location: ' . '../notes/note.php?viewallnotesincategory=' . $_GET['viewallnotesincategory']);
        }


        // Dit laat de user nieuwe categorieen aanmaken
        if (isset($_GET['action']) && $_GET['action'] == "addcategory") {
            include "../category/addcategory.php";
        }



?>
    </div>
    <footer></footer>
</body>
</html>