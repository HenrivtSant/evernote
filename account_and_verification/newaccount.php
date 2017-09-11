<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:37
 */

if (!(isset($_SESSION))) {
    session_start();
}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../styling/styles.css">
        <title>Evernote - New Account</title>
    </head>
    <body>
    <header>
        <div class="titleContent">
            <h1>Start using Evernote</h1>
        </div>
    </header>

    <div class="content">
<?php

// Stap 1: Check input met de "check functies";
// Stap 2: Maak de construct met de class en category;
// Stap 3: Schrijf weg in de database;
// Stap 4: Meld een succesmelding aan de user als dit alles goed is gelukt;

    // Dit vangt newAccountFails op uit formsubmit.php
    if (isset($_GET['newaccountfail'])) {
        $newAccountFail = $_GET['newAccountFail'];
        if ($newAccountFail == 'novalue') {
            echo "<p>Make sure to enter a value</p>";
        } elseif ($newAccountFail == 'passwordusername') {
            echo "<p>Password or username does not meet the requirements</p>";
            // Hier nog de requirement laten zien
        } elseif ($newAccountFail == 'password') {
            echo "<p>Password is incorrect</p>";
        }
    }

?>
    <div class="forms">
        <h3>Choose a username and password</h3>
        <form method="post" action="formsubmit.php">
            <label><input type="text" name="initusrnm" placeholder="Username" required></label>
            <label><input type="password" name="initpassword" placeholder="Password" required></label>
            <label><input type="submit" name="submit" value="Submit"></label>
        </form>
        <br />
        <!-- Link in geval user al een account heeft -->
        <div class="linkButton">
            <a href="login.php">I already have an account</a>
        </div>
    </div>

    </div>
    <footer></footer>
    </body>
</html>
<?php