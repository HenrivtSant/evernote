<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:37
 */

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
        <title>Evernote - Login</title>
    </head>
    <body>
    <header>
        <div class="titleContent">
            <h1>Member login</h1>
        </div>
    </header>

    <div class="content">

    <?php

    // Dit vangt loginfails op uit formsubmit.php
    if (isset($_GET['loginfail'])) {
        $loginFail = $_GET['loginfail'];
        if ($loginFail == 'novalue') {
            echo "<p>Make sure to enter a value</p>";
        } elseif ($loginFail == 'passwordusername') {
            echo "<p>Password or username does not meet the requirements</p>";
            // Hier nog de requirement laten zien
        } elseif ($loginFail == 'password') {
            echo "<p>Password is incorrect</p>";
        }
    }
    ?>
     <div class="forms">
        <h3>Fill in your username and password</h3>

        <form method="post" action="formsubmit.php">
            <label><input type="text" name="usrnm" placeholder="Username" required></label>
            <label><input type="password" name="password" placeholder="Password" required></label>
            <label><input type="submit" name="submit" value="Login"></label>
        </form>

        <!-- Link voor vergeten wachtwoord of gebruikersnaam
         Deze is overigens nog niet gemaakt -->
        <div class="linkButton" id="buttonLeft">
            <a href="#">Forgot password or username</a>
        </div>
        <!-- Link naar maken nieuw account -->
        <div class="linkButton" id="buttonRight">
            <a href="newaccount.php">I don't have an account yet</a>
        </div>
     </div>

    </div>
    <footer></footer>
    </body>
</html>
<?php