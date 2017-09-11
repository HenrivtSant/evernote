<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:33
 */

require "classes/category.php";
require "classes/database.php";
require "classes/note.php";
require "classes/user.php";

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styling/styles.css">
    <title>Evernote</title>
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
                    echo "<a href='account_and_verification/logout.php'>Log out</a>";
                }
                ?></div>
        </div>

        <div class="titleContent">
            <h1>Evernote</h1>
        </div>
    </header>

    <div class="navAfterLogin"><?php
        if (isset($sessionLive) && $sessionLive == true) {
            ?>
            <nav>
                <label class="menuLayerOne"><a href="notes/note.php">My Notes</a></label>
                <label class="menuLayerOne"><a href="account_and_verification/myaccount.php">My Account</a></label>
            </nav>
            <?php
        }
        ?></div>

    <div class="content">
<?php

    // Check if the user is logged in, in the session
    ?><div class="notLoggedInForm"><?php
    if (!(isset($_SESSION["name"]))){
        echo "<p>You are not logged in.</p>";
        echo "<div class='linkButton'>";
            echo "<a href='account_and_verification/login.php'>Log in</a>";
        echo "</div><div class='linkButton'>";
            echo "<a href='account_and_verification/newaccount.php'>I do not have an account yet</a>";
        echo "</div>";
    }
    ?></div><?php





    ?>
    </div>
<footer></footer>
</body>
</html>
